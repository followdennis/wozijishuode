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

class CoinSold extends Model
{

    use SoftDeletes;
    protected $table = 'coin_sold';
    protected $guarded = [];
}