<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BannerService;
use App\Tools\ImageUploadHandler;
use AccountLogService;

class BannerController extends Controller
{
    //Banner列表
    public function index(Request $request,BannerService $bannerService)
    {
        list($list,$page) = $bannerService->init()->getList(true);

        return view('system.banner.index',['list'=>$list['data'],'page'=>$page]);
    }

    //添加Banner
    public function create(Request $request,BannerService $bannerService)
    {
        if($request->isMethod('POST')){
            $input = $request->input();

            $data = [
                'name'=>$input['name'],
                'type'=>$input['type'],
                'position'=>$input['position'],
                'open_type'=>$input['open_type'],
                'navigator_url'=>$input['navigator_url'],
                'sort'=>$input['sort'],
                'status'=>$input['status'],
                'created_at'=>get_current_time(),
                'updated_at'=>get_current_time(),
            ];

            if ($request->image_src) {

                $imageUploadHandler = new ImageUploadHandler();

                $result = $imageUploadHandler->save($request->image_src, 'banners',750);

                if ($result['path']) {
                    $data['image_src'] = $result['path'];
                }
            }

            $result = $bannerService->init()->add($data);

            if($result){
                //写入日志
                AccountLogService::write('添加banner,名称为:'.$data['name'],$data);

                return showMessage('添加成功',url('admin/banners'));
            }else{
                return showMessage('添加失败');
            }
        }else{

            $types = $bannerService->types;

            return view('system.banner.create',['types'=>$types]);
        }
    }

    //编辑Banner
    public function edit(Request $request,BannerService $bannerService)
    {
        $id = $request->input('id');

        if($request->isMethod('PUT')){

            $input = $request->input();

            $data = [
                'name'=>$input['name'],
                'type'=>$input['type'],
                'position'=>$input['position'],
                'open_type'=>$input['open_type'],
                'navigator_url'=>$input['navigator_url'],
                'sort'=>$input['sort'],
                'status'=>$input['status'],
                'updated_at'=>get_current_time(),
            ];

            if ($request->image_src) {

                $imageUploadHandler = new ImageUploadHandler();

                $result = $imageUploadHandler->save($request->image_src, 'banners',750);

                if ($result['path']) {
                    $data['image_src'] = $result['path'];
                }
            }

            $result = $bannerService->init()->where(['id'=>$id])->update($data);

            if($result){
                //写入日志
                AccountLogService::write('编辑banner,名称为:'.$data['name'],$data);

                return showMessage('编辑成功',url('admin/banners'));
            }else{
                return showMessage('编辑失败');
            }

        }else{
            if(!is_numeric($id) || empty($id)){
                return showMessage('数据异常');
            }

            $banner = $bannerService->init()->getInfo($id);

            $types = $bannerService->types;

            return view('system.banner.edit',['banner'=>$banner,'types'=>$types]);
        }
    }

    public function del(Request $request,BannerService $bannerService)
    {
        if($request->isMethod('DELETE')){
            $id = $request->input('id');

            if(!is_numeric($id) || empty($id)){
                return ['status'=>0,'msg'=>'数据异常'];
            }

            $result = $bannerService->init()->delete($id);

            if($result){
                //写入日志
                AccountLogService::write('删除banner,ID为:'.$id,[]);

                return ['status'=>200,'msg'=>'删除成功'];
            }else{
                return ['status'=>0,'msg'=>'删除失败'];
            }
        }
    }
}
