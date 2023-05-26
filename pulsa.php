<?php 

    // MYSQL Connection
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'pulsa';

    $koneksi = mysqli_connect($host, $user, $password, $database);

    if(!$koneksi){
        echo "Error connecting : " . mysqli_error($koneksi);
    }

    // Untuk Mengambil DB table Users (konter)
    function get_db(){
        global $koneksi, $id, $nama, $saldo;
        $query = "SELECT * FROM users";
        $hasil = mysqli_query($koneksi, $query);
        // var_dump($hasil);
        // echo "<br>";
        // var_dump(mysqli_num_rows($hasil));
        if (mysqli_num_rows($hasil) > 0){
            while ($row = mysqli_fetch_assoc($hasil)){
                $nama = $row['nama'];
                $saldo = $row['Saldo'];
            }
        }    
        
    }
    
    get_db();

     // cek gpost ada gak isinya
     if($_POST){
        // cek top up harus ada
        if($_POST['nominal'] > 0){
            // update saldo
            $saldo_post = $saldo - $_POST['nominal'];
            $query = "UPDATE users SET Saldo='$saldo_post'  WHERE id=1";
            $hasil = mysqli_query($koneksi, $query);
            
            
            if($hasil){
                $telepon = $_POST['telepon'];
                $provider = $_POST['provider'];
                $nominal = $_POST['nominal'];
                // $query2 = "INERT INTO riwayat (tanggal, telepon, nominal, provider, 1) VALUE ('1', '$telepon', '$nominal', '$provider','1');
                $query2 = "INSERT INTO riwayatt (tanngal, telepon ,provider, nominal, id_counter) VALUES ( '2','$telepon',  '$provider', '$nominal','1')";
                $hasil2 = mysqli_query($koneksi, $query2);

                }
            if ($hasil2){
                get_db();
            }else {
                echo "gagal : " . mysqli_error($koneksi);
            }
        }else {
            echo "gagal : " . mysqli_error($koneksi);
        }
    }

    // Ini untuk konvert mata uang rupiah
    function rupiah($angka)
    {
        return 'Rp. '.strrev(implode('.',str_split(strrev(strval($angka)),3)));
    }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pulsa | Transaksi</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="app">
        <div class="sidebar">
            <h1><i>Admin</i></h1>
            <ul>
                <li><a href="index.php">Top Up</a></li>
                <li><a class="active" href="pulsa.php">Transaksi</a></li>
                <li><a href="riwayat.php">Riwayat</a></li>
            </ul>
        </div>
        <div class="root">
            <div class="nav">
                <h2>
                    <i class="fa-solid fa-wallet" style="color: #256d85;margin-right: 10px;"></i>
                    <?php echo rupiah($saldo);?>
                </h2>
                <h3>
                    <?php echo $nama ?>
                    <i class="fa-solid fa-user" style="color: #fff;margin-left: 10px;padding: 10px;background-color: #256d85;border-radius: 20px;"></i>
                </h3>
            </div>
            <div class="main">
                <div class="box">
                    <h2>Pulsa</h2>
                    <br>
                    <form action="" method="POST">
                        <input type="text" placeholder="Masukan Nomer " name="telepon"/>
                        <input type="number" placeholder="Masukan Jumlah Pulsa" name="nominal"/>
                        <br>
                        <label for="xl">XL</label>
                        <input type="radio" id="xl" value="xl" name="provider"</input>
                        <label for="tri">3</label>
                        <input type="radio" id="tri" value="3" name="provider">
                        <label for="m3">m3</label>
                        <input type="radio" id="m3" value="m3" name="provider">
                        <label for="tel">Telkomsel</label>
                        <input type="radio" id="tel" value="tel" name="provider">
                        <button type="submit">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>