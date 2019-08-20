$(document).ready(function() {
    encodeData = function(data) {
        return Object.keys(data).map(function(key) {
            return [key, data[key]].map(encodeURIComponent).join("=");
        }).join("&");
    } 

    // Raja Ongkir
    $('select[name=province]').on('change', function() {
        var element  = $(this),
            text     = element.find("option:selected").text(),
            province = element.val(),
            target   = element.attr('data-purplestore-target'),
            url      = element.attr('data-purplestore-url'),
            token    = $('#csrf-ajax-token').val(),
            data     = { province:province };

        $.ajax({
            type: "POST",
            url:  url,
            headers : {
                'X-CSRF-Token': token
            },
            data: data,
            cache: false,
            beforeSend: function() {
                $('button').prop("disabled", true);
                $(target).html('<option value="">Getting all cities in ' + text + '...</option>')
            },
            success: function(data) {
                $('button').prop("disabled", false);
                var json    = $.parseJSON(data),
                    status  = (json.status),
                    options = (json.options);

                if (status == 'ok') {
                    $(target).html(options);
                }
                else {
                    // swal("Error!", "Something error. Please try again.", "error");
                    alert("Something error. Please try again.");
                }
            }
        })
        return false;
    })
})