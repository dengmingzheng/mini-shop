<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = new Menu();

        $data = [
            'title'=>'系统管理',
            'group'=>'system',
            'url'=>'admin/menus',
            'sort'=>1,
            'is_show'=>1,
            'created_at' => get_current_time(),
            'updated_at'=>get_current_time()
        ];

        $result = $menu->insertGetId($data);

        if($result){
            $data = [];
            $data = [
                'title'=>'菜单列表',
                'parent_id'=>$result,
                'group'=>'system',
                'url'=>'admin/menus',
                'sort'=>1,
                'is_show'=>1,
                'created_at' => get_current_time(),
                'updated_at'=>get_current_time()
            ];

            $id = $menu->insertGetId($data);

            if($id){
                $data = [];
                $data = [
                    'title'=>'添加菜单',
                    'parent_id'=>$id,
                    'group'=>'system',
                    'url'=>'admin/menus/create',
                    'sort'=>1,
                    'is_show'=>0,
                    'created_at' => get_current_time(),
                    'updated_at'=>get_current_time()
                ];

                $menu->insertGetId($data);
            }

        }
    }
}
