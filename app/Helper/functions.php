<?php


/**
 * 生成标准uuid（guid）
 * @param type $enableTrim  去掉两侧的大括号
 * @return type
 */
if (! function_exists('guid')) {
    /**
     * @param string $str
     * @return string
     */
    function guid() : string
    {
        if (function_exists('com_create_guid')){
            $guid = com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $guid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
        }
        return  trim($guid, '{}');
    }
}

/**
 * 将数据库中获取数据转换成数组
 * @param type $enableTrim  去掉两侧的大括号
 * @return type
 */
if (! function_exists('obj_to_array')) {
    /**
     * @param string $str
     * @return string
     */
    function obj_to_array($list_arr)
    {
        $list = [];
        if(!empty($list_arr))
        {
            foreach ($list_arr as $r) {
                if(is_object($r))
                {
                    $list[] = \App\Services\Utils::objectToArray($r);
                }else{
                    $list[] = $r;
                }
            }
        }
        return $list;
    }
}