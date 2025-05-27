<?php

namespace App\Http\Controllers;

use App\Models\Cancellation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CancellationController extends Controller {
    protected $cancellation;
    public function __construct(Cancellation $cancellation) {
        $this->cancellation = $cancellation;
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->cancellation->rules(),
            $this->cancellation->messages(),
        );

        dd($validatedData);

        try {
            $cancellation = $this->cancellation->query()->create($validatedData);
            return response()->json($cancellation, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
