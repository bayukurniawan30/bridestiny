$(document).ready(function(){
    $('.link-to-modal-brideme-couples-login').on('click', function() {
        var element  = $(this),
            modal    = '#modal-brideme-couples-login';
        
        UIkit.modal(modal).show();
        return false;
    })

    $('.link-to-modal-brideme-vendor-login').on('click', function() {
        var element  = $(this),
            modal    = '#modal-brideme-vendor-login';
        
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