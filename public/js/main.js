/*** GENERAL ***/
$('#mobile-menu-toggler').on('click', function () {
    $('header .navbar').slideToggle(function () {
        $(this).toggleClass('active');
        $(this).removeAttr('style')
    });
});

$("#accept-cookies").on('click', function () {
    $.ajax({
        url: '/accept_cookies',
        dataType: 'HTML',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if(response == 0) {
                $("#cookies-banner").slideToggle();
            }
        }
    })
});

$('.command').on('click', '.command-head', function(){
    $(this).parent().toggleClass('open');
});


/*** LANG ***/
$('.lang-select').on('click', function (e) {
    e.stopPropagation();
    $('.lang-select-langs').fadeToggle(300);
});
$('.lang-select-langs a').on('click', function (e) {
    e.stopPropagation();
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
    });
});

$(document).on('click', function () {
    $('.lang-select-langs').fadeOut(300);
});


/*** FAQ ***/
$('.faq-question').on('click', function () {
    let answer = $(this).parent().find('.faq-answer');
    if($(answer).is(':visible')) {
        answer.slideUp();
        $(this).closest('.faq-container').removeClass("open");
    } else {
        $(this).closest('.faq-box').find('.faq-container').removeClass("open");
        $(this).closest('.faq-container').addClass("open");
        $('.faq-question').closest('.faq-box').find('.faq-answer').slideUp();
        answer.slideDown();
    }
});


/*** DOC ***/
$('.doc-nav i.drop').on('click', function (e) {
   e.preventDefault();
   let parent = $(this).closest('li');
   if(parent.hasClass('open')) {
       parent.children('ul').css('display', 'block');
        parent.children('ul').slideUp(300);
        parent.removeClass('open');
   } else {
        parent.children('ul').slideDown(300);
        parent.addClass('open');
   }
});


