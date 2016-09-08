<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;

class TestController extends Controller
{
    public function __construct()
    {
        //$this->scopes('test');
    }

    public function index()
    {
        return response()->json('Test');
    }
}
