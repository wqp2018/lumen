<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/7
 * Time: 9:55
 */

namespace App\Http\Tool;

trait Export{
    public $letter = [
        'A','B','C','D','E','F','G','H','I','J','K','L','M',
        'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
    ];

    public function exportExcel($name, $title, $data, $header = [], $width, $func){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        if ($header){
            // 设置头部颜色及文字颜色
            $objPHPExcel->getActiveSheet()->getStyle($header['range'])->applyFromArray(
                array(
                    'fill' => array(
                        'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => $header['color'])
                    )
                )
            )->getFont()->setColor( new \PHPExcel_Style_Color( $header['font_color'] ?? \PHPExcel_Style_Color::COLOR_WHITE ));
        }

        foreach ($title as $k => $v){
            $objPHPExcel->getActiveSheet()->getColumnDimension($this->letter[$k])->setWidth($width[$k]);
            $objPHPExcel->getActiveSheet()->setCellValue($this->letter[$k]."1",$v);
        }

        foreach ($data as $k => $v){
            $col = 0;
            $objPHPExcel->getActiveSheet()->setCellValue($this->letter[$col++].($k+2), $v['name'])
                ->setCellValue($this->letter[$col++].($k+2), "￥" . $v['type'])
                ->setCellValue($this->letter[$col++].($k+2), $v['sword'])
                ->setCellValue($this->letter[$col++].($k+2), "￥" . $v['level']);
        }

        $this->export($name, $objPHPExcel);
    }

    public function test($objPHPExcel, $data){
        $letter = $this->letter;
        foreach ($data as $k => $v){
            $col = 0;
            $objPHPExcel->getActiveSheet()->setCellValue($letter[$col++].($k+2), $v['name'])
                ->setCellValue($letter[$col++].($k+2), "￥" . $v['type'])
                ->setCellValue($letter[$col++].($k+2), $v['sword'])
                ->setCellValue($letter[$col++].($k+2), "￥" . $v['level']);
        }

        return $objPHPExcel;
    }

    // 移除emoji 表情，否则出错
    private function removeEmoji($str){
        $value = json_encode($str);
        $value = preg_replace("/\\\u[ed][0-9a-f]{3}\\\u[ed][0-9a-f]{3}/","*",$value);//替换成*
        return json_decode($value);
    }

    private function export($fileName, \PHPExcel $objPHPExcel){
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:attachment;filename="'.$fileName.'"');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save("php://output");

        exit();
    }
}