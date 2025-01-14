<?php

namespace App\Http\Controllers;

use App\Models\CombinedPayment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CombinedPaymentController extends Controller {

    protected $combinedPayment;
    public function __construct(CombinedPayment $combinedPayment) {
        $this->combinedPayment = $combinedPayment;
    }

    public function index(Request $request): JsonResponse{
        $combinedPayments = $this->combinedPayment->query()->orderBy('created_at', 'desc');
        $perPage = $request->get('per_page', 10);
        return response()->json($combinedPayments->paginate($perPage));
    }
}
