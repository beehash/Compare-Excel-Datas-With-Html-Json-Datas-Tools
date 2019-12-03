<?php
header('Content-Type:application/json;charset=utf-8');
// 允许上传的图片后缀
$uname=$_REQUEST['uname'];
$allowedExts = array('xls', 'xlsx');
$temp = explode(".", $_FILES["upfile"]["name"]);
$extension = end($temp);     // 获取文件后缀名
if ((($_FILES["upfile"]["type"] == "application/vnd.ms-excel")
|| ($_FILES["upfile"]["type"] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"))
&& ($_FILES["upfile"]["size"] < 1024*1024*6)   // 小于 6M
&& in_array($extension, $allowedExts)){
    if ($_FILES["upfile"]["error"] > 0){
        echo '{"code":-2,"msg":"文件上传错误,请稍后再试"}';
    }else{
      move_uploaded_file($_FILES["upfile"]['tmp_name'],"../upload/".$uname);
      if (file_exists("../upload/".$_FILES["upfile"]["name"])){
        echo '{"code":1,"msg":"文件已经存在"}';
      }else{
        echo '{"code":2,"msg":"文件上传成功"}';
      }
    }
}else{
    echo '{"code":-1,"msg":"非法的文件格式"}';
}
?>
