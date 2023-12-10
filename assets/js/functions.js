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

// $(document).ready(function() {
//   $.ajax({
//     type: "POST",
//     url: "http://www.programa.net.br/ajax",
//     data: {"method":"teste","parameters":["dado2"]},
//     success: function (response) {
//       if (response.sucesso) {
//           alert(response.retorno);
//       }else{
//           alert("erro");                    
//       }
//     },
//   });
// });



