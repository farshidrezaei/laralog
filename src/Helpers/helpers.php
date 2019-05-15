<?php


use FarshidRezaei\LaraLog\Libraries\LaraLog;

if ( ! function_exists( 'laralog' ) ) {


    function laralog()
    {
        return LaraLog::new();
    }
}