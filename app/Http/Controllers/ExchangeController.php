<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExchangeController extends Controller
{
    public function getValues(): Response|Application|ResponseFactory
    {
        return response(['123', 455], 200);
    }
}
