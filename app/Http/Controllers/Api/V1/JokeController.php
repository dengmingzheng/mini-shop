<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JokeService;

class JokeController extends Controller
{
    public function index(Request $request,JokeService $jokeService)
    {
        $list = $jokeService->init()->getList(true);

            return ['statusCode'=>200,'data'=>$list[0]['data']];
    }
}
