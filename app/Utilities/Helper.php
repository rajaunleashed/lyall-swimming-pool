<?php


namespace App\Utilities;


use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class Helper
{
    /* @handler successResponse
     * @param $message
     * @param $data
     * @return JsonResponse
     * */
    public static function successResponse($message, $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    /* @handler successResponse
     * @param $message
     * @return JsonResponse
     * */

    public static function errorResponse($message)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ]);
    }

    /* @handler formatCurrency
     * @param $value string
     * @return string
     * */

    public static function formatCurrency($value)
    {
        return setting('admin.currency') . ' ' . $value;
    }

    /* Get Month & Year
     * @handler
     * @param $month string
     * @return array
     * */

    public static function getMonthYearFromDate($month = null) {

        if (is_null($month)) {
            $month = now()->toDateString();
        }

        $m = Carbon::parse($month)->month;
        $y = Carbon::parse($month)->year;

        return [
            'month' => $m,
            'year'  => $y
        ];
    }
}
