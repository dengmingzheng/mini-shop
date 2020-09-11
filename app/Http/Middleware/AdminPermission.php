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
        $currentUrlArray = explode('/',$currentUrl);//分割路由成数组[0=>'admin',1=>'menus',2=>'createMenu']

        $currentMenu = MenuService::init()->where(['url'=>$currentUrl])->getInfo();//当前菜单数据

        if(empty($currentMenu)){
            return showMessage('当前操作权限不存在');
        }

        $topNav = [];//顶部导航
        $leftNav = []; //左侧导航

        //获取顶部导航和子数据
        $navs = MenuService::init()->where(['parent_id'=>NULL])->orderBy('sort','asc')->with(['children'])->getList(false)[0]['data'];

        if(!empty($navs)){
            foreach ($navs as $key => $nav){
                $topNav[$key] = $nav;
                if($currentMenu['group'] == $nav['group']){
                    $topNav[$key]['class'] = 'actived';//顶部选中
                    //获取左侧菜单
                    $leftNav = MenuService::init()->where(['parent_id'=>$nav['id']])->orderBy('sort','asc')->with(['children'])->getList(false)[0]['data'];
                }
            }
        }

        if(!empty($leftNav)){
            //左侧菜单选择状态
            foreach ($leftNav as &$value){
                if($currentMenu['group'] == $value['group'] &&  ($currentUrlArray[0].'/'.$currentUrlArray[1] == $value['url'])){
                    $value['class'] = 'selected';
                }
            }
        }

        view()->share('topNav', $topNav);
        view()->share('leftNav', $leftNav);

        return $next($request);
    }
}
