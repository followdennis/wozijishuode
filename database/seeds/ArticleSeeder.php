<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $start = microtime(true);
        $select_status = \DB::connection('mysql_center')
            ->table('renshengzhinan')
            ->orderBy('id', 'asc')
            ->chunk(1000, function ($reshengzhinan) {
                $data = [];
                $now = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
                foreach($reshengzhinan as $k => $v){
                    array_push($data,[
                        'title'=>$v->title,
                        'cate_name'=>$v->cate1,
                        'cate_id'=>mt_rand(1,10),
                        'click'=>mt_rand(100,1000),
                        'created_at'=>$now
                    ]);
                }
                $insert_status = \DB::table('article')->insert($data);

            });
        $end = microtime(true);
        echo "finish";
        echo $end-$start;
    }
}
