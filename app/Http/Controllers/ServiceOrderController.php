<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller {

    protected $serviceOrder;
    public function __construct(ServiceOrder $serviceOrder) {
        $this->serviceOrder = $serviceOrder;
    }


    public function store(Request $request) {
        $validatedData = $request->validate(
            $this->serviceOrder->rules(),
            $this->serviceOrder->messages()
        );

        dd($validatedData);
    }
}
