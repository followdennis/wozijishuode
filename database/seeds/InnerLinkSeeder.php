<?php

use Illuminate\Database\Seeder;

class InnerLinkSeeder extends Seeder
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
        for($i = 1; $i< 101; $i++){
            array_push($data,[
                'name'=>$i.'内链',
                'article_id'=>$i,
                'tables_id'=>0,
                'created_at'=>$now
            ]);
        }
        \DB::table('inner_link')->insert($data);
    }
}
