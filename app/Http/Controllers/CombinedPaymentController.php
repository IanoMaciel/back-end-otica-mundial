<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CombinedPayment;
use App\Models\FormPayment;
use App\Models\PaymentPortion;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CombinedPaymentController extends Controller {

    protected $combinedPayment;
    public function __construct(CombinedPayment $combinedPayment) {
        $this->combinedPayment = $combinedPayment;
    }

    public function index(Request $request): JsonResponse{
        $combinedPayments = $this->combinedPayment->query()
            ->with('sale', 'portions')
            ->orderBy('created_at', 'desc');
        $perPage = $request->get('per_page', 10);
        return response()->json($combinedPayments->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $data = $request->validate(
            $this->combinedPayment->rules(),
            $this->combinedPayment->messages(),
        );

        # a soma das parcelas não deve ser menor que o valor da venda
        $sum = 0;
        foreach ($data['portions'] as $portion) {
            $sum += $portion['amount'];
        }

        $discount = $validatedData['discount'] ?? null;
        $totalAmount = Sale::query()->find($data['sale_id'])->getAttribute('total_amount');

        if($sum < $totalAmount) {
            return response()->json([
                'error' => 'A soma dos valores não corresponde com o valor da compra'
            ], 422);
        }

        if($discount != 'null')  $totalAmount = $totalAmount - ($discount * ($discount/10));

        $data = array_merge($data, [
            'total_amount' => $totalAmount,
            'discount' => $discount,
        ]);

        try {
            DB::beginTransaction();

            $combinedPayment = CombinedPayment::query()->create($data);

            foreach ($data['portions'] as $portion) {
                $interestRate = $portion['card_id'] ?? 0 ? Card::query()->find($portion['card_id'])->getAttribute('interest_rate') : 0;
                $portion['amount'] += ($portion['amount'] * ($interestRate/100));

                PaymentPortion::query()->create([
                    'combined_payment_id' => $combinedPayment->id,
                    'form_payment_id' => $portion['form_payment_id'],
                    'card_id' => $portion['card_id'] ?? null,
                    'amount' => $portion['amount']
                ]);
            }

            DB::commit();

            return response()->json($combinedPayment->load('portions'), 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $combinedPayments = $this->combinedPayment->query()
            ->with('sale', 'portions')
            ->find($id);

        if (!$combinedPayments) {
            return response()->json([
                'error' => 'O Pagamento informado não existe na base de dados.'
            ], 404);
        }

        $response = $combinedPayments->toArray();

        $response['portions'] = $combinedPayments->portions->map(function($portion) {
            $formPayment = FormPayment::query()->find($portion->form_payment_id) ?? null;
            $card = Card::query()->find($portion->card_id) ?? null;
            return [
                'id' => $portion->id,
                'form_payment_id' =>  $formPayment->form_payment ?? null,
                'card_id' => $card ? [
                    'number_installment' => $card->number_installment,
                    'interest_rate' => $card->interest_rate,
                ] : null,
                'amount' => $portion->amount,
                'created_at' => $portion->created_at,
                'updated_at' => $portion->updated_at,
            ];
        });

        return response()->json($response);
    }

}
