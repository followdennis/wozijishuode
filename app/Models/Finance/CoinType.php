<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/3
 * Time: 16:13
 */

namespace App\Models\Finance;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinType extends Model
{
    use SoftDeletes;
    protected $table = "coin_type";
    protected $guarded = [];

}