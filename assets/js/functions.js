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

function mensagem(mensagem,type="alert-danger"){
  $('body').prepend('<div class="alert '+type+' mt-1 d-flex justify-content-between align-items-center" role="alert">'+mensagem+'</div>');  
}

function validaVazio(seletor){
  var valor = $(seletor).val();

  if(valor == '') { 
    $(seletor).removeClass('is-valid').addClass('is-invalid');
    return false; 
  }

  $(seletor).removeClass('is-invalid')//.addClass('is-valid');
}

function validaTime(seletor){
  var valor = $(seletor).val();

  if( valor == ':00:00' ) { 
    $(seletor).removeClass('is-valid').addClass('is-invalid');
    return false; 
  }

  $(seletor).removeClass('is-invalid')//.addClass('is-valid');
}

function validaValor(seletor){
  var valor = parseFloat($(seletor).val());

  if(valor < 0) { 
    $("#valor").removeClass('is-valid').addClass('is-invalid');
    return false; 
  }

  $(seletor).removeClass('is-invalid')//.addClass('is-valid');
}

$(document).ready(function(){
  $("#nome").on("blur",function(){validaVazio("#nome")});
  $("#nrloja").on("blur",function(){validaValor("#nrloja")});
  $("#id_conexao").on("blur",function(){validaVazio("#id_conexao")});
  $("#nm_programa").on("blur",function(){validaVazio("#nm_programa")});
  $("#cd_cliente").on("blur",function(){validaValor("#cd_cliente")});
  $("#nm_terminal").on("blur",function(){validaVazio("#nm_terminal")});
  $("#nm_funcionario").on("blur",function(){validaVazio("#nm_funcionario")});
  $("#nr_ramal").on("blur",function(){validaVazio("#nr_ramal")});
  $("#nr_ramal").on("blur",function(){validaVazio("#nr_ramal")});
  $("#nm_usuario").on("blur",function(){validaVazio("#nm_usuario")});
  $("#senha").on("blur",function(){validaVazio("#senha")});
});

// $(document).ready(function() {
//   $.ajax({
//     type: "POST",
//     url: "http://www.programa.net.br/ajax",
//     data: {"method":"getEndereco","parameters":"88817380"},
//     success: function (response) {
//       if (response.sucesso) {
//           alert(response.retorno);
//       }else{
//           alert("erro");                    
//       }
//     },
//   });
// });



