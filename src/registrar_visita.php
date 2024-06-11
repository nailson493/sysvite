<?php 
include "head.php";

// Defina o fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Obtenha a data e hora atual
$dataHoraAtual = date('d/m/Y H:i:s');

// Exiba a data e hora atual
echo "Data e Hora Atual: " . $dataHoraAtual;
?>

<?php include "menu.php"; ?>
<style>
    .disabled-option {
        color: red;
        background-color: #f8d7da; /* Opcional: Para dar um fundo diferente às opções desabilitadas */
    }
</style>

<div class=" sm:ml-64">
   
<div class="p-4 border-dashed rounded-lg dark:border-gray-700 mt-14">
    <!-- <div class="relative p-4 w-full max-w-2xl h-full md:h-auto"> -->
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">

            <p class="text-lg font-medium text-gray-900 dark:text-white">Registrar Visita</p>
            </div>
        
    <!-- Formulário de busca -->
    <form id="search-form" class="text-left">   
        <label for="cpf-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Buscar pelo CPF</label>
        <div class="relative mb-6">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="search" id="cpf-search" name="cpf-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar pelo CPF..." required />
            <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-[#16A34A] hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buscar</button>
        </div>
    </form>

    <!-- Formulário completo, inicialmente oculto -->
    <form id="form-visita"  method="post" enctype="multipart/form-data"  class="hidden">
        <div class="-mx-3 flex flex-wrap">
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="nome" class="mb-3 block text-base font-medium text-[#07074D]">Nome</label>
                    <input type="text" name="nome" id="nome"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#16A34A] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/2">
                <div class="mb-5">
                    <label for="idt" class="mb-3 block text-base font-medium text-[#07074D]">CPF</label>
                    <input type="text" name="idt" id="idt"
                        class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#16A34A] focus:shadow-md" />
                </div>
            </div>
        </div>
    
        <div class="-mx-3 flex flex-wrap">
            <div class="mb-5 w-full px-3 sm:w-1/3" >
                <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">Destino</label>
                <select id="countries" name="destino" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#16A34A] focus:shadow-md" required>
                  <option selected>Escolha o destino</option>
                  <option value="FSB">FSB</option>
                  <option value="PRM">PRM</option>
                  <option value="FUSEX">FUSEX</option>
                  <option value="OCP">OCP</option>
                  <option value="S4">S4</option>
                  <option value="ALMOX">ALMOX</option>
                  <option value="PIPA">PIPA</option>
                  <option value="CCAP">CCAP</option>
                  <option value="1CIA">1 CIA</option>
                  <option value="2CIA">2 CIA</option>
                  <option value="3CIA">3 CIA</option>
                  <option value="RANCHO">Rancho</option>
                  <option value="SECRET">SECRET</option>
                  <option value="PMT">PMT</option>
                  <option value="SFPC">SFPC</option>
                  <option value="PCSCMT">PC CMT</option>
                  <option value="PCCMT">PC SCMT</option>
                  <option value="SALC">SALC</option>
                  <option value="S2">S2</option>
                  <option value="JUS">JUSTIÇA</option>






                </select>
              </div>
            <div class="w-full px-3 sm:w-1/3">
                <div class="mb-5" onload="startTime()">
                    <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">Date</label>
                    <input type="text" name="data" id="date" value="<p >Data: <?php echo date('d/m/Y') ; ?> <span id='clock'></span></p> " class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#16A34A] focus:shadow-md" />
                </div>
            </div>
            <div class="w-full px-3 sm:w-1/3">
                <div class="mb-5">
                    <label for="time" class="mb-3 block text-base font-medium text-[#07074D]">N° Crachá</label>
                                          <?php
                    include "banco.php";
                      // Consultar os números já utilizados na coluna 'processo'
                      $query = "SELECT cracha FROM visitas";
                      $result = $conn->query($query);
                      
                      $usedNumbers = [];
                      if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                              $usedNumbers[] = $row['cracha'];
                          }
                      }

                      $conn->close();
                      ?>

                      <style>
                          .disabled-option {
                              background-color: #fee2e2; /* Tailwind bg-red-100 */
                              color: #ef4444; /* Tailwind text-red-500 */
                          }
                      </style>

<select id="countries" name="cracha" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required>
    <option value="" selected>Escolha o crachá</option>
    <?php
    $i = 1;
    while ($i <= 30) {
        $disabled = in_array($i, $usedNumbers) ? 'disabled' : '';
        $class = in_array($i, $usedNumbers) ? 'class="disabled-option"' : '';
        echo "<option value=\"{$i}\" {$disabled} {$class}>{$i}</option>";
        $i++;
    }
    ?>
</select>

                </div>
            </div>
        </div>

        <div class="mb-5 pt-3">
            <div class="-mx-3 flex flex-wrap">
                <div class="w-full px-3">
                <label for="time" class="mb-3 block text-base font-medium text-[#07074D]">Motivo da Visita</label>
                <textarea id="message" name="motivo" rows="4" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#16A34A] focus:shadow-md" required></textarea>
                </div>      
            </div>
        </div>

        <div>
            <button type="submit" class="hover:shadow-form w-full rounded-md bg-[#16A34A] py-3 px-8 text-center text-base font-semibold text-white outline-none">
                Registrar Visita
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('search-form').addEventListener('submit', function(event) {
    event.preventDefault();
    var cpf = document.getElementById('cpf-search').value;

    console.log('CPF digitado:', cpf); // Log para verificar o CPF inserido

    fetch('buscar.php?cpf=' + cpf)
        .then(response => {
            console.log('Resposta do servidor:', response); // Log para verificar a resposta do servidor
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor');
            }
            return response.json();
        })
        .then(data => {
            console.log('Dados recebidos:', data); // Log para verificar os dados recebidos

            if (data.success) {
                // Preenche o formulário com os dados recebidos
                document.getElementById('nome').value = data.nome;
                document.getElementById('idt').value = data.cpf;
  

                // Mostra o formulário
                document.getElementById('form-visita').classList.remove('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'CPF não encontrado!'
                });
            }
        })
});
</script>
<script>
document.getElementById('form-visita').addEventListener('submit', function(event) {
    event.preventDefault(); // Previne o envio padrão do formulário

    // Obtém os dados do formulário
    var formData = new FormData(this);

    // Envia os dados do formulário para o script PHP usando AJAX
    fetch('visita.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Verifica se a resposta é do tipo JSON
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return response.json(); // Converte a resposta para JSON
        } else {
            throw new Error('A resposta do servidor não é um JSON válido');
        }
    })
    .then(data => {
        // Exibe uma mensagem de sucesso ou erro usando SweetAlert2
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: data.message
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Erro ao cadastrar: ' + data.message
            });
        }
    })
    .catch(error => {
        console.error('Erro:', error);

        let errorMessage;
        if (error.message === 'A resposta do servidor não é um JSON válido') {
            errorMessage = 'Erro ao processar a resposta do servidor. A resposta não é um JSON válido.';
        } else if (error instanceof TypeError) {
            errorMessage = 'Erro de rede ou URL inválida. Verifique sua conexão e o endereço do servidor.';
        } else if (error instanceof SyntaxError) {
            errorMessage = 'Erro ao processar a resposta do servidor. A resposta não é um JSON válido.';
        } else {
            errorMessage = 'Ocorreu um erro desconhecido. Tente novamente mais tarde.';
        }

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: errorMessage
        });
    });
});
</script>



          
        </div>
      </div>
    </div>
  </div>
</div>
</div>

   