var App = {
    initNotifyBox: function () {
        $("#notiBox").BreakingNews({
            effect: "slide",
            border: "solid 1px #099",
            titlebgcolor: '#104F82',
            title: '<span class="glyphicon glyphicon-bullhorn"></span> Thông báo',
            timer: 5000
        });
    }
};
$(document).ready(function () {
    App.initNotifyBox();
    $('#right_menu').metisMenu({ toggle: false});
    $('#left_menu').metisMenu({ toggle: false});
});