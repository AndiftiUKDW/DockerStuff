<?php
session_start();
$base_url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') . '://' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST']) . $_SERVER['REQUEST_URI'];

if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
    header("Location: $base_url/index.php");
    exit();
}

include('connection.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Konseria</title>
        <link rel="stylesheet" href="<?php echo $base_url;?>/lupa.css">
    </head>
    <body>
        <div class="BOX">
            <header id="atas">
                <a href="<?php echo $base_url;?>/index.php"><img src="<?php echo $base_url;?>/images/logoKonseriafixed.png"></a>

            </header>
            <main id="tengah">
                <div class="kotak">
                    <p>"Lupa password Anda? Jangan khawatir! Hubungi customer service kami di konseria@gmail.com untuk mendapatkan bantuan dalam mereset password Anda.<br><br>
                    <div class="button">
                        <a href="<?php echo $base_url;?>/login.php">Kembali</a>
                    </div>
                </div>

                
            </main>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>