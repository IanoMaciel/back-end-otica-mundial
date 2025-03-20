<?php

namespace App\Http\Controllers;

use App\Models\Frame;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function exportPdf() {
        $frames = $this->frame->query()
            ->with('suppliers', 'brands', 'materials', 'promotionItems')
            ->join('brands', 'frames.brand_id', '=', 'brands.id')
            ->orderBy('brands.brand')
            ->select('frames.*')
            ->get();

        $pdf = Pdf::loadView('pdf.frames', compact('frames'))->setPaper('a4', 'landscape');
        return $pdf->download('frames.pdf');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        $query = $this->frame->query()
            ->with(
                'suppliers',
                'brands',
                'materials',
                'promotionItems',
                'promotionItems.promotion',
                'promotionItems.promotion.creditPromotions',
                'promotionItems.promotion.cashPromotions',
                'promotionItems.promotion.cashPromotions.formPayment',
                'promotionItems.promotion.filters',
            )
            ->orderBy('created_at', 'desc');

        // filter by search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%');
            });
        }

        // filter by size
        if ($tamanho = $request->input('tamanho')) {
            $query->where(function ($q) use ($tamanho) {
                $q->where('size', 'like', '%' . $tamanho . '%');
            });
        }

        // filter by haste
        if ($haste = $request->input('haste')) {
            $query->where(function ($q) use ($haste) {
                $q->where('haste', 'like', '%' . $haste . '%');
            });
        }

        // filter by bridge
        if ($bridge = $request->input('ponte')) {
            $query->where(function ($q) use ($bridge) {
                $q->where('bridge', 'like', '%' . $bridge . '%');
            });
        }

        // filter by color
        if ($color = $request->input('cor')) {
            $query->where(function ($q) use ($color) {
                $q->where('color', 'like', '%' . $color . '%');
            });
        }

        // filter by brand
        if ($brand = $request->input('grife')) {
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
            $frame->barcode = $this->generateUniqueBarCode(ProductPrefix::FRAMES);
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
        $frame = $this->frame->query()
            ->with(
                'suppliers',
                'brands',
                'materials',
                'promotionItems',
                'promotionItems.promotion',
                'promotionItems.promotion.creditPromotions',
                'promotionItems.promotion.cashPromotions',
                'promotionItems.promotion.cashPromotions.formPayment',
                'promotionItems.promotion.filters',
            )
            ->find($id);
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

    public function deleteMultiple(Request $request): JsonResponse {
        if (!$this->isAuthorization()) {
            return response()->json([
                'error' => 'Ops! Você não possui autorização para realizar está operação.'
            ], 403);
        }

        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:frames,id'
            ],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.array' => 'O campo id é do tipo array.',
                'id.*.integer' => 'Cada id deve ser um número inteiro.',
                'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.'
            ]
        );

        try {
            $this->frame->query()->whereIn('id', $validatedData['id'])->delete();
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
        return $user->getAttribute('is_admin') || $user->getAttribute('is_manager');
    }

    private function generateUniqueBarCode(string $prefix): string {
        do {
            $baseCode = $prefix . str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);

            $sum = 0;

            for ($i = 0; $i < strlen($baseCode); $i++) {
                $sum += (int)$baseCode[$i] * ($i % 2 ? 3 : 1);
            }

            $checkDigit = (10 - ($sum % 10)) % 10;
            $barcode = $baseCode . $checkDigit;

        } while ($this->frame->query()->where('barcode', $barcode)->exists());
        return $barcode;
    }
}
