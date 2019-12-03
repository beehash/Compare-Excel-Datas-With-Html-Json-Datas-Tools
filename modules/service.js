define('service', ['jquery'], function($) {
  return {
    request: function (params, other) {
      $.ajax({
        url: params.url,
        data: params.data,
        method: params.method || 'get',
        success: function (data) {
          params.success(data, other);
        },
        error: function (err) {
          console.log(err);
        }
      });
    },
    filesRequest: function (params) {
      $.ajax({
        url: params.url,
        data: params.data,
        method: params.method || 'get',
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (data) {
          params.success(data);
        },
        error: function (err) {
          console.log(err);
        }
      });
    }
  }
});