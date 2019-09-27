function ajaxCall(id, urlName, selectBox) {
   $.ajax({
      url: urlName,
      type: 'POST',
      data: { id: id },
      dataType: 'json',
      async: true,
      success: function (data) {
         if (typeof data.status != "undefined" && data.status != "undefined" && data.status == "OK") {
            if (typeof data.message != "undefined" && data.message != "undefined") {
               $(selectBox).empty();
               $.each(data.message, function (key, value) {
                  $(selectBox).append('<option value=' + value.id + '>' + value.name + '</option>');
               });
            } else {
               alert("Error: Problem in fetching the details");
            }
         } else {
            alert("Ajax request failed");
         }
      },
      error: function (xhr, textStatus, errorThrown) {
         alert('Alax request failed');
      }
   });
}

