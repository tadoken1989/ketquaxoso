function wgetne() {
    code = $('#widget_code').val();
    width = $('#widget_width').val();
    width_text = $('#widget_width option:selected').text();
    output_code = '<script type="text/javascript" src="http://kqxs.vdev.vn/ws.mi.js"></script>\n<div id="widgetkq" code="' + code + '"' + (0 != width ? ' style="max-width:' + width_text + ';"' : '') + '>Widget kqxs</div>';
    $('#widgetsource_pre').text(output_code);
    return true;
}

function load_put() {
    wrapper_div_id = '#widgetkq';
    dalink_pref = 'http://widget.ketqua.net/pre_loads/kq-';
    code = $('#widget_code').val();
    dalink = dalink_pref + code + '.html';
    $.ajax({
        url: dalink, success: function (rda) {
            $(wrapper_div_id).html(rda);
            $('.kqbackground #widgetkq p.text-center').remove();
            return true;
        }
    });
    return true;
}

$(document).ready(function () {
    wgetne();
    $('#widget_code').change(function () {
        wgetne();
        load_put();
    });
    $('#widget_width').change(function () {
        wgetne();
    });
});