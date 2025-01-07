<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use App\Models\Sale;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleController extends Controller {

    protected $sale;
    public function __construct(Sale $sale) {
        $this->sale = $sale;
    }

    public function store(Request $request): JsonResponse {

        $validatedData = $request->validate(
            $this->sale->rules(),
            $this->sale->messages(),
        );

        try {

            $sale = $this->sale->query()->create($validatedData);

            $totalAmount = 0;

            foreach ($validatedData['items'] as $item) {
                $model = $item['type'] === 'frame' ? Frame::class : Service::class;

                $sellable = $model::query()->find($item['id']);
                if (!$sellable) {
                    return response()->json([
                        'error' => 'O item informado não existe na base de dados.',
                    ], 404);
                }
            }


        } catch (\Throwable $th) {
            return response()->json();
        }
    }
}
