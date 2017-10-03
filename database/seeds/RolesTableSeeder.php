
<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arr = [];
        for($i = 1; $i<31;$i++){
            $arr[] = [
                'name'=>'角色'.$i,
                'display_name'=>'展示名称'.$i,
                'description'=>'描述'.$i,
                'created_at'=>\Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ];
        }
        \DB::table('roles')->insert($arr);
    }
}
