<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
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
        for($i = 0; $i < 11 ;$i++){
            $data[] = [
                'name'=>'名字'.str_random('10'),
                'description'=>'描述'.$i,
                'tables_id'=>0,
                'created_at'=>$now
            ];
        }
        \DB::table('tags')->insert($data);
        echo "填充完毕";
    }
}
