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
    let desc = $(this).parent().find('.command-desc');
    console.log($(this).parent().find('.command-desc'));
    if($(this).parent().hasClass('open')) {
        desc.css("max-height", desc[0].scrollHeight+"px");
    } else {
        desc.css("max-height", 0);
    }
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
$.fn.slideShow = function(time,easing) { return $(this).animate({height:'show','margin-top':'show','margin-bottom':'show','padding-top':'show','padding-bottom':'show',opacity:1},time,easing); }
$.fn.slideHide = function(time,easing) {return $(this).animate({height:'hide','margin-top':'hide','margin-bottom':'hide','padding-top':'hide','padding-bottom':'hide',opacity:0},time,easing);  }

$('.faq-question').on('click', function () {
    let answer = $(this).parent().find('.faq-answer');
    if($(answer).parent().hasClass('open')) {
        $(this).closest('.faq-container').removeClass("open");
        answer.css('max-height', "0px");
    } else {
        $(this).closest('.faq-box').find('.faq-container').removeClass("open");
        $(this).closest('.faq-container').addClass("open");
        $(this).closest('.faq-box').find('.faq-answer').css('max-height', "0px");
        answer.css('max-height', answer[0].scrollHeight+"px");
    }
});


/*** DOC ***/
$('.doc-nav i.drop').on('click', function (e) {
   e.preventDefault();
   let parent = $(this).closest('li');
   if(parent.hasClass('open')) {
        let child = parent.children('ul')[0];
        $(child).css('max-height', child.scrollHeight + 'px');
        setTimeout(() => {$(child).css('max-height', 0);}, 0);
        parent.removeClass('open');
   } else {
        let child = parent.children('ul')[0];
        $(child).css('max-height', child.scrollHeight + 'px');
        if(parent.closest('ul').length) {
            let parentContainer = parent.closest('ul')[0];
            console.log(parentContainer);
            $(parentContainer).css('max-height', parentContainer.scrollHeight+child.scrollHeight + 'px');
        }
        parent.addClass('open');
   }
});

/*** CHANGELOGS ***/
$.fn.slideShow = function(time,easing) { return $(this).animate({height:'show','margin-top':'show','margin-bottom':'show','padding-top':'show','padding-bottom':'show',opacity:1},time,easing); }
$.fn.slideHide = function(time,easing) {return $(this).animate({height:'hide','margin-top':'hide','margin-bottom':'hide','padding-top':'hide','padding-bottom':'hide',opacity:0},time,easing);  }

$('.version-question').on('click', function () {
    let answer = $(this).parent().find('.version-answer');
    if($(answer).parent().hasClass('open')) {
        $(this).closest('.version-container').removeClass("open");
        $(this).find('i').removeClass('fa-minus').addClass('fa-plus');
        answer.css('max-height', "0px");
    } else {
        $(this).closest('.version-container').addClass("open");
        $(this).find('i').removeClass('fa-plus').addClass('fa-minus');
        answer.css('max-height', answer[0].scrollHeight+"px");
    }
});

$('#changelogs-application-switch div').on('mouseover', function () {
   $('#changelogs-application-position').css('left', $(this).position().left);
}).on('mouseleave', function () {
    $('#changelogs-application-position').css('left', $("#changelogs-application-switch div.active").position().left);
}).on('click', function () {
    $('#changelogs-application-switch div').removeClass('active');
    $(this).addClass('active');
    $('#changelogs-application-position').css('left', $(this).position().left);
    $('.changelogs-main .versions.active').removeClass('active');
    $('#' + $(this).attr('id').split('-')[1] + "-container").addClass('active');
});



