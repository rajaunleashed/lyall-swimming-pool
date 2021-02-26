<?php


namespace App\Actions;


use App\Services\StockService;
use TCG\Voyager\Actions\AbstractAction;

class CloseMonthAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Close Month';
    }

    public function getIcon()
    {
        return 'voyager-lock';
    }

    public function getPolicy()
    {
        return 'edit';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-warning',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        $isMonthOpen = StockService::checkMonthlyClosed(request()->get('month'));
        return $this->dataType->slug == 'monthly-stocks' && $isMonthOpen;
    }

    public function getDefaultRoute()
    {
        return null;
    }

    public function massAction($ids, $comingFrom)
    {
        $url_components = parse_url($comingFrom);
        parse_str($url_components['query'], $params);

        StockService::closeMonth($params['month']);
        // Do something with the IDs
        return redirect($comingFrom);
    }
}
