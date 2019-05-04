<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2
 * Time: 16:42
 */

namespace App\Models\Finance;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinBuy extends Model
{

    use SoftDeletes;
    protected $table = 'coin_buy';
    protected $guarded = [];

    //给coin_name 重新赋值
    public function coinType(){
        return $this->belongsTo("App\Models\Finance\CoinType","coin_type","id");
    }

    //获取卖出列表
    public function soldList(){
        return $this->hasMany("App\Models\Finance\CoinSold","coin_buy_id","id");
    }
}