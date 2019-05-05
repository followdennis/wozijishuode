<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/2
 * Time: 16:25
 */

namespace App\Http\Controllers\Admin\Finance;


use App\Http\Controllers\AdminController;
use App\Models\Finance\CoinBuy;
use App\Models\Finance\CoinType;
use App\Repository\FinanceRepository;
use Illuminate\Http\Request;

class VirtualCoinController extends AdminController
{
    //虚拟币资产管理
    protected $financeRep;
    protected $req;
    public function __construct(Request $request,FinanceRepository $financeRep)
    {
        parent::__construct($request);
        $this->req = $request;
        $this->financeRep = $financeRep;
    }

    /**
     * created by gavin
     * date 2019/5/2 16:34
     * desc : 买入页面
     */
    public function index(){

        return view("admin.finance.index");
    }
    /**
     * created by gavin
     * date 2019/5/3 13:59
     * desc : 获取买入列表数据
     */
    public function lists(){

        //列表数据
        $list = $this->financeRep->selectBuyList();
        $res = setPageData($list);
        return response()->json($res);
    }

    /**
     * created by gavin
     * date 2019/5/2 16:36
     * desc : 新增买入
     */
    public function addBuy(){
        $params = $this->req->all();
        $data['coin_type'] = $params['coin_type'];
        $data['count'] = $params['count'];
        $data['total_money'] = $params['total_money'];
        $data['unit_price'] = $params['unit_price'];
        $data['market_price'] = $params['market_price'];
        $data['buy_time'] = $params['buy_time'];
        $data['remark'] = $params['remark'];
        $data['left_count'] = $params['count'];
        $status = $this->financeRep->insertBuy($data);
        if( $status ){
            return response()->json(['code'=>0,'msg'=>'新增购买成功']);
        }
        return response()->json(['code'=>-1,'msg' => '新增失败']);
    }


    /**
     * created by gavin
     * date 2019/5/2 16:38
     * desc : 删除买入
     */
    public function delBuy(){
        $params = $this->req->all();
        $id = $params['id'];

    }
    /**
     * created by gavin
     * date 2019/5/2 16:39
     * desc : 编辑买入，如果有子记录则不能修改
     */
    public function editBuy(){
        $params = $this->req->all();
        $id = $params['id'];
        $data['count'] = $params['count'];
        $data['total_money'] = $params['total_money'];
        $data['unit_price'] = $params['unit_price'];
        $data['market_price'] = $params['market_price'];
        $data['left_count'] = $params['left_count'];
        $data['coin_type'] = $params['coin_type'];
        $data['buy_time'] = $params['buy_time'];
        $data['remark'] = $params['remark'];

        $status = $this->financeRep->editBuy($id,$data);
        if( $status ){
            return response()->json(['code'=>0,'msg'=>'修改成功']);
        }
        return response()->json(['code'=>-1,'msg' => '修改失败']);
    }

    /**
     * created by gavin
     * date 2019/5/2 16:40
     * desc : 新增卖出
     */
    public function addSold(){
        $params = $this->req->all();
        $data['coin_buy_id'] = $params['coin_buy_id'];
        $data['count'] = $params['count'];
        $data['sold_money'] = $params['sold_money'];//卖出总额
        $data['sold_price'] = $params['sold_unit_price'];//卖出单价

        $data['sold_time'] = $params['sold_time'];
        $data['remark'] = $params['remark'];
        $data['price_diff'] = $params['sold_unit_price'] - $params['buy_unit_price'];//价格差
        $data['profit_margin'] = 0;

        //利润
        //买入数量与卖出数量相同时
        if($params['count'] == $params['buy_count']){
            // 买入总额  buy_money
            $data['gross_profit'] = round($params['sold_money'] - $params['buy_money'],4);
        } else {
            $data['gross_profit'] = round($params['sold_money'] - $params['buy_unit_price'] * $params['count'],4);
        }
        //利润率
        if( $params['buy_unit_price']){
            if($params['count'] == $params['buy_count']){
                $data['profit_margin'] = round((100 * $data['gross_profit'] )/ $params['buy_money'],2);

            } else {
                $data['profit_margin'] = round((100 * $data['price_diff'] )/ $params['buy_unit_price'],2);
            }
        }

        $status = $this->financeRep->insertSold($data);
        if( $status ){
            return response()->json(['code'=>0,'msg'=>'新增卖出成功']);
        }
        return response()->json(['code'=>-1,'msg' => '新增失败']);


    }
    /**
     * created by gavin
     * date 2019/5/2 16:41
     * desc : 删除卖出
     */
    public function delSold(){
        echo 'delsold';
    }

    public function editSold(){
        $params = $this->req->all();
        $id = $params['id'];
        $data['count'] = $params['count'];
        $data['sold_money'] = $params['sold_money'];
        $data['sold_price'] = $params['sold_unit_price'];
        $data['sold_time'] = $params['sold_time'];
        $data['remark'] = $params['remark'];



        $data['price_diff'] = $params['sold_unit_price'] - $params['buy_unit_price'];//价格差
        $data['profit_margin'] = 0;

        //利润

        //买入数量与卖出数量相同时
        if($params['count'] == $params['buy_count']){
            // 买入总额  buy_money
            $data['gross_profit'] = round($params['sold_money'] - $params['buy_money'],4);
        } else {
            $data['gross_profit'] = round($params['sold_money'] - $params['buy_unit_price'] * $params['count'],4);
        }

        if( $params['buy_unit_price']){
            if($params['count'] == $params['buy_count']){
                $data['profit_margin'] = round((100 * $data['gross_profit'] )/ $params['buy_money'],2);

            } else {
                $data['profit_margin'] = round((100 * $data['price_diff'] )/ $params['buy_unit_price'],2);
            }
        }

        $status = $this->financeRep->editSold($id,$data);
        if( $status ){
            return response()->json(['code'=>0,'msg'=>'编辑卖出成功']);
        }
        return response()->json(['code'=>-1,'msg' => '修改失败']);
    }
    public function getCoinList(){
        $list = CoinType::orderBy("sort","desc")->select("coin_name","id","alias")->get()->toArray();
        return response()->json($list);
    }

}