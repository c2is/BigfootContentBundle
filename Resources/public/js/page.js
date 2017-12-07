$(function() {

    /**
     * Handle sidebars
     */
    $('.sidebar-accordion')
        .accordion({
            collapsible: true,
            header:      '> .sidebar-form-widget > h3'
        })
        .sortable({
            handle: 'h3',
            stop: function( event, ui ) {
                ui.item.children('.sidebar-form-widget').triggerHandler('focusout');

                orderSidebars();
            }
        })
        .accordion('refresh');

    var
        containerSidebar = $('.widget-sidebars');
        prototypeSidebar = containerSidebar.attr('data-prototype'),
        sidebars         = containerSidebar.find('.admin_sidebar_select');

    handleSidebarTemplates(sidebars);

    handleSidebarAccordion(sidebars);

    orderSidebars();

    $('.admin-add-sidebar').on('click', function (event) {
        event.preventDefault();

        var sidebarCount = containerSidebar
            .find('.sidebar-form-widget')
            .length;

        prototypeSidebar = $(this).closest('.panel').find('.widget-sidebars').attr('data-prototype');
        var newSidebar = prototypeSidebar.replace(/__name__/g, sidebarCount);

        $(this).closest('.panel').find('.sidebar-accordion').append(newSidebar);

        $(".chosen-select").chosen();

        var
            lastSidebar = containerSidebar.find('.sidebar-form-widget:last'),
            sidebars    = containerSidebar.find('.admin_sidebar_select');

        handleSidebarTemplates(sidebars);

        $(this)
            .closest('.collection-container')
                .find('.templates-container:last')
                    .find('label.is-shown:first > input')
                        .attr('checked', true);

        $('.sidebar-accordion')
            .accordion({
                collapsible: true,
                header:      '> .sidebar-form-widget > h3'
            })
            .sortable({
                handle: 'h3',
                stop: function( event, ui ) {
                    ui.item.children('.sidebar-form-widget').triggerHandler('focusout');

                    orderSidebars();
                }
            })
            .accordion('refresh');

        handleSidebarAccordion(sidebars);

        orderSidebars();
    });

    $('body').on('click', '.admin-delete-sidebar', function (event) {
        event.preventDefault();

        var currentSidebar = $(this)
            .closest('.sidebar-form-widget')
            .parent('.form-group')
            .remove();
    });

    $('body').on('change', '.admin_sidebar_select', function (event) {
        handleSidebarTemplate($(this));

        replaceSidebarAccordionName($(this));
    });

    function handleSidebarTemplates(sidebars)
    {
        sidebars.each(function (index) {
            handleSidebarTemplate($(this));
        });
    }

    function handleSidebarTemplate(sidebar)
    {
        var val = sidebar
            .find('option:selected')
                .html()
                .split('-');

        var
            template = val[1].trim(),
            radios   = sidebar
                .closest('.sidebar-row')
                    .find('input[type=radio]');

        radios.each(function (index) {
            var values = $(this)
                .val()
                .split('/');

            if (values[0] !== template) {
                $(this)
                    .parent()
                    .addClass('is-hidden')
                    .hide();
            } else {
                $(this)
                    .parent()
                    .addClass('is-shown')
                    .show();
            }
        });
    }

    function handleSidebarAccordion(sidebars)
    {
        sidebars.each(function (index) {
            replaceSidebarAccordionName($(this));
        });
    }

    function replaceSidebarAccordionName(sidebar)
    {
        var currentSidebarName = sidebar
            .find('option:selected')
                .html();

        sidebar
            .closest('.sidebar-row')
                .find('.content-sidebar-name')
                    .text(currentSidebarName);
    }

    function orderSidebars()
    {
        var containers = $('.widget-sidebars');

        containers.each(function (index) {
            var sidebars  = $(this).find('.admin_sidebar_select');

            sidebars.each(function (index2) {
                $(this)
                    .closest('.s-accordion')
                        .find('.sidebar-position')
                            .val(index2 + 1);
            });
        });
    }

});
