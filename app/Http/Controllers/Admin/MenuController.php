<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use Illuminate\Support\Facades\Validator;
use App\Services\MenuService;
use AccountLogService;

class MenuController extends Controller
{
    //菜单列表
    public function index(MenuRequest $request,MenuService $menuService)
    {
        $parent_id = $request->input('parent_id');
        $title = $request->input('title');

        $where = [];

        if (is_numeric($parent_id) && !$parent_id) {
            $where['parent_id'] = NULL;
        }elseif (is_numeric($parent_id) && $parent_id){
            $where['parent_id'] = $parent_id;
        }

        if (!empty($title)) {
            $where[] = ['title', 'like', '%' . $title . '%'];
        }

        //菜单分页数据
        list($list,$page) = $menuService->init()->where($where)->orderBy('id','DESC')->with(['parent'])->getList(true);

        $navs = $menuService->init()->getTopMenuWithChildren();

        return view('system.menus.index', ['list' => $list['data'],'page'=>$page,'navs'=>$navs]);

    }

    //添加菜单
    public function create(MenuRequest $request)
    {
        if ($request->isMethod('POST')) {

            $data['title'] = $request->input('title');
            $data['parent_id'] = $request->input('parent_id') ?? NULL;
            $data['group'] = $request->input('group');
            $data['url'] = $request->input('url');
            $data['sort'] = $request->input('sort');
            $data['is_show'] = $request->input('is_show');
            $data['created_at'] = get_current_time();
            $data['updated_at'] = get_current_time();

            $result = MenuService::init()->add($data);

            if ($result) {
                //写入日志
                AccountLogService::write('添加菜单,名称为:'. $data['title'],$data);

                if ($data['parent_id']) {
                    $url = url('admin/menus') . '?parent_id=' . $data['parent_id'];
                } else {
                    $url = url('admin/menus');
                }
                return showMessage('添加成功', $url);
            } else {
                return showMessage('添加失败');
            }

        } else {
            $navs = MenuService::init()->getTopMenuWithChildren();
            return view('system.menus.createMenu',['navs'=>$navs]);
        }
    }

    ////编辑菜单
    public function edit(MenuRequest $request,MenuService $menuService)
    {
        $id = $request->input('id');

        if ($request->isMethod('PUT')) {

            $data['title'] = $request->input('title');
            $data['parent_id'] = $request->input('parent_id') ?? NULL;
            $data['group'] = $request->input('group');
            $data['url'] = $request->input('url');
            $data['sort'] = $request->input('sort');
            $data['is_show'] = $request->input('is_show');
            $data['updated_at'] = get_current_time();

            $result = $menuService->init()->where(['id'=>$id])->update($data);

            if ($result) {
                //写入日志
                AccountLogService::write('编辑菜单,名称为:'. $data['title'],$data);

                if ($data['parent_id']) {
                    $url = url('admin/menus') . '?parent_id=' . $data['parent_id'];
                } else {
                    $url = url('admin/menus');
                }
                return showMessage('编辑成功', $url);
            } else {
                return showMessage('编辑失败');
            }

        } else {

            if (!$id) {
                return showMessage('参数错误!');
            }

            $detail = $menuService->init()->getInfo($id);

            $navs = $menuService->init()->getTopMenuWithChildren();

            return view('system.menus.editMenu', ['data' => $detail,'navs'=>$navs]);
        }
    }
}
