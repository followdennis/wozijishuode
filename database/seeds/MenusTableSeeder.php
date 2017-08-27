<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')->insert([
                array('id'=>1 , 'name'=>'首页' , 'parent_id'=>'0'),
                array('id'=>2 , 'name'=>'新闻中心' , 'parent_id'=>'1'),
                array('id'=>3 , 'name'=>'娱乐新闻' , 'parent_id'=>'2'),
                array('id'=>4 , 'name'=>'军事要闻' , 'parent_id'=>'2'),
                array('id'=>5 , 'name'=>'体育新闻' , 'parent_id'=>'2'),
                array('id'=>6 , 'name'=>'博客' , 'parent_id'=>'1'),
                array('id'=>7 , 'name'=>'旅游日志' , 'parent_id'=>'6'),
                array('id'=>8 , 'name'=>'心情' , 'parent_id'=>'6'),
                array('id'=>9 , 'name'=>'小小说' , 'parent_id'=>'6'),
                array('id'=>10 , 'name'=>'明星' , 'parent_id'=>'3'),
                array('id'=>11 , 'name'=>'网红' , 'parent_id'=>'3')
        ]);
    }
}
