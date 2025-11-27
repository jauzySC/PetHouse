<?php
require 'config.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id         = $_POST['id'];
    $nama       = $_POST['nama_hewan'];
    $jenis      = $_POST['jenis_hewan'];
    $umur       = $_POST['umur'];
    $keterangan = $_POST['keterangan'];


    $gambar_lama = $_POST['gambar_lama'];
    $gambar_baru = $gambar_lama;

    if (!empty($_FILES['image']['name'])) {

        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir);

        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('hewan_', true) . '.' . $extension;
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $gambar_baru = $targetPath;
        }
    }

    $sql = "UPDATE hewan SET 
                nama_hewan='$nama',
                jenis_hewan='$jenis',
                umur='$umur',
                keterangan='$keterangan',
                gambar='$gambar_baru'
            WHERE id=$id";

    if ($conn->query($sql)) {
        $_SESSION['success'] = "Data hewan berhasil diupdate!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['error'] = "Update gagal: " . $conn->error;
    }
}



if (!isset($_GET['id'])) {
    die("ID hewan tidak ditemukan.");
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM hewan WHERE id = $id");
$data = $result->fetch_assoc();

if (!$data) {
    die("Hewan tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Hewan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jersey+25&display=swap');

        body{
            background-color: #473629ff;
            font-family: "Jersey 25", sans-serif;
            color: #dfdcdcff;
        }

        #hewanForm {
            background: #8d6d54ff;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <div class="mx-auto" style="max-width: 600px;">

        <h2 class="mb-4 fw-bold text-center">Edit Hewan</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php elseif (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="p-4 rounded shadow-sm" id="hewanForm">

            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <input type="hidden" name="gambar_lama" value="<?= $data['gambar'] ?>">

            <div class="mb-3">
                <label class="form-label">Nama Hewan</label>
                <input type="text" name="nama_hewan" class="form-control" value="<?= $data['nama_hewan'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Hewan</label>
                <input type="text" name="jenis_hewan" class="form-control" value="<?= $data['jenis_hewan'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Umur</label>
                <input type="text" name="umur" class="form-control"  value="<?= $data['umur'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"><?= $data['keterangan'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Sekarang</label><br>
                <img src="<?= $data['gambar'] ?>" class="img-fluid rounded mb-2" style="max-height: 150px;">
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Gambar (opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-sm" 
                style="background-color: #6c533fff; color:white;">
                Cancel
                </a>

               <button type="submit" class="btn btn-sm" 
                style="background:#bfa792ff; color:black;">
                Submit
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
