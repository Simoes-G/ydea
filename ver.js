$(document).ready(function () {
    $('.toggle-password').on('click', function() {
      $(this).toggleClass('fa-eye fa-eye-slash');  // Alterna o ícone de olho aberto para fechado e vice-versa
      let campoSenha = $(this).prev();
      if (campoSenha.attr('type') === 'password') {
        campoSenha.attr('type', 'text');  // Alterna o tipo do input para "text"
      } else {
        campoSenha.attr('type', 'password');  // Alterna o tipo do input para "password"
      }
    });
  });