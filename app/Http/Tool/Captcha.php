<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/30
 * Time: 11:29
 */

namespace App\Http\Tool;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

trait Captcha{

    /*
     *  生成验证码
     * */
    public function getCaptcha(Request $request){
        $captcha_key = $request->get("key");
        $phrase = new PhraseBuilder;

        $code = $phrase->build(4);

        $builder = new CaptchaBuilder($code, $phrase);
        $builder->setMaxAngle(25);
        $builder->build(200, 60, null);

        $phrase = $builder->getPhrase();

        //把内容存入Cache
        Cache::put($captcha_key, $phrase, 5 * 60);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        header('val: ' . $phrase);
        $builder->output();
    }

    public function loadCaptcha(){
        $captcha_key = "captcha" . mt_rand();
        $data['url'] = url('/getCaptcha') . "?key=" . $captcha_key;
        $data['key'] = $captcha_key;

        $data['result'] = 200;
        $data['msg'] = "ok";
        $data['server_time'] = time();

        return $data;
    }

    /*
     *  验证验证码
     * */
    private function verifyCaptcha($key, $captcha): bool {
        if (env('APP_ENV') === 'local') return true;

        $captcha_val = Cache::get($key);
        if ($captcha_val && strtoupper($captcha_val) === strtoupper($captcha)){
            Cache::forget($key);
            return true;
        }
        return false;
    }
}