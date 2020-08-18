<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validation and return data
     *
     * @param $request
     * @param array $rule
     * @return array
     */
    protected function valid($request, $rule = [])
    {
        $this->validate($request, $rule);

        return $request->only(array_keys($rule));
    }
}
