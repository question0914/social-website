/**
 * Created by zijianli on 7/7/17.
 */

function contactPop() {
    $.ajax({
        url: '/contactPopUp',
        type: 'get',
        success: function(resp) {
            //alert(resp);
            document.getElementById('contactPopup').innerHTML = resp;
            $("#contactPop").modal('show');

        }
    });
}

function uploadphoto() {
    $.ajax({
        url: '/uploadPhoto',
        type: 'get',
        success: function(resp) {
            document.getElementById('uploadPhoto').innerHTML = resp;
            var $imageupload = $('.imageupload');
            $imageupload.imageupload();

            /*            var regDetectJs = /<script(.|\n)*?>(.|\n|\r\n)*?<\/script>/ig;
             var jsContained = resp.match(regDetectJs);


             if(jsContained) {

             var regGetJS = /<script(.|\n)*?>((.|\n|\r\n)*)?<\/script>/im;


             var jsNums = jsContained.length;
             for (var i=0; i<jsNums; i++) {
             var jsSection = jsContained[i].match(regGetJS);

             if(jsSection[2]) {
             if(window.execScript) {
             // IE
             window.execScript(jsSection[2]);
             } else {
             window.eval(jsSection[2]);
             }
             }
             }
             }*/
            $("#upload").modal('show');

        }
    });
}
