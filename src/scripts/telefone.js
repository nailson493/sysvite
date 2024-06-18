
  document.addEventListener("DOMContentLoaded", function() {
    var phoneInput = document.getElementById('tel');
    var errorMessage = document.getElementById('error-message');

    // Função para aplicar máscara ao número de telefone
    phoneInput.addEventListener('input', function(event) {
      var input = event.target;
      var value = input.value.replace(/\D/g, ''); // Remove todos os caracteres que não são dígitos

      if (value.length > 11) {
        value = value.substring(0, 11); // Limita o comprimento a 11 dígitos
      }

      // Aplica a máscara (XX) XXXXX-XXXX ou (XX) XXXX-XXXX
      if (value.length > 10) {
        input.value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
      } else if (value.length > 6) {
        input.value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
      } else if (value.length > 2) {
        input.value = value.replace(/(\d{2})(\d{0,4})/, '($1) $2');
      } else {
        input.value = value.replace(/(\d{0,2})/, '($1');
      }
    });

    // Função de validação para verificar o formato do telefone
    phoneInput.addEventListener('blur', function(event) {
      var phonePattern = /^\(\d{2}\) \d{4,5}-\d{4}$/;
      var phoneNumber = event.target.value;

      if (!phonePattern.test(phoneNumber)) {
        errorMessage.textContent = 'Por favor, insira um número de telefone válido no formato (XX) XXXX-XXXX ou (XX) XXXXX-XXXX.';
      } else {
        errorMessage.textContent = '';
      }
    });
  });
