<?php

use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
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
        for($i = 0; $i < 100; $i++){
            $data[] = [
                'name'=>'author'.$i,
                'pinyin'=>str_random(10),
                'py'=>str_random(5),
                'description'=>$i.'description',
                'is_show'=>1
            ];
        }
        \DB::table('author')->insert($data);
    }
}
