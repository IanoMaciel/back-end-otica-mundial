<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CombinedPayment;
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
        $validatedData = $request->validate(
            $this->combinedPayment->rules(),
            $this->combinedPayment->messages(),
        );

        $discount = $validatedData['discount'] ?? null;
        $totalAmount = Sale::query()->find($validatedData['sale_id'])->total_amount;

        if($discount != 'null') {
            $totalAmount = $totalAmount - ($discount * ($discount/10));
        }

        $data = array_merge($validatedData, [
            'total_amount' => $totalAmount,
            'discount' => $discount,
        ]);

        try {
            DB::beginTransaction();

            $combinedPayment = CombinedPayment::query()->create($data);

            foreach ($data['portions'] as $portion) {
                $interestRate = $portion['card_id'] ?? 0 ? Card::query()->find($portion['card_id'])->interest_rate : 0;
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
}
