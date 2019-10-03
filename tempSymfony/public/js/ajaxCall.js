function ajaxCall(id, urlName, selectBox) {
   if(id != 0){
   $.ajax({
      url: urlName,
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      async: true,
      success: function (data) {
         if ( data.error.errorCode == 201) {
               $(selectBox).empty();
               $(selectBox).append('<option value=' + 0 + '> Select </option>');
               $.each(data.data, function (key, value) {
                  $(selectBox).append('<option value=' + value.id + '>' + value.name + '</option>');
               });   
         } else {
            alert("Ajax request failed");
         }
      },
      error: function (xhr, textStatus, errorThrown) {
         alert('Alax request failed');
      }
   });
}
}
