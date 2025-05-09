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

        $filter = $request->query('filter');
        if ($filter === 'expenses') {
            $expense = Expense::query()
                ->with(['categoryExpenses'])
                ->whereDate('date_proof', $date);

            if ($status = $request->input('status')) {
                $expense->whereHas('categoryExpenses', function ($query) use ($status) {
                    $query->where('category_expense', 'LIKE', "%$status%");
                });
            }

            $perPage = $request->get('per_page', 10);
            $data = $expense->paginate($perPage);
        } else {
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
                ->whereDate('date_sale', $date);

            if ($status = $request->input('status')) {
                $query->where(function ($q) use ($status) {
                    $q->where('status', 'LIKE', "%$status");
                });
            }

            $perPage = $request->get('per_page', 10);
            $data = $query->paginate($perPage);
        }

        $gains = $this->sale->query()->whereDate('date_sale', $date);

        $totalGains = $gains->where('status', 'Pago')->sum('total_amount');

        $totalExpenses = Expense::query()
            ->whereDate('date_proof', $date)
            ->sum('total_amount');

        $totalWithdrawal = Expense::query()
            ->whereHas('categoryExpenses', function ($query) {
                $query->where('category_expense', 'Retirada');
            })
            ->whereDate('date_proof', $date)
            ->sum('total_amount');

        return response()->json([
            'panel' => [
                'gains' => $totalGains,
                'withdrawal' => $totalWithdrawal,
                'expenses' => $totalExpenses,
                'balance' => $totalGains - $totalWithdrawal - $totalExpenses,
            ],
            'data' => $data
        ]);
    }
}
