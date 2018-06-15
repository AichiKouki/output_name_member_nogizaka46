//ファイルをドラッグ&ドロップでアップするためのプログラム
var waitList=[];  
function addWaitList(files){  
    for(var i=0;i<files.length;i++){  
        var sameName=-1;  
        for(var j=0;j<waitList.length;j++){  
            if(files.item(i).name==waitList[j].name){  
                sameName=j;  
                break;  
            }  
        }  
        if(sameName<0) {  
            waitList.push(files.item(i));  
            $("#waitingList").append('<li class="waitFileList">'+files.item(i).name+'</li>');  
        }else{  
            waitList[sameName]=files.item(i);  
        }  
    }  
}  
  
$(function(){  
    var obj = $("#DnDBox");  
    obj.on('dragenter', function (e) {  
        e.stopPropagation();  
        e.preventDefault();  
        $(this).css('border', '4px solid #000');  
    });  
    obj.on('dragover', function (e) {  
        e.stopPropagation();  
        e.preventDefault();  
        $(this).css('border', '4px solid #000');  
    });  
    obj.on('drop', function (e) {  
        $(this).css('border', '4px dashed #000');  
        e.preventDefault();  
        addWaitList(e.originalEvent.dataTransfer.files);  
    });  
    $(document).on('dragenter', function (e) {  
        e.stopPropagation();  
        e.preventDefault();  
    });  
    $(document).on('dragover', function (e) {  
        e.stopPropagation();  
        e.preventDefault();  
        obj.css('border', '4px dashed #000');  
    });  
    $(document).on('drop', function (e) {  
        e.stopPropagation();  
        e.preventDefault();  
    });  
  
    $('#clearWaitList').on('click',function(){  
        $('.waitFileList').remove();  
        waitList=[];  
    });  
      
    $('#upload').on('click',function(){  
        // ファイルを上げに行く  
        var fd= new FormData();  
        for(var i=0;i<waitList.length;i++) {  
            $("[id^='HiddenFile']").each(function(){  
                if($(this).val()==waitList[i].name){  
                    overwriteFiles.push($(this).val());  
                    return false;  
                }  
            });  
            fd.append('file['+i+']', waitList[i]);  
        }  
        $.ajax({  
            url: "upload.php",  
            type: "POST",  
            contentType: false,  
            processData: false,  
            cache: false,  
            data: fd,  
            success: function(data) {  
               alert('アップロードに成功しました');  
                $('.waitFileList').remove();  
                waitList=[];  
            },  
            error: function(data) {  
               alert('アップロードに失敗しました');  
            }  
        });  
  
    });  
  
});  
