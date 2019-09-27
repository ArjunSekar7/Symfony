$(document).ready(function(){ 

    $("#category_name").change(function() {
       ajaxCall($(this).find('option:selected').val(),'/getSubCategory','#sub_category_sub_category_name');
       });
    
    $("#sub_category_sub_category_name").change(function() {
       ajaxCall($(this).find('option:selected').val(),'/getproduct','#product_product_name');
       });

       $("#employee_name").change(function() {
          console.log($(this).find('option:selected').val());
         ajaxCall($(this).find('option:selected').val(),'/getProject','#project_name');
         });


    
    });