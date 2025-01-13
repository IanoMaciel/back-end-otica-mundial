<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CreditCard;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller {

    protected $creditCard;

    public function __construct(CreditCard $creditCard) {
        $this->creditCard = $creditCard;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->creditCard->query()->with('sale', 'card');
        $perPage = $request->get('per_page', 10);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->creditCard->rules(), $this->creditCard->messages());

        $sale = Sale::query()->find($validatedData['sale_id']);
        $card = Card::query()->find($validatedData['card_id']);
        $user = Auth::user();

        $discountSaller = $validatedData['discount'] ?? 0;

        $totalAmount = $sale->total_amount + ($sale->total_amount * ($card->interest_rate/100)); // calcula a taxa da máquinetaaaa

        if ($discountSaller > $user->discount) {
            return response()->json([
                'error' => 'Olá, '.$user->first_name.'. O valor do desconto informado deve ser menor ou igual ' .$user->discount.'%.',
            ], 422);
        }

        if ($discountSaller) {
            $totalAmount -= ($totalAmount * ($discountSaller/100));
        }

        $data = array_merge($validatedData, [
            'total_amount' => $totalAmount
        ]);

        try {
            $creditCard = $this->creditCard->query()->create($data);
            return response()->json($creditCard->load('sale', 'card'), 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
