<?php

use Illuminate\Database\Seeder;

class MoveArticleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $select_status = \DB::connection('mysql_center')->table('renshengzhinan')->orderBy('id','asc')->chunk(1000,function($reshengzhinan) {
            $now = date('Y-m-d H:i:s',time());
            $index = [];
            $body = [];
            $head = [];

            for($i = 1; $i < 1001; $i++){
                array_push($index,[
                    'cate_id'=>mt_rand(1,10),
                    'is_show'=>1,
                    'created_at'=>$now
                ]);
            }
            $inserIndex = \DB::table('article_index')->insert($index);

            $ids = \DB::table('article_index')->orderBy('id','desc')->take(1000)->pluck('id')->toArray();
             sort($ids);//返回值不是结果集
            foreach($reshengzhinan as $k => $v){
                array_push($head,[
                    'title'=>$v->title,
                    'cate_name'=>$v->cate1,
                    'click'=>mt_rand(100,1000)
                ]);
                array_push($body,[
                    'content'=>$v->content
                ]);
            }

            $head = array_add_column($head,$ids,false);
            $body = array_add_column($body,$ids,false);

            $last = last($ids);
            $head_id = ceil($last/10000);
            $body_id = ceil($last/5000);
            $head_status = \DB::table('article_head_'.$head_id)->insert($head);
            $body_status = \DB::table('article_body_'.$body_id)->insert($body);

            if($head_status && $body_status){
                info('ok');
            }else{
                info($ids);
            }
            unset($body);
            unset($head);
            unset($index);
            unset($ids);
        });
    }
}
