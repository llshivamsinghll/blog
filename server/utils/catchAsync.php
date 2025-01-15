<?php

function catchAsync($fn)
{
    return function($req, $res, $next) use ($fn) {
        try {
            $fn($req, $res, $next);
        } catch (Exception $e) {
            $next($e);
        }
    };
}
