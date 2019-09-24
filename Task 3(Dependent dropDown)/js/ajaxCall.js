 function ajaxCall(id,urlName,selectBox){ 
   $.ajax({ 
   url: urlName, 
   type:'POST',
   data: {id : id },
   dataType:'json', 
   async:true, 
   success: function(data, status) { 
   
   $(selectBox).empty();
   $.each(data,function(key, value) 
   {
      $(selectBox).append('<option value=' + value.id + '>' + value.name  + '</option>');
   });
   }, 
   error : function(xhr, textStatus, errorThrown) { 
      alert('Ajax request failed.'); 
   } 
   });
}


