$(document).ready(function()
{
    clickableHeaderWidget();
    deletableWidget();

    $( ".body_sidebar_elt" ).each(function()
    {
       $(this).sortable({
           update: function ()
           {
               var inputs = new Array();
               idWrapper = $(this).attr('id');
               inputs = $('#' + idWrapper + ' input.sortable-field');
               var nbElems = inputs.length;
               inputs.each(function(idx)
               {
                   $(this).val(idx);
               });
           }
       });
    });

    $('.widget_elt').sortable({
        connectWith: ".body_sidebar_elt",
        helper: "clone",
        update: function(event, ui)
        {
            idParent = ui.item.parent().attr('id');

            tabTemp = idParent.split('_');

            widgetName  = $(this).attr('data-name');
            typeBlock   = $(this).attr('data-type');
            idBlock     = $(this).attr('data-id');
            id_sidebar = tabTemp[2];

            positionToDrag = ui.item.prev('div.form_widget_element').index();

            CreateDynamicForm(widgetName,typeBlock,idBlock,id_sidebar,positionToDrag);

            $(this).html(ui.item);

        }
    });

});


function clickableHeaderWidget()
{
    $('.header_form_widget_element').unbind('click');

    $('.header_form_widget_element').click(function() {
        $('.body_form_widget_element:visible').slideToggle();
        $(this).parent('div.form_widget_element').children('.body_form_widget_element:hidden').slideToggle();
    });
}

function deletableWidget()
{
    $('.delete_widget_container').click(function()
    {
        $(this).parent().parent().parent().parent().remove();
    });
}

function CreateDynamicForm(widgetName,typeBlock,idBlock,id_sidebar,positionToDrag)
{

    if(typeof(idBlock)==='undefined') {
        idBlock = '';
    }

    path_url = $('#sidebar_container').attr('data-create-block');

    $.ajax({
        url: path_url,
        type: 'GET',
        data: { widget_name : widgetName, id_sidebar : id_sidebar, type_block : typeBlock, id_block : idBlock},
        cache: false,
        success: function(data) {

            $('.body_form_widget_element:visible').slideToggle();

            if (positionToDrag == -1) {
                $('#body_sidebar_' + id_sidebar).prepend(data);
                $('#body_sidebar_' + id_sidebar +' .body_form_widget_element:first:hidden').slideToggle();

            }
            else {
                $('#body_sidebar_' + id_sidebar +' div.form_widget_element:eq('+ positionToDrag +')').after(data);
                var newPosition = positionToDrag + 1;
                $('#body_sidebar_' + id_sidebar +' div.form_widget_element:eq('+ newPosition +') .body_form_widget_element').slideToggle();
            }

            updateAllPosition(id_sidebar);
            deletableWidget();
            clickableHeaderWidget();

            saveOrderBlock(id_sidebar);
        }
    });
}

function updateAllPosition(id_sidebar)
{
    var i = 0;
    $('#body_sidebar_' + id_sidebar + ' input.sortable-field').each(function()
    {
        $(this).val(i);

        i++;
    });

}

function saveOrderBlock(id_sidebar)
{
    var tabIdBlock  = new Array();
    var tabPosition = new Array();
    var typeBlock   = new Array();

    path_url = $('#sidebar_container').attr('data-save-order');

    $('#body_sidebar_' + id_sidebar + ' input.sortable-field').each(function()
    {
        idWrapper = $(this).parent().parent().attr('id');

        if (idWrapper) {
            var tabTemp = idWrapper.split('-');

            idBlockWrapper = tabTemp[1];

            tabIdBlock.push(idBlockWrapper);
            tabPosition.push($(this).val());
            typeBlock.push(tabTemp[0]);
        }
    });

    $.ajax({
        url: path_url,
        type: 'GET',
        data: { tabIdBlock : tabIdBlock,  tabPosition : tabPosition, id_sidebar : id_sidebar, typeBlock : typeBlock},
        cache: false,
        success: function(data) {}
    });
}