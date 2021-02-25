<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Repositories\SaleProductsRepository;
use App\Repositories\SaleRepository;
use App\Utilities\Helper;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class SaleController extends VoyagerBaseController
{
    protected $saleRepository;
    protected $saleProductsRepository;

    public function __construct(SaleRepository $saleRepository, SaleProductsRepository $saleProductsRepository)
    {
        $this->saleRepository = $saleRepository;
        $this->saleProductsRepository = $saleProductsRepository;
    }

    /**
     * POST BRE(A)D - Store data.
     *
     * @param \App\Http\Requests\SaleRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(SaleRequest $request)
    {
        DB::beginTransaction();
        try {

            Product::validateStock($request->items, function($response) {
                if (!$response) {
                    throw new \Exception(__('Quantity exceeded, product out of stock'));
                }
            });

            $sale = $this->saleRepository->store($request);
            $this->saleProductsRepository->store($request, $sale->id, function($items) {
                Purchase::resolveStock($items);
            });

            DB::commit();
            session()->flash('success', __('messages.sale_added'));
            return Helper::successResponse(__('messages.sale_added'));

        } catch (\Exception $exception)
        {
            DB::rollBack();
            session()->flash('error', __($exception->getMessage()));
            return Helper::errorResponse(__($exception->getMessage()));
        }

    }


    function getSaleByID($id)
    {
        $sales = Sale::find($id);
        return Helper::successResponse(__('Sale record'), $sales);
    }

    function updateByID(SaleRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            Product::validateStock($request->items, function($response) {
                if (!$response) {
                    throw new \Exception(__('Quantity exceeded, product Out of Stock'));
                }
            });

            $sale = $this->saleRepository->update($request, $id);
            $this->saleProductsRepository->update($request, $sale->id, function($response) {
                $items = $response['items'];
                $previousItems = $response['previousItems'];
                Purchase::resolveStock($items, $previousItems);
            });

            DB::commit();
            session()->flash('success', __('messages.sale_added'));
            return Helper::successResponse(__('messages.sale_added'));

        } catch (\Exception $exception)
        {
            DB::rollBack();
            session()->flash('error', __($exception->getMessage()));
            return Helper::errorResponse(__($exception->getMessage()));
        }
    }

    public function getPaymentDetail($saleId) {
        $data['totalAmount'] = $this->saleProductsRepository->totalAmount($saleId);
        $payment = Payment::whereSaleId($saleId)->get();
        if($payment) {
            $data['totalPayment'] = $payment->sum('amount');
            $data['remainingAmount'] = $data['totalAmount'] - $data['totalPayment'];
        } else {
            $data['totalPayment'] = 0;
            $data['remainingAmount'] = $data['totalAmount'];
        }
        return Helper::successResponse(__('Sale Amount'), $data);
    }


}
