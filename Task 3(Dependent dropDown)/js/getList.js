$(document).ready(function(){ 

    $("#category_name").change(function() {
       ajaxCall($(this).find('option:selected').val(),'/getSubCategory','#subCategory');
       });
    
    $("#subCategory").change(function() {
       ajaxCall($(this).find('option:selected').val(),'/getproduct','#product');
       });
    
    });
