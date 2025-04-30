<?php

namespace App\Http\Controllers;

use App\Models\Card;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller {

    protected $card;
    public function __construct(Card $card){
        $this->card = $card;
    }

    public function all(): JsonResponse{
        return response()->json($this->card->query()->orderBy('number_installment')->get());
    }

    public function index(Request $request): JsonResponse{
        $cards = $this->card->query()->orderBy('number_installment');
        $perPage = $request->get('per_page', 10);
        return response()->json($cards->paginate($perPage));
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

    public function deleteAll(Request $request): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:cards,id'
            ],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.array' => 'O campo id é do tipo array.',
                'id.*.integer' => 'Cada id deve ser um número inteiro.',
                'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.'
            ]
        );

        try {
            $this->card->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function isAuthorization(): bool {
        $user = Auth::user();
        return $user->is_admin || $user->is_manager;
    }
}
