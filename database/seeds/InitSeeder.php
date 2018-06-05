<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //添加一个初始值
        $user = [
            'name'=>'admin',
            'pinyin'=>'admin',
            'py'=>'admin',
            'nickname'=>'admin',
            'email'=>'281117063@qq.com',
            'password'=>bcrypt('123654')
        ];
        $check = User::where(['email'=>'281117063@qq.com']);
        if($check){
            echo '用户已存在';exit;
        }
        $res = \App\Models\User::create($user);
        if($res){
            //添加菜单
             $menu = [

            ];
        }
    }
}
