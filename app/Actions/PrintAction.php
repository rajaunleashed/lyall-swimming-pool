<?php


namespace App\Actions;


use TCG\Voyager\Actions\AbstractAction;

class PrintAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Print';
    }

    public function getIcon()
    {
        return 'voyager-documentation';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right print-ticket',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'tickets';
    }

    public function getDefaultRoute()
    {
        return route('print.ticket', ['id' => $this->data->id]);
    }
}
