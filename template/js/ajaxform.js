var form_name = null;

$(document).ready(function () {

    $('.formAjax').on('submit', function (e) {

        e.preventDefault();
        //$('button,submit,input[type=submit]').attr("disabled","disabled");
        var action = $(this).attr('action');
        form_name = $(this).attr('id');
        //$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd");
        invio_form(action, $(this));
        return false;
    });
});


function invio_form(action, form) {

    try {
        $('.formAjax #description').val(CKEDITOR.instances.description.getData());
    } catch (e) {

    }
    if (form.attr('enctype') == 'multipart/form-data') {
        //var contentType = 'multipart/form-data';
        var data = new FormData();
        $.each($('#userfile')[0].files, function (i, file) {
            data.append('userfile[]', file);
        });

        $.ajax({
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            url: action,
            data: data,
            dataType: "json",
            success: function (msg) {
                uploadComplete(msg.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //apprise(xhr.responseText);
            }
        });
    } else {
        var contentType = 'application/x-www-form-urlencoded';


        var data = form.serialize();
        $.ajax({
            type: "POST",
            contentType: contentType,
            url: action,
            data: data,
            dataType: "json",
            success: function (msg) {

                if (parseInt(msg.status) == 1) {
                    window.location = msg.txt;
                }
                else if (parseInt(msg.status) == 0) {
                    $.notify(msg.txt, 'error');
                }
                else if (parseInt(msg.status) == 2) {
                    $.notify(msg.txt);
                }
                else if (parseInt(msg.status) == 3) {
                    notify_ok(1, msg.txt);
                }
                else if (parseInt(msg.status) == 4) {
                    window.location.reload();
                }
                else if (parseInt(msg.status) == 5) {
                    alert(msg.txt);
                    window.location.reload();
                }


            },
            error: function() {
                alert("Ajax Error. See the console");
            }
    });
    }

}


function loading(status) {
    if (status != 0)
        $('#' + form_name + ' .loading_now').show();
    else
        $('#' + form_name + ' .loading_now').hide();
}


