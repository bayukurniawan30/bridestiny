$(document).ready(function(){
	
	
	
	
    $('.link-to-modal-brideme-login').on('click', function() {
        var element  = $(this),
            type     = element.attr('data-brideme-type'),
            modal    = '#modal-brideme-login',
            switcher = '#switcher-brideme-login';

        if (type == 'vendor') {
            var index = 1;
            $('.brideme-login-tab').find('.brideme-login-tab-vendors').addClass('uk-active');
        }
        else if (type == 'couple') {
            index = 0;
            $('.brideme-login-tab').find('.brideme-login-tab-couples').addClass('uk-active');
        }
        else {
            index = 0;
            $('.brideme-login-tab').find('.brideme-login-tab-couples').addClass('uk-active');
        }

        UIkit.switcher(switcher).show(index);

        $('.brideme-login-tab').find('li').removeClass('uk-active');
        if (type == 'vendor') {
            $('.brideme-login-tab').find('.brideme-login-tab-vendors').addClass('uk-active');
            $('.brideme-login-tab').find('.brideme-login-tab-vendors').attr('aria-expanded', 'true');
            $('.brideme-login-tab').find('.brideme-login-tab-couples').attr('aria-expanded', 'false');
        }
        else if (type == 'couple') {
            $('.brideme-login-tab').find('.brideme-login-tab-couples').addClass('uk-active');
            $('.brideme-login-tab').find('.brideme-login-tab-couples').attr('aria-expanded', 'true');
            $('.brideme-login-tab').find('.brideme-login-tab-vendors').attr('aria-expanded', 'false');
        }

        UIkit.modal(modal).show();
        return false;
    })

    $('.brideme-currency-session').on('click', function() {
        var element  = $(this),
            currency = element.attr('data-brideme-currency'),
            url      = $('.brideme-currency').attr('data-brideme-url'),
            token    = $('#csrf-ajax-token').val(),
            data     = { currency:currency };

        $.ajax({
            type: "POST",
            url:  url,
            headers : {
                'X-CSRF-Token': token
            },
            data: data,
            cache: false,
            beforeSend: function() {
            },
            success: function(data) {
                console.log(data);
                var json    = $.parseJSON(data),
                    status  = (json.status);

                if (status == 'ok') {
                    location.reload();
                }
                else {
                   alert('Something error. Please try again.');
                }
            }
        })
        return false;
    })

    $('.brideme-language-session').on('click', function() {
        var element  = $(this),
            language = element.attr('data-brideme-language'),
            url      = $('.brideme-language').attr('data-brideme-url'),
            webroot  = $('.brideme-language').attr('data-brideme-webroot'),
            token    = $('#csrf-ajax-token').val(),
            data     = { language:language };
            console.log(data);

        $.ajax({
            type: "POST",
            url:  url,
            headers : {
                'X-CSRF-Token': token
            },
            data: data,
            cache: false,
            beforeSend: function() {
            },
            success: function(data) {
                console.log(data);
                var json    = $.parseJSON(data),
                    status  = (json.status);

                if (status == 'ok') {
                    // location.reload();
                    window.location.href = webroot + language.toLowerCase();
                }
                else {
                   alert('Something error. Please try again.');
                }
            }
        })
        return false;
    })
	
	$('.brideme-tooltip').tooltip();
	

	// $('.paroller').paroller();
})