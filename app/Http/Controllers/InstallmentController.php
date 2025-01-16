<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Installment;
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

        $card = Card::query()->findOrFail($validatedData['card_id'])->interest_rate ?? null;

        try {
//            $installment->update($validatedData);
            return response()->json($installment);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
