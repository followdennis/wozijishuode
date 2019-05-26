<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2
 * Time: 16:49
 */

namespace App\Repository;


use App\Models\Finance\CoinBuy;
use App\Models\Finance\CoinSold;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class FinanceRepository extends Model
{

    //新增买入
    public function insertBuy($params = []){
        $params['user_id'] = Auth::user()->id;
        return CoinBuy::create($params);
    }
    //删除买入
    public function  deleteBuy($id){
        $user_id = Auth::user()->id;
        return CoinBuy::where('user_id',$user_id)->where('id',$id)->delete();
    }
    //编辑买入
    public function editBuy($id,$params = []){
        $user_id = Auth::user()->id;
        return CoinBuy::where('user_id',$user_id)->where('id',$id)->update($params);
    }

    //买入列表数据
    public function selectBuyList($pageSize = 10){
        $user_id = Auth::user()->id;
        $list = CoinBuy::where('user_id',$user_id)
            ->orderBy("id","desc")
            ->paginate($pageSize);
        foreach( $list->items() as $item){
            //关联表获取币种名称
            $item->coin_name = $item->coinType->alias . "(" .$item->coinType->coin_name . ")";
            $item->sold_list = $item->soldList;
            //卖出数量
            $item->sold_count = 0;
            //卖出总额
            $item->sold_money = 0;
            //卖出平均单价
            $item->sold_money_avg = 0;
            //总利润
            $item->sold_profit = 0;
            //利润率
            $item->sold_profit_rate = 0;
            //周期，天
            $item->life_circle = 0;

            $item_count = 0;
            $profit = 0;
            foreach( $item->soldList as $sold){

                $item_count++;
                //卖出数量
                $item->sold_count += $sold->count;
                //卖出总金额
                $item->sold_money += $sold->sold_money;
                //卖出总利润
                $profit += $sold->gross_profit;
                //买入价格
                $sold->buy_unit_price = $item->unit_price;
                //购买总额
                $sold->buy_money = $item->total_money;

            }
            if( $item_count ){
                $item->sold_profit = $profit; //已卖出的总利润
                //卖出的利润率
                //成本价
                $cost = $item->sold_count * $item->unit_price;
                if( $cost > 0){
                    $item->sold_profit_rate = round((100 *$item->sold_profit) / $cost,2) ;
                }

            }
            $item->left_count = $item->count - $item->sold_count;

        }
        return $list;
    }

    /**
     * 新增卖出
     */
    public function insertSold($params = []){
        $user_id = Auth::user()->id;
        $params['user_id'] = $user_id;
        return CoinSold::create($params);
    }
    /**
     * 修改卖出
     */
    public function editSold($id,$params = []){
        $user_id = Auth::user()->id;
        return CoinSold::where('user_id',$user_id)->where('id',$id)->update($params);
    }
}