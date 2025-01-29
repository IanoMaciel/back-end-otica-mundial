<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Installment;
use App\Models\PaymentCredit;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstallmentController extends Controller {

    protected $installment;

    public function __construct(Installment $installment) {
        $this->installment = $installment;
    }

    public function show(int $id): JsonResponse {
        $installment = $this->installment->query()
            ->with( 'formPayment', 'card', 'paymentCredit')
            ->find($id);

        if (!$installment) {
            return response()->json([
                'error' => 'A parcela informada não existe na base de dados.'
            ], 404);
        }

        return response()->json($installment);
    }

    public function update(Request $request, int $id): JsonResponse {
        $installment = $this->installment->query()
            ->with( 'formPayment', 'card', 'paymentCredit')
            ->find($id);

        if (!$installment) {
            return response()->json([
                'error' => 'A parcela informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->installment->rules(),
            $this->installment->messages(),
        );

        $cardID = $validatedData['card_id'] ?? null;
        if ($cardID != null) {
            $card = Card::query()->findOrFail($validatedData['card_id'])->interest_rate;
            $validatedData['amount'] += $validatedData['amount'] * ($card/100);

            $validatedData = array_merge($validatedData, [
                'amount' => $validatedData['amount'],
            ]);
        }

        try {
            $installment->update($validatedData);

            # verifica se todos as parcelas estão pagas e atualiza o status da venda para "pago"
            $paymentCredit = PaymentCredit::query()->with('installments')->find($validatedData['payment_credit_id']);
            $sale = Sale::query()->find($paymentCredit->sale_id);

            if ($paymentCredit && $sale) {
                $allInstallmentsPaid = $paymentCredit->installments->every(function ($installment) {
                    return $installment->status === "Pago";
                });

                if ($allInstallmentsPaid) {
                    $sale->status = "Pago";
                    $sale->save();
                }
            }

            return response()->json($installment);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
