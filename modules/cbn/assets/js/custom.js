$(document).on('submit', '.form_submit', function (event) {
    event.preventDefault();
    formdata = new FormData($(this)[0]);
    $.ajax({
        url: $(this).attr('action'),
        data: formdata,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (response) {
            if (response.success == true) {
                window.location.href = "";
            } else if (response.success == "warning") {
                $('.err' + response.set_value).css('color', 'red').text(response.msg);
            }
            else {
                $.each(response.errors, function (key, value) {
                    console.log(value);
                    $('.err' + key).css('color', 'red').text(value);
                });
            }
        }
    });
});

$(document).on('submit', '.upload_file', function (evn) {
    evn.preventDefault();
    var confirm = $("#confirm_upload").val();
    formdata = new FormData($(this)[0]);
    if (confirm == 1) {
        confirm_upload_data(formdata);
    } else if (confirm == 2) {
        window.location.href = "";
    }
    else {
        $.ajax({
            url: $(this).attr('action'),
            data: formdata,
            contentType: false,
            processData: false,
            type: 'POST',
            dataType: "json",
            success: function (res) {
                if (res.status == "true") {
                    $("#table_payment").html(res.payment_table);
                    $("#payment_message").html(res.message);
                    $(".upload_btn").html(res.btn);
                    $("#confirm_upload").val(res.confirm_upload);
                    $("#no_of_account").val(res.total_rows);
                    $("#total_amount").val(res.total_amount);
                }
            }
        });
    }
});

function confirm_upload_data(formdata) {
    var data_url = $("#confirm_upload").data('url');
    $.ajax({
        url: data_url,
        data: formdata,
        contentType: false,
        processData: false,
        type: 'POST',
        dataType: "json",
        success: function (res) {
            if (res.status == "true") {
                $("#payment_message").html(res.message);
                $(".upload_btn").html(res.btn);
                $("#confirm_upload").val(res.confirm_upload);
            }
        }
    });
}