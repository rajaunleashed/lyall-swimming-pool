<?php


namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class InvoiceAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Invoice';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning pull-right',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'sales';
    }

    public function getDefaultRoute()
    {
        return route('sale.invoice', ['id' => $this->data->id]);
    }
}
