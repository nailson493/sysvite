<?php
include "head.php";
include "menu.php";
?>
<div class="p-4 sm:ml-64">
<div class="p-4 border-dashed rounded-lg dark:border-gray-700 mt-14">
<form class="mb-4" method="POST" action="">
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input type="search" id="default-search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pesquise pelo CPF" value="<?php echo isset($_POST['search']) ? $_POST['search'] : ''; ?>" required />
        <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-green-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pesquisa</button>
    </div>
</form>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">Nome</th>
                <th scope="col" class="px-6 py-3">CPF</th>
                <th scope="col" class="px-6 py-3">CEP</th>
                <th scope="col" class="px-6 py-3">Rua</th>
                <th scope="col" class="px-6 py-3">Bairro</th>
                <th scope="col" class="px-6 py-3">Cidade</th>
                <th scope="col" class="px-6 py-3">Estado</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <?php
            
            include "banco.php";

            $sql = "SELECT id, nome, cpf, cep, telefone, rua, bairro, cidade, estado, photo_path FROM dados";
            
            // Adicionando pesquisa ao SQL se houver
            if (!empty($_POST['search'])) {
                $search = $_POST['search'];
                $sql .= " WHERE cpf LIKE '%$search%'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">';
                    echo '<th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    <img class="w-10 h-10 rounded-full" src="'. $row["photo_path"] .'" alt="Jese image">
                    <div class="ps-3">';
                    echo '<div class="text-base font-semibold">'. $row["nome"] .'</div>';
                    echo '<font-normal text-gray-500">'. $row["cpf"] .'</div>';

                    echo "<td class='px-6 py-4'>" . $row["telefone"] . "</td>";
                    echo "<td class='px-6 py-4'>" . $row["cep"] . "</td>";
                    echo "<td class='px-6 py-4'>" . $row["rua"] . "</td>";
                    echo "<td class='px-6 py-4'>" . $row["bairro"] . "</td>";
                    echo "<td class='px-6 py-4'>" . $row["cidade"] . "</td>";
                    echo "<td class='px-6 py-4'>" . $row["estado"] . "</td>";

                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' class='px-6 py-4 text-center'>Nenhum dado encontrado</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</div>
<style>
    .modal {
      transition: opacity 0.25s ease;
    }
    body.modal-active {
      overflow-x: hidden;
      overflow-y: visible !important;
    }
  </style>

</head>
  
  <!--Modal-->
  <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
      
      <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
        <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
          <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
        <span class="text-sm">(Esc)</span>
      </div>

      <!-- Add margin if you want to see some of the overlay behind the modal-->
      <div class="modal-content py-4 text-left px-6">
        <!--Title-->
       
        <div class="flex justify-between items-center pb-3">
    <p class="text-2xl font-bold"></p>
    <div class="modal-close cursor-pointer z-50">
        <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
        </svg>
    </div>
</div>

<!--Body-->
<p>
    <div class="mb-4 flex items-center" id="star-rating">
        <!-- Estrelas -->
    </div>
</p>
<p><textarea id="message" rows="4" class="mb-4 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escreva seus pensamentos aqui..."></textarea>
</p>
<!--Footer-->
<div class="flex justify-end pt-2">
    <button id="close-button" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Encerrar</button>
</div>
</div>
</div>
</div>
</div>  
<script src="./scripts/starStyle.js"></script>
<script src="./scripts/starSQL.js"></script>
