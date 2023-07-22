$(document).ready(function() {
  // Aplica máscaras
  $('#email').mask('A', {
    translation: {
      'A': { pattern: /[\w@\-.+]/, recursive: true }
    }
  });

  $('#telefone').mask('(00) 0000-0000');
  $('#valor').mask('#.##0,00', {reverse:true});

  // Verifica se as senhas coincidem em tempo real
  $('#confirmaSenha').on('keyup', function() {
    var senha = $('#senha').val();
    var confirmaSenha = $(this).val();

  //   if (senha !== confirmaSenha) {
  //     $('#confirmaSenha-error').text('As senhas não coincidem.');
  //   } else {
  //     $('#confirmaSenha-error').empty();
  //   }
   });

  // Verifica se o e-mail é válido
  $('#cadastro-form').on('submit', function(event) {
    let email = $('#email').val();
    let regex = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;

    if (!regex.test(email)) {
      $('#email-error').text('Por favor, insira um endereço de e-mail válido.');
      event.preventDefault();
    } else {
      $('#email-error').empty();
    }
  });
});