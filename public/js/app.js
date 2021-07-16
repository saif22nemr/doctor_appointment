

$('.select2').select2();
function hasId(elementId , parent = null){
    var part = parent == null ? '#' : parent+' #';
    if($('#'+elementId).length > 0) return true;
    else{
        return false;
    }
}
// // commonjs
//   const flatpickr = require("flatpickr");
//   // es modules are recommended, if available, especially for typescript
// import flatpickr from "flatpickr";
$(function(){

    var allInput = $('.form-control');
    $.each(allInput , function(){
        var thisTag = $(this);
        if(thisTag.prop('required')){
            thisTag.parent().find('label').append(' <span class="strick"><span>*</span></span>');
        }
    });

    $('.auto-focus').focus();

    $('#updatePhones').on('click' , '.delete.delete-item' , function(){
        $(this).parent().remove();
    });
    $('.comments').on('click' , '.comment .delete-item' , function(){
        // $(this).parent().parent().remove();
    });
});

