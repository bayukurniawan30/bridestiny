$(document).ready(function() {
    $(".alert-confirm-vendor").on("click", function() {
        var btn       = $(this),
            name      = btn.data('purple-name'),
            id        = btn.data('purple-id'),
            modal     = btn.data('purple-modal'),
            showModal = $(modal),
            bindName  = showModal.find('.bind-title');

        showModal.find("input[name=id]").val(id);
        showModal.find("#button-decline-vendor").attr('data-purple-name', name);
        showModal.find("#button-decline-vendor").attr('data-purple-id', id);
        bindName.html(name);
        UIkit.modal(modal).show();
        return false;
    })

    $("#button-decline-vendor").click(function() {
        var btn       = $(this),
            name      = btn.data('purple-name'),
            id        = btn.data('purple-id'),
            modal     = btn.data('purple-modal'),
            showModal = $(modal),
            bindName  = showModal.find('.bind-title');
        
        $("#modal-confirm-vendor").find("#button-decline-vendor").attr('data-purple-name', name);
        showModal.find("input[name=id]").val(id);
        bindName.html(name);

        UIkit.modal("#modal-confirm-vendor").hide();

        setTimeout(function() {
            UIkit.modal(modal).show();
        }, 1000)

        return false;
    })
})