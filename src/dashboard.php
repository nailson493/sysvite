<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include "head.php"; ?>
<?php include "menu.php"; ?>

<style>
        .flex {
            display: flex;
        }
        .items-end {
            align-items: flex-end;
        }
        .flex-grow {
            flex-grow: 1;
        }
        .bar {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex-grow: 1;
            padding-bottom: 1.25rem;
        }
        .bar span {
            position: absolute;
        }
        .bar span.hidden {
            display: none;
            top: 0;
            margin-top: -1.5rem;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .bar div {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .bar .bg-indigo-200 {
            background-color: #c3dafe;
        }
        .bar .bg-indigo-300 {
            background-color: #a3bffa;
        }
        .bar .bg-indigo-400 {
            background-color: #7f9cf5;
        }
        .bar span.bottom {
            bottom: 0;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>

<div class="antialiased bg-gray-50 dark:bg-gray-900">
  

    <!-- Sidebar -->

  

    <main class="p-4 md:ml-64 h-auto pt-20">
    <section class="text-gray-600 body-font">
  <div class="container px-5 py-24 mx-auto">

    <div class="flex flex-wrap -m-4 text-center">
      <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
        <div class="border-2 border-green-200 px-4 py-6 rounded-lg">
        <svg class="text-green-500 w-12 h-12 mb-3 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
            </svg>


          <?php 
          include "banco.php";
          $sql = "SELECT COUNT(*) AS total_visitas FROM visitas";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              // Exibir o resultado
              $row = $result->fetch_assoc();
              $total_visitas = $row["total_visitas"];

              // Exibindo o resultado na sua página HTML
              echo '<h2 class="title-font font-medium text-3xl text-gray-900">' . $total_visitas . '</h2>';
              echo '<p class="leading-relaxed mb-4">Visitas</p>';
              echo '<a href="painel.php?r=listar_Visitas" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Ver mais</a>              ';

          } else {
              echo "0 resultados";
          }

          $conn->close();
          
          ?>
         
        </div>
      </div>
      <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
        <div class="border-2 border-green-200 px-4 py-6 rounded-lg">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-green-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
          </svg>
          <?php 
          include "banco.php";
          $sql = "SELECT COUNT(*) AS total_dados FROM dados";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              // Exibir o resultado
              $row = $result->fetch_assoc();
              $total_dados = $row["total_dados"];

              // Exibindo o resultado na sua página HTML
              echo '<h2 class="title-font font-medium text-3xl text-gray-900">' . $total_dados . '</h2>';
              echo '<p class="leading-relaxed mb-4">Pessoas</p>';
              echo '<a href="painel.php?r=listar_usuarios" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Ver mais</a>              ';
            } else {
              echo "0 resultados";
          }

          $conn->close();
          
          ?>
        </div>
      </div>
      <?php 
      
      include "banco.php";
      $sql_media = "SELECT AVG(feedbackNumber) AS media_feedback FROM visitas";
$result_media = $conn->query($sql_media);

// Consulta SQL para contar o número total de avaliações
$sql_count = "SELECT COUNT(*) AS total_avaliacoes FROM visitas";
$result_count = $conn->query($sql_count);

if ($result_media->num_rows > 0 && $result_count->num_rows > 0) {
    // Exibir a média das avaliações
    $row_media = $result_media->fetch_assoc();
    $media_feedback = $row_media["media_feedback"];

    // Exibir o número total de avaliações
    $row_count = $result_count->fetch_assoc();
    $total_avaliacoes = $row_count["total_avaliacoes"];

    // Exibindo o resultado na sua estrutura HTML
    echo '<div class="p-4 md:w-1/4 sm:w-1/2 w-full">';
    echo '<div class="border-2 border-green-200 px-4 py-6 rounded-lg h-full">';
    echo '<svg class="w-12 h-12 text-yellow-300 inline-block" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">';
    echo '<path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>';
    echo '</svg>';
    echo '<p class=" text-sm font-bold text-gray-900 dark:text-white">' . number_format($media_feedback, 2) . '</p>';
    echo '<span class="w-1 h-1 mx-1.5 bg-gray-500 rounded-full dark:bg-gray-400"></span>';
    echo '<a href="#" class="text-sm font-medium text-gray-900 underline hover:no-underline dark:text-white">' . $total_avaliacoes . ' avaliações</a>';
    echo '</div>';
    echo '</div>';
} else {
    echo "0 resultados";
}

$conn->close();
?>
      <div class="p-4 md:w-1/4 sm:w-1/2 w-full">
        <div class="border-2 border-green-200 px-4 py-6 rounded-lg h-full">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-green-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
          </svg>
          <h2 class="title-font font-medium text-3xl text-gray-900">20</h2>
          <p class="leading-relaxed">Departamentos</p>
        </div>
      </div>
      
    </div>
    
  </div>
  



<!-- Component End  -->
<div class=" p-6 pb-6 bg-white rounded-lg shadow-xl sm:p-8">
  
  <h2 class="text-xl font-bold">Gráfico Mensal</h2>
  <span class="text-sm font-semibold text-gray-500">2024</span>
  <div class="flex items-end flex-grow w-full mt-2 space-x-2 sm:space-x-3" id="chartContainer">


  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
include "banco.php";

// Consultar dados
$sql = "SELECT destino, COUNT(*) as total_visitas FROM visitas GROUP BY destino";
$result = $conn->query($sql);

$visitas = [];

if ($result->num_rows > 0) {
    // Processar os dados
    while($row = $result->fetch_assoc()) {
        $visitas[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>


<div class="font-sans leading-normal tracking-normal mt-20">

    <canvas id="myChart"></canvas>

    <script>
        // Converter dados PHP para JavaScript
        var visitas = <?php echo json_encode($visitas); ?>;

        // Processar os dados
        var destinos = visitas.map(visita => visita.destino);
        var totalVisitas = visitas.map(visita => visita.total_visitas);

        // Renderizar o gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',  // Você pode mudar para 'bar' ou outro tipo se preferir
            data: {
                labels: destinos,
                datasets: [{
                    data: totalVisitas,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom',
                    labels: {
                        fontColor: 'black',
                        fontSize: 14,
                        padding: 20
                    }
                }
            }
        });
    </script>

</div>

<script>
        async function carregarDados() {
            try {
                const response = await fetch('get_visitas.php');
                const data = await response.json();
                construirGrafico(data);
            } catch (error) {
                console.error('Erro ao buscar dados:', error);
            }
        }

        function construirGrafico(data) {
            const chartContainer = document.getElementById('chartContainer');
            chartContainer.innerHTML = ''; // Limpa o conteúdo atual

            data.forEach(item => {
                const barContainer = document.createElement('div');
                barContainer.classList.add('bar', 'group');

                const visitasText = document.createElement('span');
                visitasText.classList.add('hidden');
                visitasText.textContent = `${item.contagem} visitas`;

                const bar = document.createElement('div');
                bar.classList.add('bg-green-400');
                bar.style.height = `${item.contagem * 10}px`; // Ajuste de escala conforme necessário

                const monthText = document.createElement('span');
                monthText.classList.add('bottom');
                monthText.textContent = getMonthName(item.mes);

                barContainer.appendChild(visitasText);
                barContainer.appendChild(bar);
                barContainer.appendChild(monthText);

                chartContainer.appendChild(barContainer);
            });
        }

        function getMonthName(monthIndex) {
            const months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
            return months[monthIndex - 1];
        }

        window.onload = carregarDados;
    </script>

</body>























</section>

    </main>
    
  </div>
  