<?php
require 'config.php';
$result = $conn->query("SELECT * FROM hewan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixel Paws</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Jersey+25&display=swap');
        body{
            background-color: #7E5D43;
              font-family: "jersey 25", sans-serif;
        }
        h2{
            color: white;
            font-family: "jersey 25", sans-serif;
           color: #dfdcdcff; 
        }
        nav {
            background-color: #7E5D43;
            font-family: "Jersey 25", sans-serif;
            color: #dfdcdcff;
        }
        .navbar-brand img {
            width: 44px;
            margin-right: 8px;
        }
       .navbar-brand{
        font-size: 30px;
         color: white;
   
       }
      .nav-link{
         color: white;
      }
      .badge.bg-primary {
   background-color: #6c533fff !important;
    color: #e7e6e6ff;
}

.badge.bg-secondary {
    background-color: #bfa792ff !important;
    color: black;
}
.card {
    background-color: #8d6d54ff;   /* warm wood tone */
    color: #dfdcdcff;              /* your off-white text */
    border: none;
    border-radius: 12px;
}

.card-body {
    background-color: #8d6d54ff;
}

.card-title {
    color: #dfdcdcff;
    font-size: 1.35rem; 
}
.card-text {
    font-size: 1.05rem;
}

.badge {
    font-size: 0.95rem;
}
.navbar-brand {
    pointer-events: none;   /* tidak bisa di-click */
    cursor: default;        /* cursor normal */
    text-decoration: none !important;
}
.navbar-brand:hover {
    color: inherit !important;
    opacity: 1 !important;
}


    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #472f20ff">
    <div class="container">
       <span class="navbar-brand d-flex align-items-center">
        <img src="hous.png" alt="">
        Padalarang Pet House
        </span>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>


</nav>
<div class="container py-5">
    <h2 class="fw-bold mb-4">Find Your New Best Friend</h2>
<a href="tambah_hewan.php" class="btn mb-4" style="background-color: #4f3a20ff ; color:white; ">
    + Tambah Hewan
</a>

    <div class="row g-4">

        <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <img src="<?= $row['gambar'] ?>" class="card-img-top" alt="<?= $row['nama_hewan'] ?>">

                <div class="card-body">
                    <h5 class="card-title"><?= $row['nama_hewan'] ?></h5>

                    <span class="badge bg-primary"><?= $row['jenis_hewan'] ?></span>
                    <span class="badge bg-secondary"><?= $row['umur'] ?></span>

                    <p class="card-text mt-3">
                        <?= $row['keterangan'] ?>
                    </p>
<a href="edit_hewan.php?id=<?= $row['id'] ?>" 
   class="btn btn-sm" style="background:#bfa792ff; color:black;">
    Edit
</a>

<a href="hapus_hewan.php?id=<?= $row['id'] ?>" 
   class="btn btn-sm" style="background-color: #6c533fff; color:white;font-family: jersey 25, sans-serif;"
   onclick="return confirm('Yakin mau hapus hewan ini?')">
    Remove
</a>

                </div>
            </div>
        </div>
        <?php endwhile; ?>

    </div>
</div>


</body>
</html>
