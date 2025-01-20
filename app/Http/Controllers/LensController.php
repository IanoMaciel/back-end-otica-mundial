<?php

namespace App\Http\Controllers;

use App\Models\Lens;
use App\ProductPrefix;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LensController extends Controller {

    protected $lens;
    public function __construct(Lens $lens) {
        $this->lens = $lens;
    }

    public function index(Request $request): JsonResponse {
        $lenses = $this->lens->query()
            ->with('typeLens', 'treatment', 'sensitivity')
            ->orderBy('name_lens');
        $perPage = $request->get('per_page', 10);
        return response()->json($lenses->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->lens->rules(),
            $this->lens->messages()
        );

        $validatedData = array_merge($validatedData, [
            'barcode' => $this->generateUniqueBarCode()
        ]);

        DB::beginTransaction();

        try {
            $lens = $this->lens->query()->create($validatedData);
            DB::commit();
            return response()->json($lens, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $lens = $this->lens->query()
            ->with('typeLens', 'treatment', 'sensitivity')
            ->find($id);

        if (!$lens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        return response()->json($lens);
    }

    private function generateUniqueBarCode(): string {
        do {
            $baseCode = ProductPrefix::LENSES . str_pad(random_int(0, 999999999), 9, '0', STR_PAD_LEFT);
            $sum = 0;
            for ($i = 0; $i < strlen($baseCode); $i++) {
                $sum += (int)$baseCode[$i] * ($i % 2 ? 3 : 1);
            }

            $checkDigit = (10 - ($sum % 10)) % 10;
            $barcode = $baseCode . $checkDigit;

        } while ($this->lens->query()->where('barcode', $barcode)->exists());
        return $barcode;
    }

}
