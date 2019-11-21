<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/7
 * Time: 11:08
 */

namespace App\Http\Tool;

trait Import{

    public function getExcelData(){
        $fileName = $_FILES['excel']['tmp_name'];
        if (!$fileName){
            return ["result" => false, "msg" => "请选择excel 文件"];
        }
        $PHPReader = new \PHPExcel_Reader_Excel2007();
        if (!$PHPReader->canRead($fileName)){
            $PHPReader = new \PHPExcel_Reader_Excel5();
            if(!$PHPReader->canRead($fileName)){
                return ["result" => false, "msg" => "请选择excel 文件"];
            }
        }

        $PHPExcel = $PHPReader->load($fileName);

        $excel_array = $PHPExcel->getSheet(0)->toArray();

        var_dump($excel_array);
    }
}