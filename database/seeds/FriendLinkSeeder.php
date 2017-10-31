<?php

use Illuminate\Database\Seeder;

class FriendLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [];
        for($i = 0; $i< 10; $i++){
            array_push($data,[
               'name'=>'散文网'.($i+1),
                'link_url'=>'www.baidu.com',
                'sort'=>mt_rand(1,10),
                'is_front'=>mt_rand(0,1),
                'description'=>'一个好网站',
                'created_at'=>date('Y-m-d H:i:s')
            ]);
        }
        \DB::table('friend_link')->insert($data);
    }
}
