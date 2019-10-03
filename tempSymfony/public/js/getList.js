$(document).ready(function () {

   $("#category_name").change(function () {
      ajaxCall($(this).find('option:selected').val(), '/getSubCategory', '#sub_category_sub_category_name');
   });

   $("#sub_category_sub_category_name").change(function () {
      ajaxCall($(this).find('option:selected').val(), '/getproduct', '#product_product_name');
   });

});