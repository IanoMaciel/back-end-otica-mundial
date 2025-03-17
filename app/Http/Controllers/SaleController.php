<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Frame;
use App\Models\Lens;
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
        $query = $this->sale->with('customer', 'user', 'paymentMethod', 'frames', 'services', 'lenses', 'creditCards', 'paymentCredits', 'combinedPayment')
            ->orderBy('created_at', 'desc');

        if ($status = $request->input('status')) {
            $query->where(function ($q) use ($status) {
                $q->where('status', 'LIKE', "%$status%");
            });
        }

        if ($ata = $request->input('number_ata')) {
            $query->where(function ($q) use ($ata) {
                $q->where('number_ata', 'like', '%' . $ata . '%');
            });
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('frames', function ($query) use ($search) {
                    $query->where('code', 'LIKE', "%$search%");
                })->orWhereHas('services', function ($query) use ($search) {
                   $query->where('name', 'LIKE', "%$search%");
                })->orWhereHas('lenses', function ($query) use ($search) {
                    $query->where('name_lens', 'LIKE', "%$search%");
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


    public function show(int $id): JsonResponse {
        $sale = $this->sale->query()
            ->with(
                'customer',
                'user',
                'paymentMethod',
                'frames',
                'services',
                'lenses',
                'creditCards',
                'paymentCredits',
                'combinedPayment',
                'cashPromotions',
                'creditPromotions'
            )
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

        $lenses = Lens::query()
            ->where('name_lens', 'LIKE', "%$search%")
            ->get();

        return response()->json([
            'frames' => $frames,
            'services' => $services,
            'lenses' => $lenses,
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
        return $user->is_admin ?: false;
    }
}
