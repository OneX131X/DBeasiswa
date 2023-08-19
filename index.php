<?php
include 'conn.php';

$ipk = 3.4; // Memberi nilai default pada $ipk

if (isset($_POST["submit"])) {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nomor_hp = $_POST["nomor_hp"];
    $semester = $_POST["semester"];

    // Hitung nilai IPK berdasarkan kondisi semester
    if ($semester >= 4) {
        $ipk = 3.4;
    } else {
        $ipk = 2.9;
    }

    $beasiswa = $_POST["beasiswa"];
    $berkas = $_FILES["berkas"]; // Ambil data berkas yang diunggah
    
    // Validasi berkas yang diunggah
    if ($berkas["error"] === UPLOAD_ERR_OK) {
        $file_name = $berkas["name"];
        $file_tmp = $berkas["tmp_name"];
        $file_size = $berkas["size"];
        
        // Tentukan direktori tujuan untuk menyimpan berkas
        $directory = "berkas";
        $target_path = $directory . $file_name;
        
        // Pindahkan berkas ke direktori tujuan
        if (move_uploaded_file($file_tmp, $target_path)) {
            // Data berkas berhasil diunggah, lakukan penyimpanan ke database
            $query = "INSERT INTO data_beasiswa VALUES ('', '$nama', '$email', '$nomor_hp', '$semester', '$ipk', '$beasiswa', '$file_name', '')";
            $save = mysqli_query($conn, $query);
            
            if ($save) {
                echo "<script type='text/javascript'>
                    alert ('Data Pendaftaran Berhasil Dikirim...!');
                    document.location.href='hasil.php';
                    </script>;";
            } else {
                echo "<script type='text/javascript'>
                    alert ('Data Pendaftaran Gagal Dikirim...!');
                    document.location.href='index.php';
                    </script>;";
            }
        } else {
            echo "<script type='text/javascript'>
                    alert ('Gagal mengunggah berkas...!');
                    document.location.href='index.php';
                    </script>;";
        }
    } else {
        // Terdapat kesalahan pada berkas yang diunggah
        echo "<script type='text/javascript'>
                alert ('Gagal mengunggah berkas...!');
                document.location.href='index.php';
                </script>;";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Beasiswa</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <script>
        function updateIPK() {
            var semesterSelect = document.getElementById("semester");
            var ipkInput = document.getElementById("ipk");

            if (semesterSelect.value >= 4) {
                ipkInput.value = "3.4";
            } else {
                ipkInput.value = "2.9";
            }
            checkIPK(); // Panggil fungsi checkIPK setelah update nilai IPK
        }

        function checkIPK() {
            var ipk = parseFloat(document.getElementById("ipk").value);
            var beasiswaSelect = document.getElementById("beasiswa");
            var berkasInput = document.getElementById("berkas");
            var daftarButton = document.getElementById("submit");

            if (ipk < 3) {
                beasiswaSelect.disabled = true;
                berkasInput.disabled = true;
                daftarButton.disabled = true;
            } else {
                beasiswaSelect.disabled = false;
                berkasInput.disabled = false;
                daftarButton.disabled = false;
            }
        }

        window.onload = function() {
            updateIPK(); // Panggil fungsi updateIPK saat halaman dimuat
            checkIPK();
        };
    </script>

</head>

<body>
    <div class="container">
        <div class="menu-bar">
            <div class="menu-item">
                <a href="pilih-beasiswa.php">Pilih Beasiswa</a>
            </div>
            <div class="menu-item">
                <a href="index.php">Daftar</a>
            </div>
            <div class="menu-item">
                <a href="hasil.php">Hasil</a>
            </div>
        </div>

        <div class="black-bar"></div>

        <h4 class="form-title">DAFTAR BEASISWA</h4>
        <div class="card-title">Registrasi Beasiswa</div>
        <div class="form-container">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-item">
                        <label class="form-label" for="nama">Masukkan Nama</label>
                    </div>
                    <div class="form-item">
                        <input class="form-input" type="text" name="nama" id="nama" required>
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="email">Masukkan Email</label>
                    </div>
                    <div class="form-item">
                        <input class="form-input" type="email" name="email" id="email" required>
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="nomor_hp">Nomor HP</label>
                    </div>
                    <div class="form-item">
                        <input class="form-input" type="text" name="nomor_hp" id="nomor_hp" required maxlength="12">
                    </div>


                    <div class="form-item">
                        <label class="form-label" for="semester">Semester saat ini</label>
                    </div>
                    <div class="form-item">
                        <select class="form-select" name="semester" id="semester" required onchange="updateIPK()">
                            <option value="">-- pilih semester --</option>
                            <?php
                            for ($i = 1; $i <= 8; $i++) {
                                echo "<option value='$i'>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="ipk">IPK terakhir</label>
                    </div>
                    <div class="form-item">
                        <input class="form-input" type="text" name="ipk" id="ipk" value="<?php echo $ipk; ?>" disabled>
                        <input type="hidden" name="calculated_ipk" value="<?php echo $ipk; ?>">
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="beasiswa">Pilihan Beasiswa</label>
                    </div>
                    <div class="form-item">
                        <select class="form-select" name="beasiswa" id="beasiswa" required>
                            <option value="beasiswa1">Beasiswa 1</option>
                            <option value="beasiswa2">Beasiswa 2</option>
                            <option value="beasiswa3">Beasiswa 3</option>
                        </select>
                    </div>

                    <div class="form-item">
                        <label class="form-label" for="berkas">Upload Berkas Syarat</label>
                    </div>
                    <div class="form-item">
                        <input class="form-input" type="file" name="berkas" id="berkas">
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="form-button form-input" name="submit">Daftar</button>
                    <button type="button" class="form-button cancel form-input" onclick="window.location.href='batal.php'">Batal</button>
                </div>

            </form>
        </div>
    </div>
</body>
<script>
    window.onload = function() {
        // Cek apakah data dikirim melalui POST
        if (<?php echo isset($_POST["submit"]) ? "true" : "false"; ?>) {
            updateIPK();
        }
        checkIPK();
    };
</script>
</html>