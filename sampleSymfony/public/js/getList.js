$(document).ready(function () {

   $("#category_name").change(function () {
      if($(this).find('option:selected').val()>0){
         ajaxCall($(this).find('option:selected').val(), '/getSubCategory', '#category_sub_category_name_0_sub_category_name');
      }
   });

   $("#category_sub_category_name_0_sub_category_name").change(function () {
      if($(this).find('option:selected').val()>0){
         ajaxCall($(this).find('option:selected').val(), '/getproduct', '#category_Product_0_product_name');
      }
   });

});