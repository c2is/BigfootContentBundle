$(function() {
    $('body').on('click', '.template-row input[type=radio]', function() {
        $(this).closest('.templates-container').find('i.icon-ok').hide();
        $(this).closest('.template-row').find('i.icon-ok').show();
    });

    /**
     * Handle modal response
     */
    var
        modal   = $('#ajax-modal'),
        options = {
            success: successResponse,
        };

    $('.modal-save')
        .unbind('click')
        .on('click', function (event) {
            var
                pathname    = window.location.pathname.split('/'),
                contentType = null;
                template    = pathname[pathname.length-1].trim(),
                form        = $(this)
                    .closest('.modal')
                        .find('form');

            var action = form.attr('action');

            if ($.inArray('page', pathname) != -1) {
                contentType = 'page';
            } else {
                contentType = 'sidebar';
            }

            form
                .attr('action', action + '?layout=_blank&contentType=' + contentType + '&template=' + template)
                .ajaxSubmit(options);
        });

    function successResponse(responseText, statusText, xhr) {
        if (responseText.status === true) {
            modal
                .find('.modal-body')
                .empty()
                .prepend(responseText.content);
        } else if (responseText.status === 'new_block') {
            modal.modal('hide');

            var newBlockOpt = '<option value="' + responseText.content.option.value + '">' + responseText.content.option.label + '</option>';
            var $blocksPrototype = $(decodeEntities($('.widget-blocks').data('prototype')));

            $('.admin_block_select').append(newBlockOpt).trigger('chosen:updated');
            $('.admin_block_select', $blocksPrototype).append(newBlockOpt);
            $('.widget-blocks').attr('data-prototype', $blocksPrototype.html());
        } else if (responseText.status === 'edit_block') {
            modal.modal('hide');

            var $blocksPrototype = $(decodeEntities($('.widget-blocks').data('prototype')));

            $('.admin_block_select > option[value="' + responseText.content.option.id + '"]').html(responseText.content.option.label);
            $('.admin_block_select > option[value="' + responseText.content.option.id + '"]', $blocksPrototype).html(responseText.content.option.label);

            $('.widget-blocks').attr('data-prototype', $blocksPrototype.html());
            $('.admin_block_select').trigger("chosen:updated");
        } else {
            modal
                .find('.modal-body')
                .empty()
                .prepend("<div class='alert alert-block alert-danger'>" + responseText.message + '</div>')
                .append(responseText.content);
        }
    }
});

function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}
