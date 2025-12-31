<?php


use Carbon\Carbon;


    if(! function_exists('dateYmdToMdy')){
        function dateYmdToMdy($date){
            return Carbon::CreateFromFormat('Y-m-d', $date)->format('d-m-Y');
        }
    }