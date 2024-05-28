<?php
session_start();
include_once("connection.php");

if (!isset($_SESSION['email']) && !isset($_COOKIE['email'])) {
  header("Location: $base_url/login.php");
  exit();
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : (isset($_COOKIE['email']) ? $_COOKIE['email'] : '');
$isLoggedIn = isset($_SESSION['email']) || isset($_COOKIE['email']);


if(!$_GET){
  header("Location: $base_url/index.php");
} else {

  $sqldapet = "SELECT * FROM ordered where orderid=$_GET[id]";
  $result = mysqli_query($conn,$sqldapet);
  $row = mysqli_fetch_assoc($result);
  $orderid = $row["orderid"];
  $eventId = $row["event_id"];
  $userid = $row["user_id"];
  $sql = "SELECT idUser FROM user where email='$_SESSION[email]'";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  if($userid != $row['idUser']){
    header("location: $base_url/index.php");
  }
  $sql = "SELECT * FROM event where id=$eventId";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
  $judul = $row['nama_event'];
  $tgl = date('d F Y',strtotime($row['tanggal']));
  $jam = date("H:i",strtotime($row['jam']));
  $poster  = $base_url."/".$row['image_path'];
  $lokasi = $row['lokasi'];
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Konseria</title>
    <link rel="stylesheet" href="<?php echo $base_url;?>/editprev.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet"
    />
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
        <!-- BreadCrumb -->
        <div>
          <p id="BreadCrumb">
            <a class="home_button" href="<?php echo $base_url;?>/index.php">
              <i class="fa fa-home"></i> </a
            >> Detail Ticket
          </p>
        </div>
        <div class="eventdetail">
          <h1 class="bold">Detail Event</h1>

          <img
            class="event_img"
            src="<?php echo $poster;?>"
            alt="Gambar Konser"
          />
          <p id="judulevent"><b><?php echo $judul;?></b></p>

          <p id="lokasievent">
            <i class="material-icons">place</i>
            <a id="Alamat"><?php echo $lokasi;?></a>
          </p>
          <p id="waktuevent"><i class="fa fa-clock-o"></i> <?php echo $jam;?></p>
          <p id="tanggalevent"><i class="fa fa-calendar"></i><?php echo $tgl;?></p>
        </div>
        <div id="bagian_kanan">
          <script>
            function checkdata(){
              let kedobel = false;
              let email = [];
              let phone =[];
              let nik =[];
              let emailInput = document.querySelectorAll('input[name^="email"]');
              let phoneInput = document.querySelectorAll('input[name^="phoneNum"]');
              let NIKInput = document.querySelectorAll('input[name^="Identity"]');
              emailInput.forEach(function(input) {
                  if (email.includes(input.value)) {
                      kedobel = true;
                  }
                  email.push(input.value);
              });
              phoneInput.forEach(function(input) {
                  if (phone.includes(input.value)) {
                      kedobel = true;
                  }
                  phone.push(input.value);
              });
              NIKInput.forEach(function(input) {
                  if (nik.includes(input.value)) {
                      kedobel = true;
                  }
                  nik.push(input.value);
              });

              if(kedobel){
                alert("Satu orang tidak boleh lebih dari 1 ticket");
                return false;
              } else{
                return true;
              }
            }
          </script>
          <form action="<?php echo $base_url;?>/update.php" method="post" onsubmit="return checkdata()">
            <?php
            $curdate = new DateTime(date('d F Y'));
            $datadate = new DateTime($tgl);
            $kelebihan = " ";
            if($curdate > $datadate){
                $kelebihan = "disabled";
            }
            $sql = "SELECT * from detail_order where id_order=$orderid";
            $result = mysqli_query($conn,$sql);
            $c = 0;
            while($row = mysqli_fetch_assoc($result)){
                $sql = "SELECT Name from ticket where id=$row[id_ticket]";
                $hasil = mysqli_query($conn,$sql);
                $roq = mysqli_fetch_assoc($hasil);
                $namatiket= $roq['Name'];
                $email = $row["email"];
                $nama = $row['nama'];
                $dob = $row['dob'];
                $nik = $row['nik'];
                $gender = $row['gender'];
                $phonenum = $row['phonenum'];
                $address = $row['address'];
                $nodetail = $row['id'];
                $male = " ";
                $female = " ";
                if($gender=="male"){
                    $male = "checked";
                } else {
                    $female = "checked";
                }
                echo "<div id='RegistrationData'>";
                echo "<h1 class='bold'>Registration Data</h1>";
                echo "<p class='notiket'>Tiket $namatiket</p>";
                echo "<div id='spacer_regis'>";
                echo "<label for='email[$c]'>Email:</label><br />";
                echo "<input type='email' id='email' name='email[$c]' class='boxpanjang' value='$email' $kelebihan required /><br />";
                echo "<label for='name[$c]'>Name:</label><br />";
                echo "<input type='text' id='name' name='name[$c]' class='boxpanjang' required value='$nama' $kelebihan /><br />";
                echo "<label for='DoB[$c]'>Date of Birth:</label><br />";
                echo "<input type='date' id='DoB' name='DoB[$c]' value='$dob' required $kelebihan /><br /><br />";
                echo "<label for='gender[$c]'>Gender</label><br />";
                echo "<input type='radio' name='gender[$c]' value='male' $male required $kelebihan/> Male";
                echo "<input type='radio' name='gender[$c]' value='female' $female required $kelebihan/> Female <br /> <br />";
                echo "<label for='phoneNum[$c]'>Phone Number</label> <br />";
                echo "<input type='phoneNum' id='phoneNum' name='phoneNum[$c]' value='$phonenum' class='boxpanjang' required $kelebihan /> <br />";
                echo "<label for='Identity[$c]'>Nomor KTP/NIK:</label><br />";
                echo "<input type='text'id='Identity'name='Identity[$c]'class='boxpanjang' value='$nik' required $kelebihan /> <br />";
                echo "<label for='Address[$c]'>Address</label><br />";
                echo "<input type='text' id='Address'name='Address[$c]' value='$address' class='boxpanjang' required $kelebihan />";
                echo "<input type='hidden' name='detailid[$c]' value='$nodetail'/>";
                echo "</div>";
                echo "</div>";
                $c++;
            }
             echo "<input type='submit' id='buttonbayar' value='Ok' $kelebihan >";
            ?>
          </form>
          <form action="<?php echo $base_url;?>/hapus.php" method="POST">
            <?php
            echo "<input type='hidden' name='orderid' value='$orderid'/>";
            echo "<input type='submit' id='buttonhapus' value='Hapus' $kelebihan >";
            ?>
            </form>
        </div>
      </main>
      <footer id="bawah">
        <p>Konseria &copy 2024. All rights reserved</p>
      </footer>
    </div>
  </body>
</html>
