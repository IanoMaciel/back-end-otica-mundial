<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller {

    protected $serviceOrder;
    public function __construct(ServiceOrder $serviceOrder) {
        $this->serviceOrder = $serviceOrder;
    }

    public function exportPdf(int $id) {
        $serviceOrder = $this->serviceOrder->query()
            ->with([
                'sale.user',
                'sale.customer.address',
            ])
            ->find($id);

        if (!$serviceOrder) {
            return response()->json([
                'error' => 'A ordem de serviço informada não existe na base de dados.',
            ], 404);
        }

        $seller = optional($serviceOrder->sale->user)->first_name ?? '-';
        $numberSale = optional($serviceOrder->sale)->number_ata ?? '-';
        $numberOs = $serviceOrder->number_os ?? '-';
        $createdAt = optional($serviceOrder->sale)->created_at ?? '-';

        $laboratory = $serviceOrder->sale->lenses->first()->laboratory->laboratory ?? '-';
        $delivery = $serviceOrder->delivery ?? '-';

        $observation = $serviceOrder->observation ?? '-';

        $customer = optional($serviceOrder->sale->customer);
        $address = optional($customer->address);

        $frames = $serviceOrder->sale->frames;
        $lenses = $serviceOrder->sale->lenses;
        $services = $serviceOrder->sale->services;

        return view('pdf.service_order', [
            'seller' => $seller,
            'numberSale' => $numberSale,
            'numberOs' => $numberOs,
            'createdAt' => $createdAt,

            'delivery' => $delivery,
            'laboratory' => $laboratory,

            'observation' => $observation,

            'customer' => $customer,
            'address' => $address,

            'serviceOrder' => $serviceOrder,

            'lenses' => $lenses,
            'frames' => $frames,
            'services' => $services,
        ]);
    }

    public function index(Request $request): JsonResponse {
        $serviceOrder = $this->serviceOrder->query()->with('sale');
        $perPage = $request->get('per_page', 10);
        return response()->json($serviceOrder->paginate($perPage));
    }

    public function store(Request $request): JsonResponse {
        $validatedData = $request->validate(
            $this->serviceOrder->rules(),
            $this->serviceOrder->messages()
        );

        try {
            $serviceOrder = $this->serviceOrder->query()->create($validatedData);
            return response()->json($serviceOrder,201);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function show(int $id): JsonResponse {
        $serviceOrder = $this->serviceOrder->query()->with(
            'sale.combinedPayment.portions.formPayment',
            'sale.customer',
            'sale.paymentMethod',
            'sale.user'
        )->find($id);

        if (!$serviceOrder) {
            return response()->json([
                'error' => 'A ordem de serviço informada não existe na base de dados.',
            ], 404);
        }

        return response()->json($serviceOrder);
    }

    public function update(Request $request, int $id): JsonResponse {
        $serviceOrder = $this->serviceOrder->query()->find($id);

        if (!$serviceOrder) {
            return response()->json([
                'error' => 'A ordem de serviço informada não existe na base de dados.',
            ], 404);
        }

        $validatedData = $request->validate(
            $this->serviceOrder->rules(),
            $this->serviceOrder->messages()
        );

        try {
            $serviceOrder->update($validatedData);
            return response()->json($serviceOrder);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        $serviceOrder = $this->serviceOrder->query()->find($id);

        if (!$serviceOrder) {
            return response()->json([
                'error' => 'A ordem de serviço informada não existe na base de dados.',
            ], 404);
        }

        try {
            $serviceOrder->delete();
            return response()->json(null, 204);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Erro ao processar a solicitação.',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
