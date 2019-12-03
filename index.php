<?php
// $fname = $_GET['filename'];
$fname = '上海ディレクター露出入稿シート.xls';
header("Content-Type: text/html; charset=utf-8");  
date_default_timezone_set("PRC");
/*读取excel文件，并进行相应处理*/

$fileName = '../upload/'.$fname;
if (!file_exists($fileName)) {
  exit("文件".$fileName."不存在");
}

include_once './readexcel.php';
include_once './cratchhtml.php';

  $readExcel = new readExcel();
  $excelDatas = $readExcel->read($fileName);
  $leng = count($excelDatas)-1;

  $webJson = new cratchJson();
  $webJsonDatas = $webJson->cratch();
  $webJsonDatas = substr(json_decode($webJsonDatas), 3);
  $webJsonDatas = json_decode($webJsonDatas, true);

  $unMatchedList = array();
  $time = time();
  $currentTime = date('Y-m-d H:i:s', $time);
  
  $noMatch = false;

  foreach ($webJsonDatas as $k => $value) {
    $only_url = $value['url'];
    $ine = strpos($only_url, '?');
    $only_url = substr($only_url, 0, $ine);
    $value['url'] = $only_url;
    $matched_row = null;
    $row = null;
    $index = null;
    $keys = array();
    
    // find the matched rows
    for($i = 0; $i < $leng; $i++) {
      $temp_url = $excelDatas[$i]['G'];
      if ($only_url === $temp_url) {
        $matched_row = $excelDatas[$i];
        $row = $excelDatas[$i]['row'];
        $index = $i;
        break;
      }
    }
    $flag = true;
    if ($matched_row) {
      foreach($value as $key => $web_in_value) {
        $t = false;
        
        foreach($matched_row as $k => $m_value) {
          if($web_in_value === $m_value) {
            $t = true;
            break;
          }
        }
        
        if(!$t) {
          $flag = false;
          $keys[] = $key;
        }
      }
    } else {
      $nomatch = true;
    }
    
    if(!$flag) {
      $unMatchedList[] = array( 
        "excel" => array("row" => $row),
        "html" => array("index" => $index, "key" => $keys),
        "currentTime" => $currentTime
      );
    }
  }
  

  $file_input = fopen('../result.txt', 'w');
  $file_info = "不匹配的行：\r\n\r\n";
  $file_info .= "报告时间：".$currentTime."\r\n\r\n";
  if(count($unMatchedList)){
    foreach ($unMatchedList as $v) {
      $file_info.="在表格中，第".$v['excel']['row']."行不匹配\r\n";
      $file_info.="在json中，第".$v['html']['index']."行不匹配，字段名称是：".implode(', ', $v['html']['key'])."。 【nextRow】\r\n\r\n";
    }
    $unMatchedList['code'] = 1;
  }else if($nomatch){
    $unMatchedList['code'] = -1;
    $unMatchedList['currentTime'] = $currentTime;
    $unMatchedList['result'] = 'no matched rows';
    $file_info.='no matched rows';
  } else{
    $unMatchedList['code'] = -2;
    $unMatchedList['currentTime'] = $currentTime;
    $unMatchedList['result'] = 'no error';
    $file_info.='no error';
  }
  
  fwrite($file_input, $file_info);
  fclose($file_input);
  
  echo json_encode($unMatchedList);
?>