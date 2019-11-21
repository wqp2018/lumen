<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/30
 * Time: 11:49
 */

namespace App\Http\Controllers\Api;

use App\Http\Tool\Captcha;
use App\Http\Tool\Logger;
use App\Http\Tool\Export;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class TestApiController extends BaseApiController{

    use Captcha, Logger, Export;

    public function test(){
//        Cache::put("activity_1_num", 10, 3600);

        Cache::decrement("activity_1_num");

        return Cache::get("activity_1_num");
    }

    public function go(){
        ini_set("memory_limit","256M");
        $title = ["海豚座的羞涩", "织女星的凝望", "天琴座的高洁", "亿万年的星光"];
        $data = [
            ["name" => "轻甲", "type" => "泰伯尔斯", "sword" => "苍穹幕落", "level" => 90],
            ["name" => "重甲", "type" => "泰伯尔斯", "sword" => "夜语黑瞳", "level" => 90],
            ["name" => "板甲", "type" => "泰伯尔斯", "sword" => "苍穹幕落", "level" => 90],
            ["name" => "布甲", "type" => "泰伯尔斯", "sword" => "流光星落", "level" => 90],
        ];
        $this->exportExcel("测试.xls", $title, $data, [], ['15','15','15','15'], "test");
    }
}