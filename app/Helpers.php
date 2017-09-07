<?php

if (!function_exists('lang')) {
    function lang($text, $parameters = [])
    {
        return trans('blog.' . $text, $parameters);
    }
}

if (!function_exists('isActive')) {
    function isActive($nav)
    {
        return Route::currentRouteName() == $nav ? 'active' : '';
    }
}
