/*** LANG ***/
$('.lang-select-langs a').on('click', function () {
    let langSelected = $(this).attr('data-lang');
    $.ajax({
        url: '/lang/'+langSelected,
        dataType: 'HTML',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            response = JSON.parse(response);
            if(response['state'] === "success") {
                location.reload();
            } else {
                console.log("Changing lang error: " + response['message']);
            }
        }
    })
});

/** 2FA **/
$('#enable-2fa').on('click', function () {
    let button = $(this);

    $.ajax({
        url: '/dashboard/get2fa',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            button.fadeOut(500);
            $('#zone-2fa img').attr('src', data.qrurl);
            $('#secret-code-2fa').text(data.secret);
            $('#zone-2fa').show(300);
        }
    });
});

$('#enable-check-2fa').on('click', function () {
    let button = $(this);
    $(this).prop('disabled');


    $.ajax({
        url: '/dashboard/enable2fa',
        type: 'POST',
        dataType: 'HTML',
        data: {
            'secret': $('#secret-code-2fa').text(),
            'token': $('#token-2fa').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            data = JSON.parse(data);
            if(data.state == "error") {
                $('#token-2fa').addClass('is-invalid');
                button.removeAttr('disabled');
            } else {
                $('#token-2fa').removeClass('is-invalid');

                let codes = '';

                let i = 0;
                while(i < data.recover_codes.length) {
                    codes += '<li>'+data.recover_codes[i]+'</li>\n';
                    i++;
                }

                $('#recover-codes-2fa .codes').html(codes);

                $('#zone-2fa').slideToggle();
                $('#recover-codes-2fa').slideDown();
            }
        }
    });
});

/** DELETE ACCOUNT **/
$("#delete-account").on('click', function () {
    $("#deleteModal").modal();
});

$("#confirm-account-delete").on("change", function () {
   if($(this).prop("checked")) {
       $("#oh-dear-we-are-in-trouble").removeAttr("disabled");
   } else {
       $("#oh-dear-we-are-in-trouble").prop("disabled", "disabled");
   }
});

$("#oh-dear-we-are-in-trouble").on('click', function () {
    $.ajax({
        url: '/dashboard/delete_account',
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
           if (data == "success") {
                window.location.replace("/")
           }
        }
    });
});


/** CONFIG **/
$('.settings-parent').on('change', '.settings-option', function () {

    $('#settings-saver').css('transform', 'translateY(0)');
});

$('.settings-parent').on('click', ' select.settings-option option', function () {
    if($(this).val()) {
        $(this).parent().find("option[value='']").prop("selected", false);
    } else {
        $(this).parent().find("option").not($(this)).prop('selected', false);
    }
});

$('#role_admin option').on('click', function () {
    if ($(this).val()) {
        $("#role_manager option[value='"+$(this).val()+"']").prop("selected", true);
    }
});

$("#save-settings").on('click', function () {
    let elements = {};
    let button = $(this);
    button.prop("disabled", true);

    $(".settings-option").each(function () {
        elements[$(this).attr('id')] = $(this).val();
    });

    $.ajax({
        url: "/dashboard/servers/"+$("#server-id").val()+"/update_conf",
        type: "POST",
        dataType: "JSON",
        data: {conf: JSON.stringify(elements)},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
            button.prop("disabled", false);

            console.log(data);
            $(".settings-parent .invalid-feedback").remove();
            $(".settings-parent .settings-option").removeClass("id-invalid");

            if (data.errors.length == 0) {
                $('#settings-saver').css('transform', 'translateY(100%)');
            } else {
                for (const el in data.errors) {
                    $("#" + el).addClass("is-invalid").after('<div class="invalid-feedback"></div>');
                    let errors = "";
                    for (const msg of data.errors[el]) {
                        errors += msg + "\n";
                    }
                    $("#" + el).parent().find(".invalid-feedback").html(errors);
                }
            }
        }
    });
});

