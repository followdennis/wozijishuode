<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/10
 * Time: 14:58
 */

namespace App\Services;


class FrontCateService
{
    //由拼音获取cate_id
    public function getCateIdByCate($cate = null,$cate_key_val = array()){
        if(!empty($cate)){
            $cate_pinyin = last(explode('_',$cate));
            $cate_id = isset($cate_key_val[$cate_pinyin]) ?$cate_key_val[$cate_pinyin]: 0;
        }else{
            $cate_id = 0;
        }
        return $cate_id;
    }
    public function getCatePYById($cate_id = null,$cate_id_val = array()){
        if(isset($cate_id_val[$cate_id])){
            $cate = $cate_id_val[$cate_id];
        }else{
            $cate = 'default';
        }
        return $cate;
    }
}