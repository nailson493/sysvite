<?php 
include "head.php"; 
include "menu.php";
?>

<body>
<script src="scripts/telefone.js"></script>
<script src="scripts/cpf.js"></script>

<div class="p-4 sm:ml-64">
    <div class="p-4 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <p class="text-lg font-medium text-gray-900 dark:text-white">Registrar Usuários</p>
            </div>
            <!-- Modal body -->
            <div class="container max-w-screen-lg mx-auto">
                <div>
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <form id="photo-form" enctype="multipart/form-data">
                                    <video id="camera" class="mb-4 rounded-lg" autoplay></video>
                                    <button type="button" id="capture" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Capturar Foto</button>
                                    <input type="file" id="photo" name="photo" accept="image/*" style="display:none;" required>
                                    <canvas id="canvas" style="display:none;"></canvas>
                                    <div id="preview-container">
                                        <img id="preview" class="rounded-lg" src="">
                                    </div>
                            </div>
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-3">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" id="nome" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 border-green-500" value="" required/>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="cpf">CPF</label>
                                        <input type="text" name="idt" id="cpf" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 border-green-500" oninput="formatarCPF(this)" required/>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="address">Cep</label>
                                        <input type="text" name="cep" id="cep" value="" onblur="pesquisacep(this.value)" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 border-green-500" value="" placeholder="" />
                                    </div>
                                    <div class="md:col-span-3">
                                        <label for="city">Rua</label>
                                        <input type="text" name="rua" id="rua" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 border-green-500" value="" placeholder="" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="city">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 border-green-500" value="" placeholder="" />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" required/>
                                    </div>
                                    <div class="md:col-span-1">
                                        <label for="city">Estado</label>
                                        <input type="text" name="uf" id="uf" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="tel">Telefone</label>
                                        <input type="text" name="tel" id="tel" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 border-green-500" placeholder="(XX) XXXXX-XXXX" required/>
                                        </div>
                                    <div class="md:col-span-3">
                                        <label for="state">Sexo</label>
                                        <select name="sexo" id="countries" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" required>
                                            <option value="" selected>Escolha o sexo</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="feminino">Feminino</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-5 text-right">
                                        <div class="inline-flex items-end">
                                            <button type="submit" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="./scripts/foto.js"></script>

<script>
document.getElementById('photo-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Previne o envio padrão do formulário

    // Obtém os dados do formulário
    var formData = new FormData(this);

    // Envia os dados do formulário para o script PHP usando AJAX
    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.indexOf('application/json') !== -1) {
            return response.json(); // Converte a resposta para JSON
        } else {
            return response.text(); // Converte a resposta para texto
        }
    })
    .then(data => {
        if (typeof data === 'string') {
            // Caso a resposta seja texto e não JSON
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: 'Erro inesperado: ' + data
            });
        } else if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: 'Cadastro realizado com sucesso!'
            });
            // Limpa os campos do formulário após o sucesso
            document.getElementById('photo-form').reset();
            document.getElementById('preview').src = ''; // Limpa a prévia da foto
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
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Algo deu errado! Por favor, tente novamente.'
        });
    });
});
</script>


</body>
