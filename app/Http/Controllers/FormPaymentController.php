<?php

namespace App\Http\Controllers;

use App\Models\FormPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormPaymentController extends Controller {

    protected $formPayment;
    public function __construct(FormPayment $formPayment) {
        $this->formPayment = $formPayment;
    }

    public function index() {
        return $this->formPayment->query()->orderBy('form_payment')->get();
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
          $this->formPayment->rules(),
          $this->formPayment->messages(),
        );

        try {
            $formPayment = $this->formPayment->query()->create($validatedData);
            return response()->json($formPayment, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $formPayment = $this->formPayment->query()->find($id);

        if (!$formPayment) {
            return response()->json([
                'error' => 'A forma de pagamento informada não existe na base de dados.'
            ], 404);
        }

        return response()->json($formPayment);
    }

    public function update(Request $request, int $id): JsonResponse {
        $formPayment = $this->formPayment->query()->find($id);

        if (!$formPayment) {
            return response()->json([
                'error' => 'A forma de pagamento informada não existe na base de dados.'
            ], 404);
        }

        $validatedData = $request->validate(
            $this->formPayment->rules(true),
            $this->formPayment->messages(),
        );

        $formPaymentExists = $this->formPayment->query()
            ->where('form_payment', $validatedData['form_payment'])
            ->where('id', '<>', $id)
            ->exists();

        if ($formPaymentExists) {
            return response()->json([
                'error' => 'A forma de pagamento informada já existe na base de dados.'
            ], 422);
        }

        try {
            $formPayment->update($validatedData);
            return response()->json($formPayment);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy(int $id): JsonResponse {
        $formPayment = $this->formPayment->query()->find($id);

        if (!$formPayment) {
            return response()->json([
                'error' => 'A forma de pagamento informada não existe na base de dados.'
            ], 404);
        }

        try {
            $formPayment->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

}
