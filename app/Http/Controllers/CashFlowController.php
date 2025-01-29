<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashFlowController extends Controller {
    protected $sale;

    public function __construct(Sale $sale) {
        $this->sale = $sale;
    }

    public function cashFlow(Request $request): JsonResponse {
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::today();

        $query = $this->sale
            ->query()
            ->with('customer', 'user', 'paymentMethod', 'frames', 'services', 'creditCards', 'paymentCredits', 'combinedPayment')
            ->whereDate('created_at', $date);

        $gains = $query->sum('total_amount');

        $perPage = $request->get('per_page', 10);

        return response()->json([
            'gains' => $gains,
            'expenses' => 123,
            'previous_balance' => 123,
            'current_balance' => 12,
            'cash_flow' => $query->paginate($perPage)
        ]);
    }
}
