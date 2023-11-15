$(document).ready(function(){			
  setTimeout(function() {
$(".alert").fadeOut("fast", function(){
  $(this).alert('close');
});				
  }, 4000);			
});

$(document).ready(function(){
    $("#pesquisa").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

