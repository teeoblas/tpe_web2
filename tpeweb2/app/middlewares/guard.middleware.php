<?php
class GuardMiddleware
{
    public function run($request)
    {
        return !empty($request->user); // true si está logueado, false si no
    }
}



