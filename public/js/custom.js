import {districts,provinces,municipalities} from './resources.js';

provinces.forEach((item) => {
    $("#provinces").append(`<option value="${item.id}">${item.title}</option>`)
});

$('#provinces').on('change',function(){
    let provinceID = $(this).val();
    $('#districts').html("");
    $('#districts').siblings('.nice-select').remove()
    let items = districts.filter((item)=>{
        return item.province==provinceID;
    });
    $("#districts").append(`<option value="-1" selected>All</option>`)
    items.forEach((item) => {
        $("#districts").append(`<option value="${item.id}">${item.title}</option>`)
    });
    $('select').niceSelect();
    app.getProvince()
});


$('#districts').on('change',function(){
    let districtID = $(this).val();
    $('#municipalities').html("");
    $('#municipalities').siblings('.nice-select').remove()
    let items = municipalities.filter((item)=>{
        return item.district==districtID;
    });
    $("#municipalities").append(`<option value="-1" selected>All</option>`)
    items.forEach((item) => {
        $("#municipalities").append(`<option value="${item.id}">${item.title}</option>`)
    });
    $('select').niceSelect();
    app.getDistrict()
});
