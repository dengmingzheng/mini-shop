<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AccountLogService;


class AccountController extends Controller
{
    /**
     * @后台日志列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function logs(Request $request)
    {
        $list = AccountLogService::select(['id','username','content','created_at'])->getListWithPage();

        return view('system.accounts.logs', ['list' => $list]);
    }
}
