<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\ProductPrefix;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $query = $this->frame->query()->with('suppliers', 'brands', 'materials');
        $perPage = $request->get('per_page', 10);
        return response()->json($query->paginate($perPage));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $validatedData = $request->validate(
            $this->frame->rules(),
            $this->frame->messages(),
        );

        DB::beginTransaction();

        try {
            $frame = $this->frame->query()->create($validatedData);
            $frame->barcode = ProductPrefix::FRAMES . '-' . str_pad($frame->id, 6, '0', STR_PAD_LEFT);
            $frame->save();

            DB::commit();

            return response()->json($frame, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse {
        $frame = $this->frame->query()->with('suppliers', 'brands', 'materials')->find($id);
        if (!$frame) return response()->json(['error' => 'A Armação selecionada não existe na base de dados.'], 404);
        return response()->json($frame);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $frame = $this->frame->query()->with('suppliers', 'brands', 'materials')->find($id);
        if (!$frame) return response()->json(['error' => 'A Armação selecionada não existe na base de dados.'], 404);

        $validatedData = $request->validate($this->frame->rules(true), $this->frame->messages());

        $codeExists = $this->frame->query()
            ->where('code', $validatedData['code'])
            ->where('id', '<>', $id)
            ->exists();

        if ($codeExists) return response()->json(['error' => 'Código já cadastrado na base de dados.'], 409);

        try {
            $frame->update($validatedData);
            return response()->json($frame);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $frame = $this->frame->query()->find($id);
        if (!$frame) return response()->json(['error' => 'A Armação selecionada não existe na base de dados.'], 404);

        try {
            $frame->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    private function isAuthorization(): bool {
        $user = Auth::user();
        return $user->getAttribute('is_admin') || $user->getAttribute('is_manager');
    }
}
