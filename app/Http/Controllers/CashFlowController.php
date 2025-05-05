<?php

namespace App\Http\Controllers;

use App\Models\Expense;
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
            ->with([
                'customer',
                'user',
                'paymentMethod',
                'frames',
                'services',
                'lenses',
                'creditCards',
                'paymentCredits',
                'combinedPayment',
                'cashPromotions.formPayment',
                'cashPromotions.promotion',
                'creditPromotions.promotion'
            ])
            ->whereDate('created_at', $date);

        if ($status = $request->input('status')) {
            $query->where(function ($q) use ($status) {
                $q->where('status', 'LIKE', "%$status");
            });
        }

        $perPage = $request->get('per_page', 10);
        $sales = $query->paginate($perPage);

        $gains = $query->where('status', 'Pago')->sum('total_amount');
        $expenses = Expense::query()
            ->with('categoryExpenses')
            ->where('')
            ->whereDate('date_proof', $date);


        $pending = $query->where('status', 'Pendente')->sum('total_amount');
        $cancel = $query->where('status', 'Cancelado')->sum('total_amount');

        $perPage = $request->get('per_page', 10);

        return response()->json([
            'panel' => [
                'gains' => $gains,
                'withdrawal' => 12300.00,
                'expenses' => 123213,
                'balance' => 123123
            ],
            'sales' => $sales
        ]);
    }
}
