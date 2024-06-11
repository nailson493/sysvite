<?php
include "head.php";
include "menu.php";

// Número de resultados por página
$results_per_page = 10;

// Página atual
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Ponto inicial para a consulta SQL
$start_from = ($page - 1) * $results_per_page;

// Termo de busca
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Consulta SQL com a cláusula LIMIT e OFFSET
$sql = "SELECT id, nome, cpf, destino, data, motivo, cracha, feedbackNumber FROM visitas WHERE processo = 1";
if (!empty($search)) {
    $sql .= " AND cpf LIKE '%$search%'";
}
$sql .= " LIMIT $start_from, $results_per_page";

include "banco.php";
$result = $conn->query($sql);

// Consulta SQL para obter o número total de registros
$total_sql = "SELECT COUNT(id) FROM visitas WHERE processo = 1";
if (!empty($search)) {
    $total_sql .= " AND cpf LIKE '%$search%'";
}
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];
$total_pages = ceil($total_records / $results_per_page);
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
                <input type="search" id="default-search" name="search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Pesquise pelo CPF" required />
                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-green-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pesquisa</button>
            </div>
        </form>

        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">CPF</th>
                        <th scope="col" class="px-6 py-3">Destino</th>
                        <th scope="col" class="px-6 py-3">Data e Hora</th>
                        <th scope="col" class="px-6 py-3">Motivo</th>
                        <th scope="col" class="px-6 py-3">Nota</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr class='bg-white border-b dark:bg-gray-800 dark:border-gray-700'>";
                            echo "<th scope='row' class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'>" . $row["nome"] . "</th>";
                            echo "<td class='px-6 py-4'>" . $row["cpf"] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row["destino"] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row["data"] . "</td>";
                            echo "<td class='px-6 py-4'>" . $row["motivo"] . "</td>";
                            echo "<td class='px-6 py-4'>
                                <div class='flex items-center'>
                                    <span>" . $row['feedbackNumber'] . "</span>
                                    <svg class='w-4 h-4 ml-1 text-yellow-300' aria-hidden='true' xmlns='http://www.w3.org/2000/svg' fill='currentColor' viewBox='0 0 22 20'>
                                        <path d='M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z'/>
                                    </svg>
                                </div>
                            </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='px-6 py-4 text-center'>Nenhum dado encontrado</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

       <!-- Paginação -->
<nav aria-label="Page navigation example" class="mt-4">
    <ul class="flex items-center justify-center -space-x-px h-10 text-base">
        <?php if($page > 1): ?>
            <li>
                <a href="painel.php?r=listar_visitas&page=<?php echo $page-1; ?>" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Previous</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li>
                <a href="painel.php?r=listar_visitas&page=<?php echo $i; ?>" class="flex items-center justify-center px-4 h-10 leading-tight <?php if($page == $i) { echo 'text-blue-600 border border-blue-300 bg-blue-50'; } else { echo 'text-gray-500 bg-white border border-gray-300'; } ?> hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <?php echo $i; ?>
                </a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li>
                <a href="painel.php?r=listar_visitas&page=<?php echo $page+1; ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-s-0 border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Next</span>
                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 9l4-4-4-4"/>
                    </svg>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

    </div>
</div>
