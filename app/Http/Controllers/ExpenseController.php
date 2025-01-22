<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller {

    protected $expense;
    public function __construct(Expense $expense){
        $this->expense = $expense;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->expense->query()->with('categoryExpenses')->orderBy('date_proof', 'desc');
        $perPage = $request->get('per_page', 10);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->expense->rules(), $this->expense->messages());
        $proof = [];

        try {
            if ($request->hasFile('proof')) {
                foreach ($request->file('proof') as $file) {
                    $fileUrn = $file->store('images', 'public');
                    $validatedData['proof'] = $fileUrn;
                    $expense = $this->expense->query()->create($validatedData);
                    $proof[] = $expense;
                }
            } else {
                $validatedData['proof'] = null;
                $expense = $this->expense->query()->create($validatedData);
                $proof[] = $expense;
            }
            return response()->json($proof, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
