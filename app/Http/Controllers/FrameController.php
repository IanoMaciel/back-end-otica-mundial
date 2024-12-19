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

        // filter by search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%');
            });
        }

        // filter by size
        if ($size = $request->input('size')) {
            $query->where(function ($q) use ($size) {
                $q->where('size', 'like', '%' . $size . '%');
            });
        }

        // filter by haste
        if ($haste = $request->input('haste')) {
            $query->where(function ($q) use ($haste) {
                $q->where('haste', 'like', '%' . $haste . '%');
            });
        }

        // filter by bridge
        if ($bridge = $request->input('bridge')) {
            $query->where(function ($q) use ($bridge) {
                $q->where('bridge', 'like', '%' . $bridge . '%');
            });
        }

        // filter by color
        if ($color = $request->input('color')) {
            $query->where(function ($q) use ($color) {
                $q->where('color', 'like', '%' . $color . '%');
            });
        }

        // filter by brand
        if ($brand = $request->input('brand')) {
            $query->whereHas('brands', function ($q) use ($brand) {
                $q->where('brand', 'like', '%' . $brand . '%');
            });
        }

        // filter by material
        if ($material = $request->input('material')) {
            $query->whereHas('materials', function ($q) use ($material) {
                $q->where('material', 'like', '%' . $material . '%');
            });
        }

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
