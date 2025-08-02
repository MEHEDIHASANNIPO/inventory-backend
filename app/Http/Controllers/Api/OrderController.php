<?php

namespace App\Http\Controllers\Api;

use App\Trait\ApiResponse;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Repositories\Order\OrderInterface;

class OrderController extends Controller
{
    use ApiResponse;
    private $orderRepository;

    public function __construct(OrderInterface $orderRepository) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('index-order');

        $perPage = request('per_page');
        $data = $this->orderRepository->allPaginate($perPage);
        $metadata['count'] = count($data);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $this->orderRepository->store($request);
            return $this->ResponseSuccess($data, null, 'Order Created Successfully!', 201);
        } catch (\Throwable $th) {
            return $this->ResponseError($th->getMessage());
        }
    }

    /*
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->orderRepository->show($id);

        if(!$data) {
            return $this->ResponseError([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /*
     * Display the specified resource.
     */
    public function invoiceDownload(string $id)
    {
        try {
            $invoice = $this->orderRepository->invoiceDownload($id);

            $setting = SystemSetting::firstOrFail();

            $pdf = Pdf::loadView('Invoice.invoice', compact('invoice', 'setting'));

            return $pdf->download("invoice_{$invoice->invoice_id}.pdf");
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice download failed!',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
