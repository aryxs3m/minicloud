var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

var selectedFile;

$(document).ready(function(){

    // file context menu
    $('.list-group-file').on('contextmenu', function(e) {
        var top = e.pageY - 10;
        var left = e.pageX - 90;
        $("#context-menu").css({
            display: "block",
            top: top,
            left: left
        }).addClass("show");

        selectedFile = $(this).find(".filename").html();

        return false; //blocks default Webbrowser right click menu
    }).on("click", function() {
        $("#context-menu").removeClass("show").hide();
    });

    $("#context-menu a").on("click", function() {
        $(this).parent().removeClass("show").hide();
    });

    $("body").click(function(){
        $("#context-menu").removeClass("show").hide();
    });


    $("a#contextMenuDeleteFile").click(function(event){

        event.preventDefault();

        var path = getUrlParameter("sub");
        if (path == undefined) {
            path = "";
        }

        $.ajax({
            url: 'api.php', // point to server-side controller method
            data: {
                request : "deleteFile",
                path : path,
                file : selectedFile
            },
            type: 'post',

            success: function(response) {
                window.location = window.location;
            },
            error: function (response) {
                alert("Error while trying to delete!");
            }
        });

    });

    $("a#contextMenuShareFile").click(function(event){

        event.preventDefault();

        var path = getUrlParameter("sub");
        if (path == undefined) {
            path = "";
        }

        $.ajax({
            url: 'api.php', // point to server-side controller method
            data: {
                request : "shareFile",
                path : path,
                file : selectedFile
            },
            type: 'post',

            success: function(response) {

                const el = document.createElement('textarea');
                el.value = response;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);

                alert("Link copied to your clipboard! ");
            },
            error: function (response) {
                alert("Error while trying to share file!");
            }
        });

    });


    $("#menu-logout").click(function(event){
        event.preventDefault();

        $.ajax({
            url: 'api.php', // point to server-side controller method
            data: {
                request : "logoutNow"
            },
            type: 'post',

            success: function(response) {
                window.location = "index.php";
            },
            error: function (response) {
                alert("Error while trying to log out!");
            }
        });
    });


    $("#btn-upload-file").click(function(){

        var thisButton = $(this);

        thisButton.prop('disabled', true);

        $(this).html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n<span class=\"sr-only\">Uploading...</span> Uploading...");


        var form_data = new FormData();

        var path = getUrlParameter("sub");
        if (path == undefined) {
            form_data.append("path", "");
        } else {
            form_data.append("path", path);
        }


        var ins = document.getElementById('file').files.length;
        for (var x = 0; x < ins; x++) {
            form_data.append("file[]", document.getElementById('file').files[x]);
        }

        form_data.append('request', 'uploadFile');
        $.ajax({
            url: 'api.php', // point to server-side controller method
            dataType: 'text', // what to expect back from the server
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',

            xhr: function () {
                var xhr = $.ajaxSettings.xhr();
                xhr.upload.onprogress = function (e) {
                    if (e.lengthComputable) {
                        var progress = (e.loaded / e.total) * 100;
                        $("#progress-bar-upload").css("width", progress + "%");
                    }
                };
                return xhr;
            },
            success: function(response) {
                thisButton.prop('disabled', false);
                thisButton.html("<i class=\"fa fa-upload\"></i> Upload");

                window.location = window.location;

            },
            error: function (response) {
                thisButton.prop('disabled', false);
                thisButton.html("<i class=\"fa fa-upload\"></i> Upload");
                thisButton.removeClass("btn-primary");
                thisButton.addClass("btn-danger");
            }
        });

    });


    $("#btn-new-folder-modal-open").click(function(){
        $("#newFolderInput").css("border", "1px solid #ced4da"); // reset "error border"
    });


    $("#btn-new-folder").click(function(){

        var folderName = $("#newFolderInput").val();

        var path = getUrlParameter("sub");
        if (path == undefined) {
            path = "";
        }

        if (folderName.includes(".") || folderName.trim().length == 0) {
            $("#newFolderInput").css("border", "1px solid red");
        } else {
            $("#btn-new-folder").prop("disabled", true);

            $("#btn-new-folder").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n<span class=\"sr-only\">Loading...</span> Loading...");

            $.ajax({
                url: 'api.php', // point to server-side controller method
                data: {
                    request : "newFolder",
                    path : path,
                    folderName : folderName
                },
                type: 'post',

                success: function(response) {
                    $("#btn-new-folder").html("Create");
                    window.location = window.location;
                },
                error: function (response) {
                    $("#btn-new-folder").html("Error!");
                }
            });


            $("#btn-new-folder").prop("disabled", false);
        }

    })


})