<?php
 include "head.php";
//  include "scripts/functions.php";
 ?>

    <?php
        if (isset($_GET['r'])) {
                $rota = $_GET['r'];
            } else {
                $rota = ''; // Defina um valor padrão caso 'r' não esteja definido na URL
            }


    switch($rota){

        case 'dashboard':
                include "dashboard.php";
                break;
        case 'abertos':
                include "andamento.php";
                break;
        case 'listar_visitas':
                include "listar_visitas.php";
                break; 
        case 'listar_usuarios':
                include "listar_usuarios.php";
                break;
        case 'reg_visita':
                include "registrar_visita.php";
                break;
        case 'reg_user':
                include "registrar_user.php";
                break;
        case 'tableExcluir':
                include "views/tab_excluir2.php";
                break;  
        default:
                include "index.php";
                break;
            
    }
    


    ?>

 

</body>
</html>