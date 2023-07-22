$(document).ready(function () {
    $('#form').submit(function (event) {
      event.preventDefault(); //impede que o form seja submetido
  
      var password = $('#password').val();
  
      if (password.length < 8) {
        alert('A senha precisa ter pelo menos 8 caracteres')
        return false;
      }
  
      if (!/[a-z]/.test(password)) {
        alert('A senha precisa ter pelo menos uma letra minúscula')
        return false;
      }
  
      if (!/[A-Z]/.test(password)) {
        alert('A senha precisa ter pelo menos uma letra maiúscula')
        return false;
      }
  
      if (!/[0-9]/.test(password)) {
        alert('A senha precisa ter pelo menos um número')
        return false;
      }
  
      //chama a função de criptografar a senha
      var hashedPassword = bcrypt.hashSync(password, 10);
  
      //agora você pode enviar a senha criptografada para o servidor
      //juntamente com outros dados do formulário
    })
  })
 