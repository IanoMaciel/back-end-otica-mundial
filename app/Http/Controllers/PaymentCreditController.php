<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\PaymentCredit;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentCreditController extends Controller {

    protected $paymentCredit;

    public function __construct(PaymentCredit $paymentCredit){
        $this->paymentCredit = $paymentCredit;
    }

    public function index(Request $request): JsonResponse {
        $paymentCredit = $this->paymentCredit->query()
            ->with('installments')
            ->orderBy('created_at', 'desc');

        $perPage = $request->get('per_page', 10);
        return response()->json($paymentCredit->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->paymentCredit->rules(),
            $this->paymentCredit->messages(),
        );

        $data = array_merge($validatedData, [
           'total_amount' => Sale::query()->find($validatedData['sale_id'])->total_amount,
        ]);

        $sum = 0.0;
        foreach ($data['installments'] as $installment) {
            $sum += $installment['amount'];
        }
        $sum += $data['down_payment'];

        if ($sum < $data['total_amount']) {
            return response()->json([
                'error' => 'A soma dos valores das parcelas precisam ser igual ao valor da compra.'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $paymentCredit = $this->paymentCredit->query()->create($data);

            $count = 1;
            foreach ($data['installments'] as $installment) {
                Installment::query()->create([
                    'installment' => $count++,
                    'payment_credit_id' => $paymentCredit->id ?? 1,
                    'form_payment_id' => $installment['form_payment_id'] ?? null,
                    'card_id' => $installment['card_id'] ?? null,
                    'due_date' => $installment['due_date'],
                    'amount' => $installment['amount'],
                ]);
            }

            DB::commit();

            return response()->json($paymentCredit->load('installments'), 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $paymentCredit = $this->paymentCredit->query()->with('installments')->find($id);

        if (!$paymentCredit) {
            return response()->json([
                'error' => 'O Pagamento no Crediário informado não existe na base de dados.',
            ], 404);
        }

        return response()->json($paymentCredit);
    }

    public function destroy(int $id): JsonResponse {
        $paymentCredit = $this->paymentCredit->query()->with('installments')->find($id);

        if (!$paymentCredit) {
            return response()->json([
                'error' => 'O Pagamento no Crediário informado não existe na base de dados.',
            ], 404);
        }

        try {
            $paymentCredit->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
