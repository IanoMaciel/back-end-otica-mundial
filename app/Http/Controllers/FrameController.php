<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\ProductPrefix;

class FrameController extends Controller {
    protected $frame;

    public function __construct(Frame $frame) {
        $this->frame = $frame;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        $query = $this->frame->query()->with(['suppliers', 'brands', 'materials']);
        $perPage = $request->get('per_page', 10);
        return response()->json($query->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->frame->rules(),
            $this->frame->messages(),
        );

        try {
            $frame = $this->frame->query()->create($validatedData);
            $frame->barcode = ProductPrefix::FRAMES . '-' . str_pad($frame->id, 6, '0', STR_PAD_LEFT);
            $frame->save();
            return response()->json($frame, 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
