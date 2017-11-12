<?php

use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
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
        $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        for($i = 1; $i< 50; $i++){
            array_push($data,[
                'article_id'=>$i+1,
                'user_id'=>mt_rand(1,10),
                'comment'=>$i.'评论内容'.str_random(20),
                'like'=>mt_rand(10,50),
                'parent_id'=>mt_rand(1,5),
                'is_hidden'=>0,
                'created_at'=>$now
            ]);
        }
        \DB::table('comments')->insert($data);
    }
}
