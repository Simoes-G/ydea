$(document).ready(function () {
    $("#cadastro-form").validate({
      rules: {
        nome: {
          required: true,
          minlength: 2,
        },
        email: {
          required: true,
          email: true,
        },
        senha: {
          required: true,
          minlength: 6,
        },
        confirmaSenha: {
          required: true,
          equalTo: "#senha",
        },
      },
      messages: {
        nome: {
          required: "Por favor, insira seu nome.",
          minlength: "O nome deve ter pelo menos 2 caracteres.",
        },
        email: {
          required: "Por favor, insira seu e-mail.",
          email: "Por favor, insira um e-mail válido.",
        },
        senha: {
          required: "Por favor, insira sua senha.",
          minlength: "A senha deve ter pelo menos 6 caracteres.",
        },
        confirmaSenha: {
          required: "Por favor, confirme sua senha.",
          equalTo: "As senhas não coincidem.",
        },
      },
    });
  });