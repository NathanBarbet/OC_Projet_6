$( "#btnViewMedias" ).click(function() {
  if($("#MediasResult").hasClass("d-none")) {
    $( "#MediasResult" ).removeClass("d-none", "d-sm-block");
  } else {
    $( "#MediasResult" ).addClass("d-none", "d-sm-block");
  }
});
