<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Frame;
use App\Models\PaymentMethod;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller {

    protected $sale;
    public function __construct(Sale $sale) {
        $this->sale = $sale;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        $query = $this->sale
            ->with('customer', 'user', 'paymentMethod', 'frames', 'services', 'creditCards')
            ->orderBy('created_at', 'desc');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('frames', function ($query) use ($search) {
                    $query->where('code', 'LIKE', "%$search%");
                })->orWhereHas('services', function ($query) use ($search) {
                   $query->where('name', 'LIKE', "%$search%");
                });
            });
        }

        $filterType = $request->get('type');
        if($filterType) {
            $query->whereHas($filterType === 'frame' ? 'frames' : 'services');
        }

        $perPage = $request->get('per_page', 10);
        $sales = $query->paginate($perPage);
        return response()->json($sales);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->sale->rules(),
            $this->sale->messages(),
        );

        foreach ($validatedData['items'] as $item) {
            if ($item['type'] === 'frame') {
                $frame = Frame::query()->find($item['id']);

                if ($item['discount'] > $frame->brands->discount) {
                    return response()->json([
                        'error' => 'O desconto aplicado na armação deve ser igual ou inferior a ' . $frame->brands->discount . '%',
                    ], 422);
                }

                if (!$frame) {
                    return response()->json([
                        'error' => 'O produto informado não existe na base de dados.',
                    ], 404);
                }

                if ($frame->amount < $item['quantity']) {
                    return response()->json([
                        'error' => 'O produto (CÓDIGO DA ARMAÇÃO: ' . $frame->code . ') não possui estoque suficiente para realizar a venda.',
                    ], 422);
                }
            }
        }

        $paymentMethod = PaymentMethod::query()->find($validatedData['payment_method_id']);

        try {

            $sale = $this->sale->query()->create($validatedData);
            $totalAmount = 0;
            foreach ($validatedData['items'] as $item) {
                $model = $item['type'] === 'frame' ? Frame::class : Service::class;
                $sellable = $model::query()->find($item['id']);

                if (!$sellable) {
                    return response()->json([
                        'error' => 'O item informado não existe na base de dados.',
                    ], 404);
                }

                $itemTotal = ($sellable->price - ($sellable->price * ($item['discount']/100))) * $item['quantity'];

                $sale->items()->create([
                    'sellable_type' => $model,
                    'sellable_id' => $sellable->id,
                    'quantity' => $item['quantity'],
                    'price' => $sellable->price,
                    'discount' => $item['discount'],
                    'total' => $itemTotal
                ]);

                if ($item['type'] === 'frame') {
                    $sellable->amount -= $item['quantity'];
                    $sellable->save();
                }

                $totalAmount += $itemTotal;
            }
            $sale->total_amount = $totalAmount;

            if ($paymentMethod->payment_method === 'Crediário da Loja' || $paymentMethod->payment_method === 'Cartão de Crédito') {
                $sale->status = 'Pendente';
            } else {
                $sale->status = 'Pago';
            }

            $sale->save();

            return response()->json($sale->load([
                'customer',
                'user', 'paymentMethod', 'frames', 'services'
            ]), 201);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {
        $sale = $this->sale->query()
            ->with('customer', 'user', 'paymentMethod', 'frames', 'services', 'creditCards')
            ->find($id);

        $agreementID = $sale->customer->agreement_id ?? null;
        $agreement = null;

        if ($agreementID) $agreement = Agreement::query()->find($agreementID)->agreement ?? null;

        if (!$sale) {
            return response()->json([
                'error' => 'A venda informada não existe na base de dados.'
            ], 404);
        }

        return response()->json([
            $sale,
            'agreement' => $agreement
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $sale = $this->sale->query()
            ->with('customer', 'user', 'paymentMethod', 'frames', 'services')
            ->find($id);

        if (!$sale) {
            return response()->json([
                'error' => 'A venda informada não existe na base de dados.'
            ], 404);
        }

        try {
            $sale->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function searchStock(Request $request): JsonResponse {
        $search = $request->input('search');

        $frames = Frame::query()
            ->where('code', 'LIKE', "%$search%")
            ->get();

        $services = Service::query()
            ->where('name', 'LIKE', "%$search%")
            ->get();

        return response()->json([
            'frames' => $frames,
            'services' => $services,
        ]);
    }


    public function deleteMultiple(Request $request) {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:sales,id'
            ],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.array' => 'O campo id é do tipo array.',
                'id.*.integer' => 'O id deve ser um número inteiro.',
                'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.'
            ]
        );

        try {
            $this->sale->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @return bool
     */
    private function isAuthorization(): bool {
        $user = Auth::user();
        return $user->getAttribute('is_admin') ?: false;
    }
}
