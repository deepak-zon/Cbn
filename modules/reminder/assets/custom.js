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
                $('.err' + 'franchise_number').css('color', 'red').text(response.msg);
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

