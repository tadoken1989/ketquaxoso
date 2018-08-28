disabled_days = {
    'mb': [],
    '123': [],
    'tt4': [],
    '636': [],
};
disabled_day_of_week = {
    'tp-hcm' : [0, 2, 3, 4, 5],
    'dong-thap' : [0, 2, 3, 4, 5, 6],
    'ca-mau' : [0, 2, 3, 4, 5, 6],
    'ben-tre' : [0, 1, 3, 4, 5, 6],
    'vung-tau' : [0, 1, 3, 4, 5, 6],
    'bac-lieu' : [0, 1, 3, 4, 5, 6],
    'dong-nai' : [0, 1, 2, 4, 5, 6],
    'can-tho' : [0, 1, 2, 4, 5, 6],
    'soc-trang' : [0, 1, 2, 4, 5, 6],
    'tay-ninh' : [0, 1, 2, 3, 5, 6],
    'an-giang' : [0, 1, 2, 3, 5, 6],
    'binh-thuan' : [0, 1, 2, 3, 5, 6],
    'vinh-long' : [0, 1, 2, 3, 4, 6],
    'binh-duong' : [0, 1, 2, 3, 4, 6],
    'tra-vinh' : [0, 1, 2, 3, 4, 6],
    'long-an' : [0, 1, 2, 3, 4, 5],
    'hau-giang' : [0, 1, 2, 3, 4, 5],
    'binh-phuoc' : [0, 1, 2, 3, 4, 5],
    'tien-giang' : [1, 2, 3, 4, 5, 6],
    'kien-giang' : [1, 2, 3, 4, 5, 6],
    'da-lat' : [1, 2, 3, 4, 5, 6],
    'thua-t-hue' : [0, 2, 3, 4, 5, 6],
    'phu-yen' : [0, 2, 3, 4, 5, 6],
    'quang-nam' : [0, 1, 3, 4, 5, 6],
    'dak-lak' : [0, 1, 3, 4, 5, 6],
    'da-nang' : [0, 1, 2, 4, 5],
    'khanh-hoa' : [1, 2, 4, 5, 6],
    'binh-dinh' : [0, 1, 2, 3, 5, 6],
    'quang-tri' : [0, 1, 2, 3, 5, 6],
    'quang-binh' : [0, 1, 2, 3, 5, 6],
    'kon-tum' : [1, 2, 3, 4, 5, 6],
    'gia-lai' : [0, 1, 2, 3, 4, 6],
    'ninh-thuan' : [0, 1, 2, 3, 4, 6],
    'quang-ngai' : [0, 1, 2, 3, 4, 5],
    'dak-nong' : [0, 1, 2, 3, 4, 5],
    'ha-noi' : [0,2,3,5,6],
    'quang-ninh' : [0,1,3,4,5,6],
    'bac-ninh' : [0,1,2,4,5,6],
    'hai-phong' : [0,1,2,3,4,6],
    'nam-dinh' : [0,1,2,3,4,5],
    'thai-binh' : [1,2,3,4,5,6],
    'dien-toan-123' : [],
    'dien-toan-6-36' : [0, 1, 2, 4, 5],
    'than-tai' : [],
    'mega-6-45': [1,2,4,6],
    'power-6-55': [0,1,3,5],
    'max-4d': [0,1,3,5],
};

function set_disabled_days(p_code, obj) {
    if (p_code in disabled_days)
        day_list = disabled_days[p_code]; else
        day_list = [];
    obj.datepicker('setDatesDisabled', day_list);
    return true;
}

function set_disabled_day_of_week(p_code, obj) {
    if (p_code in disabled_day_of_week)
        day_list = disabled_day_of_week[p_code]; else
        day_list = [];
        console.log(day_list);
    obj.datepicker('setDaysOfWeekDisabled', day_list);
    return true;
}

function disable_combine(p_code, obj) {
    set_disabled_days(p_code, obj);
    set_disabled_day_of_week(p_code, obj);
    return true;
}

function link_selector_dpicker(obj1, obj2) {
    obj1.change(function () {
        p_code = obj1.val();
        disable_combine(p_code, obj2);
        return true;
    });
}