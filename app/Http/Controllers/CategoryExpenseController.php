<?php

namespace App\Http\Controllers;

use App\Models\CategoryExpense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryExpenseController extends Controller {

    protected $categoryExpense;
    public function __construct(CategoryExpense $categoryExpense){
        $this->categoryExpense = $categoryExpense;
    }

    public function index(): JsonResponse{
        return response()->json($this->categoryExpense->query()->orderBy('category_expense')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->categoryExpense->rules(),
            $this->categoryExpense->messages(),
        );

        try {
            $categoryExpense = $this->categoryExpense->query()->create($validatedData);
            return response()->json($categoryExpense, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $categoryExpense = $this->categoryExpense->query()->find($id);

        if (!$categoryExpense) {
            return response()->json([
                'error' => 'A categoria informada não existe na base de dados.'
            ], 404);
        }

        return response()->json($categoryExpense);
    }

    public function update(Request $request, int $id): JsonResponse {
        $categoryExpense = $this->categoryExpense->query()->find($id);

        if (!$categoryExpense) {
            return response()->json([
                'error' => 'A categoria informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->categoryExpense->rules(true),
            $this->categoryExpense->messages(),
        );

        $categoryExpenseExists = $this->categoryExpense->query()
            ->where('category_expense', $validatedData['category_expense'])
            ->where('id', '<>', $id)
            ->exists();

        if ($categoryExpenseExists) {
            return response()->json([
                'error' => 'A categoria informada já existe na base de dados.'
            ], 422);
        }

        try {
            $categoryExpense->update($validatedData);
            return response()->json($categoryExpense);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy(int $id): JsonResponse {
        $categoryExpense = $this->categoryExpense->query()->find($id);

        if (!$categoryExpense) {
            return response()->json([
                'error' => 'A categoria informada não existe na base de dados.'
            ], 404);
        }

        try {
            $categoryExpense->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }
}
