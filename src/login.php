<?php
include "banco.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, password FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            session_regenerate_id(true); // Segurança adicional
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Senha incorreta!');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include "head.php"; ?>
<link rel="stylesheet" href="bingo.css">
    <style>
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('fotos/fundo.jpg') no-repeat center center/cover;
            filter: blur(8px);
            z-index: -1;
        }
    </style>

<section class="bg-transparent sm:mt-[5rem]" >
<div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <header class="text-2xl">
    <div class="text-center mb-36 ">
    <!-- Imagem com classe do Tailwind para largura e altura -->
    <img class="w-24 h-24 mx-auto ml-8 mb-4" src="fotos/logo.png" alt="logo">
    <!-- Título com classes de tamanho de texto do Tailwind -->
    <h1 class="text-5xl font-bold">SYSVITE</h1>
  </div>

</header>

        <div class="w-full  md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 ">
            
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" action="login.php" method="post">
                    <div>
                        <label for="username" class="block mb-2 text-lg font-medium text-white">Nome de usuário</label>
                        <input type="text" name="username" id="username" class="bg-green-50 border border-green-300 text-gray-900 sm:text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" placeholder="Nome de usuário" required>
                    </div>
                    <div class="">
                        <label for="password" class="block text-lg mb-2 font-medium text-white">Senha</label>
                        <input type="password" name="password" id="password" class="bg-green-50 border border-green-300 text-gray-900 sm:text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" placeholder="Senha" required>
                    </div>
                    <button type="submit" class="w-full text-white bg-green-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Entrar</button>
                </form>
            </div>
        </div>
        <footer class="mb-8" >
    <div>
        <hr class="my-8 mb-8 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-base text-white sm:text-center dark:text-gray-400">© 2024 <a href="" class="hover:underline">Sysvite™ - Desenvolvido por Sd Nailson - Sd Isaque Jesus </a>. All Rights Reserved.</span>
    </div>
</footer>
    </div>
 
</section>






</body>
</html>
