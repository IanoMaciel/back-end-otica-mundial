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

        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);


        $gains = $this->sale->query()
            ->where('status', 'Pago')
            ->whereYear('date_sale', $year)
            ->whereMonth('date_sale', $month)
            ->sum('total_amount');


        $gainsStatusPending = $this->sale->query()
            ->where('status', 'Pendente')
            ->whereYear('date_sale', $year)
            ->whereMonth('date_sale', $month)
            ->sum('total_amount');

        $expenseWithCategory = $this->expense->query()
            ->join('category_expenses', 'expenses.category_expense_id', '=', 'category_expenses.id')
            ->where('category_expenses.category_expense', 'Retirada')
            ->whereYear('expenses.date_proof', $year)
            ->whereMonth('expenses.date_proof', $month)
            ->sum('expenses.total_amount');

        // Para $expenses, crie uma nova query
        $expenses = $this->expense->query()
            ->join('category_expenses', 'expenses.category_expense_id', '=', 'category_expenses.id')
            ->where('category_expenses.category_expense', '!=', 'Retirada')
            ->whereYear('expenses.date_proof', $year)
            ->whereMonth('expenses.date_proof', $month)
            ->sum('expenses.total_amount');

        $paymentMethods = $this->sale->query()
            ->join('payment_methods', 'sales.payment_method_id', '=', 'payment_methods.id')
            ->whereYear('sales.date_sale', $year)
            ->whereMonth('sales.date_sale', $month)
            ->select('payment_methods.payment_method')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('SUM(sales.total_amount) as value')
            ->groupBy('payment_methods.payment_method')
            ->get();

        return response()->json([
            'gains' => $gains,
            'gainsPending' => $gainsStatusPending,
            'expense_with_category' => $expenseWithCategory,
            'expense' => $expenses,
            'balance' => $gains - $expenses - $expenseWithCategory,
            'payment_methods'=> $paymentMethods,
        ]);
    }
}
