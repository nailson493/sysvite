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

<section class="bg-transparent">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <header class="text-2xl
">
  <h1>
      <div>S</div>
      <div>Y</div>
      <div>S</div>
      <div>V</div>
      <div>I</div>
      <div>T</div>
      <div></div>
      <div>E</div>
      <!-- <div>O</div>
      <div>O</div>
      <div>N</div> -->
  </h1>
</header>

        <div class="w-full bg-green-300 rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" action="login.php" method="post">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Usuário</label>
                        <input type="text" name="username" id="username" class="bg-green-50 border border-green-300 text-gray-900 sm:text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" required>
                    </div>
                    <div class="">
                        <label for="password" class="block text-sm mb-2 font-medium text-gray-900 dark:text-white">Senha</label>
                        <input type="password" name="password" id="password" class="bg-green-50 border border-green-300 text-gray-900 sm:text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5" required>
                    </div>
                    <button type="submit" class="w-full text-white bg-green-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
include 'banco.php';

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

</body>
</html>
