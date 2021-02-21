/**
 * Created by   :  Muhammad Yasir
 * Project Name : yra
 * Product Name : PhpStorm
 * Date         : 29-Aug-19 2:43 PM
 * File Name    : custom.js
 */

$(document).ready(function () {
    $('.date_calender').datetimepicker(
        {
            viewMode: 'days',
            format: 'MM/DD/YYYY', /*Add this line to remove time format*/
            widgetPositioning: {horizontal: 'left', vertical: 'bottom'}
        }
    );

    $("select.select2").select2(
        {
            placeholder: "Select",
            allowClear: true,
            width: '100%',
            "useEmpty": true
        }
    );
    $('select.select2-ajax').each(function () {
        $(this).select2({
            width: '100%',
            placeholder: "Select",
            allowClear: true,
            ajax: {
                url: $(this).data('get-items-route'),
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: $(this).data('get-items-field'),
                        method: $(this).data('method'),
                        page: params.page || 1
                    }
                    return query;
                }
            }
        });

        $(this).on('select2:select', function (e) {
            var data = e.params.data;
            if (data.id == '') {
                // "None" was selected. Clear all selected options
                $(this).val([]).trigger('change');
            } else {
                $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', 'selected');
            }
        });

        $(this).on('select2:unselect', function (e) {
            var data = e.params.data;
            $(e.currentTarget).find("option[value='" + data.id + "']").attr('selected', false);
        });
    });
    $('#m_title').select2({
        tags: true
    });

    $('.addMore').select2({
        tags: true
    });

});


