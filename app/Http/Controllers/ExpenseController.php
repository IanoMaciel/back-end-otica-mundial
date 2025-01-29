<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Proof;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller {

    protected $expense;
    public function __construct(Expense $expense){
        $this->expense = $expense;
    }

    public function index(Request $request): JsonResponse {
        $query = $this->expense->query()->with('categoryExpenses', 'proofs')->orderBy('date_proof', 'desc');
        $perPage = $request->get('per_page', 10);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->expense->rules(), $this->expense->messages());
        $proof = [];

        try {
            $expense = $this->expense->query()->create($validatedData);

            if ($request->hasFile('proofs')) {
                foreach ($validatedData['proofs'] as $file) {
                    $fileUrn = $file->store('images', 'public');
                    $proofItem = Proof::query()->create([
                        'expense_id' => $expense->id,
                        'proof' => $fileUrn
                    ]);
                    $proof[] = $proofItem;
                }
            }
            return response()->json([
                'expense' => $expense,
                'proof' => $proof
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $expense = $this->expense->query()->with('categoryExpenses', 'proofs')->find($id);

        if(!$expense) {
            return response()->json([
                'error' => 'A despesa informada não existe na base de dados.'
            ], 404);
        }

        return response()->json($expense);
    }

    public function update(Request $request, int $id): JsonResponse {
        $expense = $this->expense->query()->find($id);

        if (!$expense) {
            return response()->json([
                'error' => 'A despesa informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate($this->expense->rules($id), $this->expense->messages());
        $proof = [];

        try {
            $expense->update($validatedData);

            if ($request->hasFile('proofs')) {
                $expense->proofs()->delete();

                foreach ($validatedData['proofs'] as $file) {
                    $fileUrn = $file->store('images', 'public');
                    $proofItem = Proof::query()->create([
                        'expense_id' => $expense->id,
                        'proof' => $fileUrn
                    ]);
                    $proof[] = $proofItem;
                }
            }

            return response()->json([
                'expense' => $expense,
                'proof' => $proof
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $expense = $this->expense->query()->with('categoryExpenses', 'proofs')->find($id);

        if(!$expense) {
            return response()->json([
                'error' => 'A despesa informada não existe na base de dados.'
            ], 404);
        }

        try {
            $expense->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
