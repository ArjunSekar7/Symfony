$(document).ready(function(){   
      $.ajax({  
         url:        '/getMainCategory',  
         type:       'POST',   
         dataType:   'json',  
         async:      true, 
         success: function(data, status) {  
         var len = data.length;
          $("#sel_user").empty();
          for( var i = 0; i<len; i++){
              var id = data[i]['id'];
              var name = data[i]['name'];
              
              $("#sel_user").append("<option value='"+id+"'>"+name+"</option>");

          }
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert('Ajax request failed.');  
         }    
   });  
      $("#sel_user").click(function() {
         var $option = $(this).find('option:selected');
         var value = $option.val();
         console.log(value);
         $.ajax({ 
         url:'/getSubCategory',  
         type:'POST',   
         data: {data :  value },
         dataType:'json',  
         async:true,  
                     
         success: function(data, status) {  
            var len = data.length;

          $("#sel_user1").empty();
          for( var i = 0; i<len; i++){
              var id = data[i]['id'];
              var name = data[i]['name'];
              
              $("#sel_user1").append("<option value='"+id+"'>"+name+"</option>");

          }
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert('Ajax request failed.');  
         }    
});
});
         $("#sel_user1").click(function() {
         var $option = $(this).find('option:selected');
         var value = $option.val();
         console.log(value);
         $.ajax({ 
         url:'/getproduct',  
         type:'POST',   
         data: {data :  value },
         dataType:'json',  
         async:true,  
                     
         success: function(data, status) {  
            var len = data.length;

          $("#sel_user2").empty();
          for( var i = 0; i<len; i++){
              var id = data[i]['id'];
              var name = data[i]['name'];
              
              $("#sel_user2").append("<option value='"+id+"'>"+name+"</option>");

          }
         },  
         error : function(xhr, textStatus, errorThrown) {  
            alert('Ajax request failed.');  
         }    
});
});
});  