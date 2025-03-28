<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller {

    protected $sale;
    protected $expense;


    public function __construct(
        Sale $sale, Expense $expense) {
        $this->sale = $sale;
        $this->expense = $expense;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->sale->query();

        $paymentMethods = $query
            ->join('payment_methods', 'sales.payment_method_id', '=', 'payment_methods.id')
            ->select('payment_methods.payment_method')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('SUM(sales.total_amount) as value')
            ->groupBy('payment_methods.payment_method')
            ->get();

        return response()->json([
            'payment_methods'=> $paymentMethods
        ]);
    }

}
