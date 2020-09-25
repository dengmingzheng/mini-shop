<?php

namespace App\Http\Middleware;

use Closure;
use MenuService;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentUrl = $request->path();//获取当前路由
        $currentMenu = MenuService::select(['id','group','url','parent_id'])->getRowByCondition(['url'=>$currentUrl]);//当前菜单数据

        if(empty($currentMenu)){
            return showMessage('当前操作权限不存在');
        }

        $topNav = [];//顶部导航
        $leftNav = []; //左侧导航
        $topTitle = '';
        $navTitle = '';

        //获取顶部导航和子数据
        $navs = MenuService::select(['id','group','title','url'])->getList(['parent_id'=>NULL],['children'],'sort','ASC');

        if(!empty($navs)){
            foreach ($navs as $key => $nav){
                $topNav[$key] = $nav;
                if($currentMenu['group'] == $nav['group']){
                    $topNav[$key]['class'] = 'actived';//顶部选中
                    $topTitle = $nav['title'];
                    //获取左侧菜单
                   if(!empty($nav['children'])){
                       foreach ($nav['children'] as $child){
                           if($currentMenu['group'] == $child['group'] &&  ($currentMenu['url'] == $child['url'])){
                               $child['class'] = 'selected';
                               $navTitle = $child['title'];
                           }elseif ($currentMenu['group'] == $child['group'] && ($currentMenu['parent_id'] == $child['id'])){
                               $child['class'] = 'selected';
                               $navTitle = $child['title'];
                           }
                           $leftNav[] = $child;
                       }
                   }
                }
            }
        }

        view()->share('topNav', $topNav);
        view()->share('leftNav', $leftNav);
        view()->share('topTitle', $topTitle);
        view()->share('navTitle', $navTitle);

        return $next($request);
    }
}
