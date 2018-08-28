<?php

if (! function_exists('setting')) {
    function setting($name, $default = null) {
        return app('setting')->get($name, $default);
    }
}