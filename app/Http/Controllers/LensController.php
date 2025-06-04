<?php

namespace App\Http\Controllers;

use App\Models\Index;
use App\Models\Lens;
use App\Models\MultifocalLens;
use App\Models\SingleVision;
use App\Models\TypeLens;
use App\ProductPrefix;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LensController extends Controller {

    protected $lens;
    public function __construct(Lens $lens) {
        $this->lens = $lens;
    }

    public function index(Request $request): JsonResponse {
        $lenses = $this->lens
            ->query()
            ->with([
                'typeLens',
                'treatment',
                'sensitivity',
                'laboratory',
                'diameters',
                'heights',
                'surfacings',
                'indices',
                'singleVision',
                'multifocalLens',
                'promotionItems',
                'promotionItems.promotion',
                'promotionItems.promotion.creditPromotions',
                'promotionItems.promotion.cashPromotions',
                'promotionItems.promotion.cashPromotions.formPayment',
                'promotionItems.promotion.filters',
            ])->orderBy('name_lens');

        # filters
        if ($nameLens = $request->input('search')) {
            $lenses->where(function ($query) use ($nameLens) {
                $query->where('name_lens', 'like', '%' . $nameLens . '%');
            });
        }

        if ($barcode = $request->input('barcode')) {
            $lenses->where(function ($query) use ($barcode) {
               $query->where('code', 'like', '%' . $barcode . '%');
            });
        }

        if ($index = $request->input('indice')) {
            $lenses->whereHas('indices', function ($query) use ($index) {
                $query->where('index', 'like', '%' . $index . '%');
            });
        }

        if ($typeLens = $request->input('tipo')) {
            $lenses->whereHas('typeLens', function ($query) use ($typeLens) {
                $query->where('type_lens', 'LIKE', '%' . $typeLens . '%');
            });
        }

        if ($treatment = $request->input('tratamento')) {
            $lenses->whereHas('treatment', function ($query) use ($treatment) {
                $query->where('treatment', 'LIKE', '%' . $treatment . '%');
            });
        }

        if ($sensitivity = $request->input('fotossensibilidade')) {
            $lenses->whereHas('sensitivity', function ($query) use ($sensitivity) {
                $query->where('sensitivity', 'LIKE', '%' . $sensitivity . '%');
            });
        }

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

        try {
            $lens = DB::transaction(function() use ($validatedData) {
                $lens = $this->lens->query()->create($validatedData);
                $step = 0.25;

                if (isset($validatedData['addition_start']) && isset($validatedData['addition_end'])) {
                    for ($i = $lens->addition_start; $i <= $lens->addition_end; $i += $step) {
                        for ($j = $lens->spherical_start; $j <= $lens->spherical_end; $j += $step) {
                            MultifocalLens::query()->create([
                                'barcode' => $this->generateUniqueBarCode(),
                                'lens_id' => $lens->id,
                                'addition' => $i,
                                'spherical' => $j,
                            ]);
                        }
                    }
                } else {
                    for ($i = $lens->cylindrical_start; $i >= $lens->cylindrical_end; $i -= $step) {
                        for ($j = $lens->spherical_start; $j <= $lens->spherical_end; $j += $step) {
                            SingleVision::query()->create([
                                'barcode' => $this->generateUniqueBarCode(),
                                'lens_id' => $lens->id,
                                'cylindrical' => $i,
                                'spherical' => $j,
                            ]);
                        }
                    }
                }
                return $lens;
            });
            return response()->json($lens->load('singleVision', 'multifocalLens'), 201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(int $id): JsonResponse {
        $lens = $this->lens
            ->query()
            ->with([
                'typeLens',
                'treatment',
                'sensitivity',
                'laboratory',
                'diameters',
                'heights',
                'surfacings',
                'indices',
                'singleVision',
                'multifocalLens',
                'promotionItems',
                'promotionItems.promotion',
                'promotionItems.promotion.creditPromotions',
                'promotionItems.promotion.cashPromotions',
                'promotionItems.promotion.cashPromotions.formPayment',
                'promotionItems.promotion.filters'
            ])
            ->find($id);

        if (!$lens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        return response()->json($lens);
    }


    public function update(Request $request, int $id): JsonResponse {
        $lens = $this->lens->query()
            ->with('typeLens', 'treatment', 'sensitivity')
            ->find($id);

        if (!$lens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->lens->rules(true),
            $this->lens->messages()
        );

        if (isset($validatedData['barcode'])) {
            $barcodeExists = $this->lens->query()
                ->where('barcode', $validatedData['barcode'])
                ->where('id', '<>', $id)
                ->exists();

            if ($barcodeExists) {
                return response()->json([
                    'error' => 'O código de barra informado já existe na base de dados.'
                ], 422);
            }
        }

        try {
            $lens = DB::transaction(function() use ($lens, $validatedData) {
                $lens->update($validatedData);

                // Recarrega a lente com os dados atualizados
                $lens = $lens->fresh();

                // Exclui os registros existentes para recriar
                if (isset($validatedData['addition_start']) && isset($validatedData['addition_end'])) {
                    MultifocalLens::query()->where('lens_id', $lens->id)->delete();
                } else {
                    SingleVision::query()->where('lens_id', $lens->id)->delete();
                }

                $step = 0.25;

                // Recria os registros baseado nos dados atualizados
                if (isset($validatedData['addition_start']) && isset($validatedData['addition_end'])) {
                    for ($i = $lens->addition_start; $i <= $lens->addition_end; $i += $step) {
                        for ($j = $lens->spherical_start; $j <= $lens->spherical_end; $j += $step) {
                            MultifocalLens::query()->create([
                                'barcode' => $this->generateUniqueBarCode(),
                                'lens_id' => $lens->id,
                                'addition' => $i,
                                'spherical' => $j,
                            ]);
                        }
                    }
                } else {
                    for ($i = $lens->cylindrical_start; $i >= $lens->cylindrical_end; $i -= $step) {
                        for ($j = $lens->spherical_start; $j <= $lens->spherical_end; $j += $step) {
                            SingleVision::query()->create([
                                'barcode' => $this->generateUniqueBarCode(),
                                'lens_id' => $lens->id,
                                'cylindrical' => $i,
                                'spherical' => $j,
                            ]);
                        }
                    }
                }

                return $lens;
            });

            // Carrega os relacionamentos atualizados
            $lens = $lens->fresh(['singleVision', 'multifocalLens']);

            return response()->json($lens);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $lens = $this->lens->query()->find($id);

        if (!$lens) {
            return response()->json([
                'error' => 'A lente informada não existe na base de dados.',
            ], 404);
        }

        try {
            $lens->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function deleteMultiple(Request $request): JsonResponse {
        $validatedData = $request->validate(
            [
                'id' => 'required|array',
                'id.*' => 'integer|exists:lenses,id'
            ],
            [
                'id.required' => 'O campo id é obrigatório.',
                'id.array' => 'O campo id é do tipo array.',
                'id.*.integer' => 'Cada id deve ser um número inteiro.',
                'id.*.exists' => 'Um ou mais registros selecionados não existe na base de dados.'
            ]
        );

        try {
            $this->lens->query()->whereIn('id', $validatedData['id'])->delete();
            return response()->json(['message' => 'Registros excluídos com sucesso.']);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Error ao processar a soliciatação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function exportPdf() {
        $lenses = $this->lens->query()
            ->with([
                'typeLens',
                'treatment',
                'indices',
                'sensitivity',
                'laboratory',
                'surfacings',
                'diameters',
                'heights',
            ])
            ->orderBy('name_lens')
            ->get();

        $typeLenses = $lenses->pluck('typeLens')->unique('id')->sortBy('type_lens');
        $indices = $lenses->pluck('indices')->unique('id')->sortBy('index');
        $surfacings = $lenses->pluck('surfacings')->unique('id')->sortBy('surfacing');
        $photosensitivities = $lenses->pluck('sensitivity')->unique('id')->sortBy('sensitivity');
        $treatments = $lenses->pluck('treatment')->unique('id')->sortBy('treatment');

        return view('report.lenses', compact(
            'typeLenses',
            'indices',
            'surfacings',
            'photosensitivities',
            'treatments',
            'lenses',
        ));
    }

    public function exportLensSaller() {
        $lenses = $this->lens->query()
            ->with([
                'typeLens',
                'treatment',
                'indices',
                'sensitivity',
                'laboratory',
                'surfacings',
                'diameters',
                'heights',
            ])
            ->orderBy('name_lens')
            ->get();

        return view('pdf.lenses_saller', compact('lenses'));
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
