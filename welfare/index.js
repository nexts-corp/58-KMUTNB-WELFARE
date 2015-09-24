//test confict file by somchit
//somchit

$(document).ajaxStart(function () {
    //console.log("Triggered ajaxStart handler.");
 
    $(".loading-container").removeClass("loading-inactive");
});

$(document).ajaxStop(function () {
   // console.log("Triggered ajaxStop handler.");
    $(".loading-container").addClass("loading-inactive");
    
});

function getCode(code) {
    var data;
    $.ajax({
        url: '/welfare/api/taxonomy/taxonomy/getCode',
        type: 'post',
        data: {code: code},
        async: false,
        error: function (xhr) {
            if (xhr.status == 401) {
                window.location.href = xhr.getResponseHeader('Location');
            }
        },
        success: function (result) {
            data = result["lists"];
        }
    });
    return data;
}
function getPCode(pCode) {
    var data;
    $.ajax({
        url: '/welfare/api/taxonomy/taxonomy/getPCode',
        type: 'post',
        data: {pCode: pCode},
        async: false,
        error: function (xhr) {
            if (xhr.status == 401) {
                window.location.href = xhr.getResponseHeader('Location');
            }
        },
        success: function (result) {
            data = result["lists"];
        }
    });
    return data;
}
function getParentId(parentId) {
    var data;
    $.ajax({
        url: '/welfare/api/taxonomy/taxonomy/getParentId',
        type: 'post',
        data: {parentId: parentId},
        async: false,
        error: function (xhr) {
            if (xhr.status == 401) {
                window.location.href = xhr.getResponseHeader('Location');
            }
        },
        success: function (result) {
            data = result["lists"];
        }
    });
    return data;
}
function btnHTML(value) {
    var id = $(value).data("id");
    var api = $(value).data("api");
    var object = $(value).data("object");
    var param = $(value).data("param");
    var data = {};
    if (typeof object == 'undefined' || typeof param == 'undefined') {
        data = null;
    } else {
        data[object] = param;
    }
    getHTML(id, api, data);
}

function getHTML(id, link, data) {
    
    //have data ==> getHTML("navbar","/api/xxx/xxx/",{name:name});
    ////have data ==> getHTML("navbar","/api/xxx/xxx/",jsonEncode(xxx));
    //dont have data ==> getHTML("navbar","/api/xxx/xxx/",null);
    if (data == null) {
        $.ajax({
            url: link,
            type: 'post',
            async: true,
            error: function (xhr) {
                if (xhr.status == 401) {
                    window.location.href = xhr.getResponseHeader('Location');
                }
            },
            success: function (result) {
                $('#' + id).html(result);
            }
        });
    } else {
        $.ajax({
            url: link,
            data: data,
            type: 'post',
            async: true,
            error: function (xhr) {
                if (xhr.status == 401) {
                    window.location.href = xhr.getResponseHeader('Location');
                }
            },
            success: function (result) {
                $('#' + id).html(result);
            }
        });
    }
}
function sendData(url, data,callback) {
   // var callback;
    $.ajax({
        url: url,
        data: data,
        type: 'post',
        async: true,
        error: function (xhr) {
            if (xhr.status == 401) {
                window.location.href = xhr.getResponseHeader('Location');
            }
        },
        success: function (result) {
           // callback = result;
           callback(result);
        }
    });
    //return callback;
}

function jsonEncode(data) {
    var dataJSON = JSON.stringify(data);
    var dataJSONEN = encodeURIComponent(dataJSON);
    return dataJSONEN;
}

