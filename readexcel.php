<?php
/*读取excel文件，并进行相应处理*/

require_once './Classes/PHPExcel/IOFactory.php';

class readExcel {
  public function read ($fileName) {
    ob_end_clean();//清除缓冲区,避免乱码
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");  
    header("Content-Disposition:attachment;filename=".$fileName);
    header("Pragma:no-cache");
    header("Expires:0");
    
    $inputFileType = PHPExcel_IOFactory::identify($fileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($fileName);
    
    $objPHPExcel->setActiveSheetIndex(3);
    $rowCount = $objPHPExcel->getActiveSheet()->getHighestRow();
    $columnCount = $objPHPExcel->getActiveSheet()->getHighestColumn();
    
    $dataArr = array();
    $result = array();
    
    $dateVal = $objPHPExcel->getActiveSheet()->getCell('D15')->getValue();
    $updateTime = $dateVal ? gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($dateVal)) : null;
    $result['updateTime'] = $updateTime;
    for ($row = 17; $row <= $rowCount; $row++){
      $flag = false;
      for ($column = 'B'; $column <= $columnCount; $column++) {
        $v = $objPHPExcel->getActiveSheet()->getCell($column.$row)->getValue();
        if($column === 'E' || $column === 'F') {
          $v = $v ? gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($v)) : null;
          $v = $v ? date('m月d日', strtotime($v)) : null;
        }
        if($column === 'K' || $column === 'L') {
          $v = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(ord($column)-65,$row)->getCalculatedValue();
        }
        if($v) {
          $flag = true;
        }
        $dataArr[$column] = $v;
        $dataArr['row'] = $row;
      }
      if ($flag) {
        $result[] = $dataArr;
      }
      
      $dataArr = null;
    }
    return $result;
  }
}
?>