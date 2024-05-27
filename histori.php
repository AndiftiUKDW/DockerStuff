<?php
session_start();
$base_url = ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') . '://' . ($_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST']);
if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
    header("Location: $base_url/login.php");
    exit();
  }
include_once("connection.php");
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);
$sql = "SELECT * FROM user where email='$email'";
$result = mysqli_query($conn,$sql);
$row= mysqli_fetch_assoc($result);
$iduser = $row['idUser'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Konseria</title>
        <link rel="stylesheet" href="<?php echo $base_url;?>/history.css">
        <script src="<?php echo $base_url;?>/index.js"></script>
    </head>
    <body>
        <div class="BOX">
            <header id="atas">
                <a href="<?php echo $base_url;?>/index.php"><img src="<?php echo $base_url;?>/images/logoKonseriafixed.png"></a>
                <?php if (isset($_SESSION['email']) || isset($_COOKIE['email'])) : ?>
                    <a href="<?php echo $base_url;?>/logout.php" id="Logout" class="button">Logout</a>
                    <a href="<?php echo $base_url;?>/histori.php" id="Histori" class="button">Histori</a>
                <?php else: ?>
                    <a href="<?php echo $base_url;?>/login.php" id="Login" class="button">Login</a>
                    <a href="<?php echo $base_url;?>/sign_up.php" id="Sign_Up" class="button">Sign Up</a>
                <?php endif; ?>
            </header>
            <main id="tengah">
                <h1>History Pembelian</h1>
                <hr/>
                <?php
                $sql = "SELECT * FROM ordered where user_id=$iduser";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                    $tgl = $row['tgl'];
                    $sqlevent = "SELECT * FROM event where id={$row['event_id']}";
                    $resultevent = mysqli_query($conn,$sqlevent);
                    $rowevent = mysqli_fetch_assoc($resultevent);
                    $sqljumlah = "SELECT count(*) as jumlah from detail_order where id_order={$row['orderid']}";
                    $resultjumlah = mysqli_query($conn,$sqljumlah);
                    $rowjumlah = mysqli_fetch_assoc($resultjumlah);
                    $image = $base_url."/".$row['image_path'];
                    echo "<div class='event_isi'>";
                    echo "<img class='event_img' src='{$image}'>";
                    echo "<p class='nama_event'>{$rowevent['nama_event']}</p>";
                    echo "<p class='nama_artis'>{$rowevent['nama_artis']}</p>";
                    echo "<p class='alamat_event'>{$rowevent['provinsi']}</p>";
                    echo "<p class='alamat_lengkap'>{$rowevent['lokasi']}</p>";
                    echo "<p class='tgl_event'>{$rowevent['tanggal']}</p>";
                    echo "<p class='jumlah_ticket'>Jumlah tiket : {$rowjumlah['jumlah']}</p>";
                    echo "<p class='order_date'>tgl beli: $tgl</p>";
                    echo "<a class='event_link' href='".$base_url."/editprev.php?id={$row['orderid']}'></a>";
                    echo "</div>";
                }
                
                ?>
            </main>
            <footer id="bawah">
                <p>Konseria &copy 2024. All rights reserved</p>
              </footer>
        </div>
    </body>
</html>