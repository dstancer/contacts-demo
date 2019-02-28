<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIController extends Controller
{
    protected function processGET(Request $request, $data, \Closure $callback)
    {
        if ($this->hasKey($request)) {
            if ($data) {
                return $callback();
            }
            return response()->json('No data found.', 404);
        }
        return response()->json('Invalid request.', 400);
    }

    protected function processPOST(Request $request, $data, \Closure $callback)
    {
        if ($this->isValidRequest($request)) {
            if ($data) {
                return $callback();
            }
            return response()->json('No data found.', 404);
        }
        return response()->json('Invalid request.', 400);
    }

    protected function isValidRequest(Request $request)
    {
        return $request->wantsJson() && $this->hasKey($request);
    }

    protected function hasKey(Request $request)
    {
        return ($request->header('X-Authorization') === config('app.key'));
    }
}