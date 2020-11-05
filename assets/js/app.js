$(document).ready(function () {
    
    $('.showHide').on('click',function(){
        var main = $('#mainSectionContainer');
        var nav = $('#sideNavContainer');
        if(main.hasClass('leftpadding')){
            nav.hide();
        }else{
            nav.show();
        }
        main.toggleClass("leftpadding");
    })
});