<?php
include 'conn.php';

// Query untuk mengambil semua data dari tabel data_beasiswa
$query = "SELECT * FROM data_beasiswa";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Beasiswa</title>
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

        <h4 class="form-title">>_<</h4>
        <div class="card-title-2">Hasil Beasiswa</div>
        <div class="tabel-container">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Semester</th>
                    <th>IPK</th>
                    <th>Pilihan Beasiswa</th>
                    <th>Nama Berkas</th>
                    <th>Status Ajuan</th>
                </tr>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['nomor_hp'] . "</td>";
                    echo "<td>" . $row['semester'] . "</td>";
                    echo "<td>" . $row['ipk'] . "</td>";
                    echo "<td>" . $row['beasiswa'] . "</td>";
                    echo "<td>";
                    $fileLink = 'berkas' . $row['berkas']; 
                    echo '<a href="' . $fileLink . '"class=berkas-btn target="_blank">' . $row['berkas'] . '</a>';
                    echo "</td>";
                    echo "<td>" . ($row['status_ajuan'] ? $row['status_ajuan'] : 'Belum Diverifikasi') . "</td>";
                    echo "</tr>";
                    $no++;
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>