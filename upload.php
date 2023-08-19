<?php

include 'conn.php';
$directory = "berkas";
$file_name = $_FILES['berkas']['name'];
move_uploaded_file($_FILES['berkas']['tmp_name'], $directory.$file_name);
$ipk = $_POST['calculated_ipk'];
$query = "INSERT INTO data_beasiswa VALUES ('', '$_POST[nama]', '$_POST[email]', '$_POST[nomor_hp]', '$_POST[semester]', '$ipk', '$_POST[beasiswa]', '$file_name', '')";

$save = mysqli_query($conn, $query);
if ($save)
{
    echo "<script type='text/javascript'>
            alert('Data Pendaftaran Berhasil Dikirim...!');
            document.location.href = 'hasil.php?';
        </script>";
} else {
    echo "<script type='text/javascript'>
            alert('Data Pendaftaran Gagal Dikirim...!');
            document.location.href = 'index.php';
        </script>";
}

?>