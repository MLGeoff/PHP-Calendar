function createRequestObject(){
    var request_o;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer"){
    request_o = new ActiveXObject("Microsoft.XMLHTTP");
    } else{
    request_o = new XMLHttpRequest();
    }
    return request_o;
    }