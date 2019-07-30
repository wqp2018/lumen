<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/30
 * Time: 14:53
 */

namespace App\Http\Tool;

use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;
use Monolog\Logger as MonoLogger;

trait Logger{
    private function getLogger($name): LoggerInterface{
        $file = app()->storagePath("logs/$name/" . date('Y-m-d', time()) . ".log");
        return new MonoLogger($name, [new StreamHandler($file)]);
    }
}