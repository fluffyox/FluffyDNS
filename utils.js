// 全局命名空间对象或立即执行函数
var Utils = (function() {
  // 公共函数和工具方法
  function ajaxRequest(url, successCallback, errorCallback) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          successCallback(xhr.responseText);
        } else {
          errorCallback(xhr.status);
        }
      }
    };
    xhr.open("GET", url, true);
    xhr.send();
  }

  // 暴露公共函数和工具方法
  return {
    ajaxRequest: ajaxRequest
  };
})();
