<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CardController extends Controller {

    protected $card;
    public function __construct(Card $card){
        $this->card = $card;
    }

    public function index(): JsonResponse{
        return response()->json($this->card->query()->orderBy('number_installment')->get());
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate($this->card->rules(), $this->card->messages());
        try {
            $card = $this->card->query()->create($validatedData);
            return response()->json($card, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function show(int $id): JsonResponse{
        $card = $this->card->query()->find($id);
        if (!$card) {
            return response()->json([
                'error' => 'O cartão informado não existe na base de dados.',
            ], 404);
        }
        return response()->json($card);
    }

    public function update(Request $request, int $id): JsonResponse{
        $card = $this->card->query()->find($id);
        if (!$card) {
            return response()->json([
                'error' => 'O cartão informado não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate($this->card->rules(true), $this->card->messages());

        $numberInstallmentExists = $this->card->query()
            ->where('number_installment', $validatedData['number_installment'])
            ->where('id', '<>', $id)
            ->exists();

        if($numberInstallmentExists) {
            return response()->json([
                'error' => 'O número de parcelas já está cadastrado na base de dados.',
            ], 422);
        }

        try {
            $card->update($validatedData);
            return response()->json($card);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }

    public function destroy(int $id): JsonResponse{
        $card = $this->card->query()->find($id);
        if (!$card) {
            return response()->json([
                'error' => 'O cartão informado não existe na base de dados.',
            ], 404);
        }

        try {
            $card->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
