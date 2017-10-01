<?php

namespace App\Services;

/**
 * Created by PhpStorm.
 * User: lotus
 * Date: 16/11/11
 * Time: 上午11:53
 */

class Utils
{
    /**
     * @param $tel
     * @param string $type 指定检验类型，不指都检测
     * @return bool
     */
    public static function isTel($tel,$type='')
    {
        $regxArr = array(
            'sj'  =>  '/^(\+?86-?)?(18|15|13|16|17)[0-9]{9}$/',
            'tel' =>  '/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/',
            '400' =>  '/^400(-\d{3,4}){2}$/',
        );
        if($type && isset($regxArr[$type]))
        {
            return preg_match($regxArr[$type], $tel) ? true:false;
        }
        foreach($regxArr as $regx)
        {
            if(preg_match($regx, $tel ))
            {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    public static function getClientIp($type = 0, $adv = false) {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL)
            return $ip[$type];
        if ($adv) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos)
                    unset($arr[$pos]);
                $ip = trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /**
     * 数组转对象
     * @param $e
     * @return object|void
     */
    public static function arrayToObject($array){
        if( gettype($array)!='array' )
        {
            return;
        }
        foreach($array as $k=>$v)
        {
            if( gettype($v)=='array' || getType($v)=='object' )
            {
                $array[$k]=(object)self::arrayToObject($v);
            }
        }
        return (object)$array;
    }

    /**
     * 对象转数组
     * @param $e
     * @return array|void
     */
    public static function objectToArray($object){
        $object=(array)$object;
        foreach($object as $k=>$v)
        {
            if( gettype($v)=='resource' )
            {
                return ;
            }
            if( gettype($v)=='object' || gettype($v)=='array' )
            {
                $object[$k]=(array)self::objectToArray($v);
            }
        }
        return $object;
    }

    /**
     * 生成图片路径模式名称
     * @param $module_name 如: category
     * @param string $filename
     * @return string  images/product/2016072512352.png
     */
    public static function create_path_name($module_name,$filename = ''){
        $path_name = 'images/'.$module_name;
        $ext = '';
        if($filename != ''){
            $ext = substr($filename,strrpos($filename,'.'));
        }
        list($u, $s) = explode(' ',microtime());
        $s = date('ymdhis',$s);
        $result = $s.($u* pow(10,2));
        if(strpos($result,'.')){
            list($result,$useless) = explode('.',$result);
        }
        $name = $path_name.'/'.$result.self::getRandCode(6);
        return $name.$ext;
    }

    /**
     * 获取直定长度随机码
     * @param type $length
     * @param type $type 0 纯数字 1 数字、小写字母 2 数字、小写字母、大写字母
     * @return string
     */
    public static function getRandCode($length = 6,$type = 0)
    {
        if($type == 0) {
            $str = '0123456789';
        }else if($type == 1){
            $str = '0123456789abcdefghijklmnopqrstuvwxyz';
        }else{
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $len = strlen($str);
        $retStr = '';
        for($i=0;$i<$length;$i++){
            $retStr .= $str[rand(0, $len-1)];
        }
        return $retStr;
    }

    /**
     * @param $msg 提示信息
     * @param $url_forward 跳转url ,关闭对话框时该值为容
     * @param int $timeout 等待跳转时间
     * @param int $layer_index  对话框f
     */
    public static function show_message($msg,$url_forward,$timeout=0,$layer_index=0)
    {
        include(__DIR__.'./../../resources/views/Common/show_message.blade.php');
    }

    /**
     * 转化 \ 为 /
     *
     * @param	string	$path	路径
     * @return	string	路径
     */
    public static function dir_path($path) {
        $path = str_replace('\\', '/', $path);
        if(substr($path, -1) != '/') $path = $path.'/';
        return $path;
    }

    /**
     * 删除目录及目录下面的所有文件
     *
     * @param	string	$dir		路径
     * @return	bool	如果成功则返回 TRUE，失败则返回 FALSE
     */
    public static function dir_delete($dir) {
        $dir = self::dir_path($dir);
        if (!is_dir($dir)) return FALSE;
        $list = glob($dir.'*');
        foreach($list as $v) {
            is_dir($v) ? dir_delete($v) : @unlink($v);
        }
        return @rmdir($dir);
    }


    public static function sksort(&$array, $subkey = "id", $sort_ascending = false){
        if (count($array))
            $temp_array[key($array)] = array_shift($array);
        foreach ($array as $key => $val) {
            $offset = 0;
            $found = false;
            foreach ($temp_array as $tmp_key => $tmp_val) {
                if (!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
                    $temp_array = array_merge((array) array_slice($temp_array, 0, $offset), array($key => $val), array_slice($temp_array, $offset)
                    );
                    $found = true;
                }
                $offset++;
            }
            if (!$found)
                $temp_array = array_merge($temp_array, array($key => $val));
        }
        if ($sort_ascending)
            $array = array_reverse($temp_array);
        else
            $array = $temp_array;
    }
}