<?php

namespace app\Helpers;
use Carbon\Carbon;

class DateHelper{
    /**
     * Converte data do formato yyyy-mm-dd para dd/mm/yyyy.
     */
    public static function convertDateToUs($date)
    {
        try {
            return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}