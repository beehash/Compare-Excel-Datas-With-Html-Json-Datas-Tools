<?php
class cratchJson {
  public function cratch () {
    $url="https://travel.rakuten.co.jp/share/themes/top/config/top.dh.campaign.json";
    $ch = curl_init();
    $header = array();  //http头数组
    $header[] = 'Host:travel.rakuten.co.jp';
    $header[] = 'User-Agent:Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:23.0) Gecko/20100101 Firefox/23.0';
    $header[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
    $header[] = 'Accept-Language:"en-Us,en;q=0.5"';
    $header[] = 'Accept-Encoding:"deflate"';
    $header[] = 'Referer:"https://travel.rakuten.co.jp"';
    $header[] = 'Cookie:mall_fp_ab=2012b; cna=bBiqCsrWeRUCAXbGun/HhKLU; cq=ccp=1; otherx=e=1&p=*&s=0&c=0&f=0&g=0&t=0; x=__ll=-1&_ato=0; t=7009aef24f80bf19638795f67e442046; tracknick=hellobiaobiao; _tb_token_=KYsNvQICZGpL; cookie2=2d70cfb31e8da274de2f3eaed2d1612e; pnm_cku822=008uZ+ZXOTBiNH0MRQyyh8Jj9nPuf+Zr9lfeqJ6|uqxpf0k/uS85fwk/Oa/JX4c=|u51Y4MWiOxFIIdhSd7KXsYeiZ0KFHPWvJQDYAA==|vIpP92FnosSSV0FnYUeClAKUgkdRd/H3MrSytHFnQVcBxLLEonqi|vauNSG17TTu9Kz17DTs9q81b/fseCH54fmheCF54DkjOSN7IvvjdBQ==|vqg++0N1sCYgpmMl4MUARoOVsGiw|v/n/+Tw6/9kcer+p7+ksGkwq8g==';
    $header[] = 'Connection:keep-alive';
    
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  //设置http头
    curl_setopt($ch, CURLOPT_HEADER, 0);  //显示返回的Header区域内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//禁止调用时就输出获取到的数据
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3000);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_ENCODING ,'gzip');
    
    $htmlContent = curl_exec($ch);
    curl_close($ch);
    return json_encode($htmlContent);
  }
}

?>