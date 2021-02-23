<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class InvoiceController extends VoyagerBaseController
{
    //***************************************
    //                ____
    //               |   |
    //               |   |
    //               |   |
    //               |   |
    //               |___|nvoice
    //
    //  Invoice of a sale item
    //
    //****************************************

    public function show(Request $request, $id)
    {
        $slug = 'sales';

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        $isSoftDeleted = false;

        if (strlen($dataType->model_name) != 0) {
            $model = app($dataType->model_name);

            // Use withTrashed() if model uses SoftDeletes and if toggle is selected
            if ($model && in_array(SoftDeletes::class, class_uses_recursive($model))) {
                $model = $model->withTrashed();
            }
            if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope' . ucfirst($dataType->scope))) {
                $model = $model->{$dataType->scope}();
            }
            $dataTypeContent = call_user_func([$model, 'findOrFail'], $id);
            if ($dataTypeContent->deleted_at) {
                $isSoftDeleted = true;
            }
        } else {
            // If Model doest exist, get data from table name
            $dataTypeContent = DB::table($dataType->name)->where('id', $id)->first();
        }

        // Replace relationships' keys for labels and create READ links if a slug is provided.
        $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType, true);

        // If a column has a relationship associated with it, we do not want to show that field
        $this->removeRelationshipField($dataType, 'read');

        // Check permission
        $this->authorize('read', $dataTypeContent);

        // Check if BREAD is Translatable
        $isModelTranslatable = is_bread_translatable($dataTypeContent);

        // Eagerload Relations
        $this->eagerLoadRelations($dataTypeContent, $dataType, 'read', $isModelTranslatable);

        $sale = Sale::find($id);

        return view('voyager::sales.invoice', compact('dataType', 'sale', 'dataTypeContent', 'isSoftDeleted'));
    }


    public function updateInvoice(Request $request)
    {
        $sale = Sale::find($request->id);
        $sale->comments = $request->comments;
        $sale->created_at = $request->created_at;
        $sale->save();

        return redirect()->back()->with([
            'alert-type' => 'success',
            'message' => __('Invoice updated successfully')
        ]);
    }


    public function downloadInvoice($id)
    {
        $invoice = Sale::find($id);
        $pdf = \PDF::loadView('voyager::sales.pdf', compact('invoice'));
        return $pdf->download("invoice-{$invoice->id}.pdf");
    }

    //printInvoice
    public function printInvoice($id)
    {
        $invoice = Sale::find($id);
        return view('voyager::sales.pdf', compact('invoice'));
    }
}

