require.config({
  baseurl: './lib',
  paths: {
    jquery: './lib/jquery-3.4.1.min',
    service: './modules/service',
    uploadfile: './modules/upload',
    message: './modules/message',
  },
});

// require some dependent modules
require(['jquery', 'message', 'uploadfile', 'service'], function ($, message, up, service) {
    // handle excel success data
  var handleExcelResponse = function (res) {
    var excelDatas = JSON.parse(res);
    if(excelDatas.code > 0) {
      var html = '<h3 class="title">unmatched Datas:</h3>';
      for(var n in excelDatas) {
        html +='<p class="report-line"><span>report time: '+ excelDatas[n].currentTime +'</span><span>excel locat at：line' + excelDatas[n].excel.row + '</span><span>json locat at：line' + excelDatas[n].html.index + ', name：' + excelDatas[n].html.key.join(',') + '</span></p>';
      }
      $('.filescomparehtml_area').html(html);
    }else if (excelDatas.code === -2){
      $('.filescomparehtml_area').html('<p class="centralize-text">there is no datas error</p>');
    } else if(excelDatas.code === -1) {
      $('.filescomparehtml_area').html('<p class="centralize-text">no matched rows</p>');
    }
  }
  
  
  
  $("#uploadfile").click(function () {
    up.upload(function (filename, res) {
      $("#load").hide();
      if (res.code > 0) {
        message.alert({popText: '文件上传成功'});
        // request excel params
        var excelParams = {
          url: './handlefile/index.php',
          data: {filename},
          success: handleExcelResponse,
        }
        // request excel data
        service.request(excelParams);
      } else {
        // pop up some errors about upload file
        message.alert({popText: res.msg});
      }
    });
  });

});
