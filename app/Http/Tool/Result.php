<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/30
 * Time: 11:02
 */

namespace App\Http\Tool;

class Result{

    public static function success($msg = "", $data = [], $code = 200, $extra = ""){
        $result = [
            "msg" => $msg,
            "data" => $data,
            "code" => $code,
            "extra" => $extra,
            "server_time" => time()
        ];

        return $result;
    }

    public static function fail($msg = "", $code = 0, $extra = ""){
        $result = [
            "msg" => $msg,
            "code" => $code,
            "extra" => $extra,
            "server_time" => time()
        ];

        return $result;
    }

}