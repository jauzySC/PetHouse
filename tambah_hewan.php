<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama_hewan']);
    $jenis = trim($_POST['jenis_hewan']);
    $umur = (int)$_POST['umur'];
    $keterangan = trim($_POST['keterangan']);



    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir);


    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        $_SESSION['error'] = "Invalid image type.";
        header("Location: tambah_hewan.php");
        exit;
    }


    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $fileName = uniqid('hewan_', true) . '.' . $extension;
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {

        $stmt = $conn->prepare("
            INSERT INTO hewan 
            (nama_hewan, jenis_hewan, umur, keterangan,gambar)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssiss", $nama, $jenis, $umur,$keterangan, $targetPath);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Hewan <strong>" . htmlspecialchars($nama) . "</strong> berhasil ditambahkan!";
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Database error: " . $conn->error;
        }

    } else {
        $_SESSION['error'] = "Error uploading image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
   <body>
<div class="container py-5">

    <div class="mx-auto" style="max-width: 600px;">

        <h2 class="mb-4 fw-bold text-center">Tambah Hewan Baru</h2>

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

            <div class="mb-3">
                <label class="form-label">Nama Hewan</label>
                <input type="text" name="nama_hewan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Hewan</label>
                <input type="text" name="jenis_hewan" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Umur</label>
                <input type="number" name="umur" class="form-control" min="0" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Hewan</label>
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
