<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Overtrue\Pinyin\Pinyin;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    use EntrustUserTrait;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','py','pinyin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getList(){
        return self::whereNull('deleted_at')->orderBy('created_at','desc');
    }
    public function getInfoById($id){
        return self::whereNull('deleted_at')->find($id);
    }

    public function delUser($id){
        $now = Carbon::now()->format('Y-m-d H:i:s');
        return self::where('id',$id)->update(['deleted_at'=>$now]);
    }
    /**
     * 添加
     * @param $id
     * @param $data
     * @param $role_ids
     * @return bool
     */
    public function insertUser($data,$role_ids)
    {
        $now_time = Carbon::now()->format('Y-m-d H:i:s');
        $data['created_at'] = $now_time;
        $data['updated_at'] = $now_time;

//        $pinyin = new Pinyin();
//        $name_spell = $pinyin->permalink($data['name'],'');
//        $name_initial = $pinyin->abbr($data['name']);
//        $data['pinyin'] = $name_spell;
//        $data['py'] = strtoupper($name_initial);


        DB::beginTransaction();
        $user_id = DB::table($this->table)->insertGetId($data);
        $r_status = true;
        if(!empty($role_ids))
        {
            $insert_data = [];
            foreach ($role_ids as $role_id)
            {
                array_push($insert_data,['user_id'=>$user_id,'role_id'=>$role_id]);
            }
            $r_status = DB::table('role_user')->insert($insert_data);
        }
        if($user_id && $r_status)
        {
            DB::commit();
            return true;
        }else{
            DB::rollback();
            return false;
        }
    }
    /**
     * 编辑用户
     */
    public function updateUser($data,$role_ids,$id){
        $user = DB::table($this->table)->whereNull('deleted_at')->where('id',$id)->first();
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $data['updated_at'] = $now;
        if(empty($data['password'])){
            unset($data['password']);
        }
        if(!empty($user)){
            DB::beginTransaction();

            $u_status = DB::table($this->table)->where('id',$id)->update($data);

            $r_status = true;
            $del_status = true;
            $exist_role_user = DB::table('role_user')->where('user_id',$id)->first();


            if(!empty($role_ids)){
                if($exist_role_user){
                    $del_status = DB::table('role_user')->where('user_id',$id)->delete();
                }
                $user_role = [];
                foreach($role_ids as $role_id){
                    array_push($user_role,[
                        'user_id'=>$id,
                        'role_id'=>$role_id
                    ]);
                }
                $r_status = DB::table('role_user')->insert($user_role);
            }
            if($u_status && $del_status && $r_status){
                DB::commit();
                return true;
            }else{
                DB::rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    public function userRoles($id){
        $list = DB::table('role_user')->where('user_id',$id)->get();
        $roles = [];
        if(!empty($list)){
            foreach($list as $k => $v){
                $roles[] = $v->role_id;
            }
        }
        return $roles;
    }
    /**
     * @param string $name
     * @param string $email
     * @return mixed
     * 验证字段
     */
    public function checkUserExists($name = '',$email = '',$id = 0){
        return DB::table($this->table)
            ->where(function($query) use($name,$email,$id){
                if(!empty($name)){
                    $query->where('name',$name);
                }
                if(!empty($email)){
                    $query->where('email',$email);
                }

                if($id != 0){
                    $query->where('id','<>',$id);
                }
            })
            ->whereNull('deleted_at')->first();
    }
    /**
     * 组成首字母大写
     * @param $area_name_spell
     * @return string
     */
    public function upperFirstChar($area_name_spell)
    {
        if(!is_array($area_name_spell)) return '';
        $str = '';
        foreach ($area_name_spell as $spell)
        {
            $str .= ucfirst($spell);
        }
        return $str;
    }
}
