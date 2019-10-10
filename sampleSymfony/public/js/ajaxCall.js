function ajaxCall(requestId, requestUrl, requestSelectBox) {
   var errorMessage = "Ajax request failed";
   $.ajax({
      url: requestUrl,
      type: 'POST',
      data: { id: requestId },
      dataType: 'json',
      async: true,
      success: function (data) {
         if ( data.error.errorCode == 201) {
               $(requestSelectBox).empty().append('<option value=' + 0 + '> Select </option>');
               $.each(data.data, function (key, value) {
                  $(requestSelectBox).append('<option value=' + value.id + '>' + value.name + '</option>');
               });   
         } else {
            alert(errorMessage);
         }
      },
      error: function (xhr, textStatus, errorThrown) {
         alert(errorMessage);
      }
   });
}

