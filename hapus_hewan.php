<?php
require 'config.php';
session_start();

if (isset($_GET['id'])) {
    $hewan_id = intval($_GET['id']);


    $stmt = $conn->prepare("SELECT gambar FROM hewan WHERE id = ?");
    $stmt->bind_param("i", $hewan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hewan = $result->fetch_assoc();

    if ($hewan) {
  
        if (!empty($hewan['image']) && file_exists($hewan['image'])) {
            unlink($hewan['image']);
        }

        $delete_stmt = $conn->prepare("DELETE FROM hewan WHERE id = ?");
        $delete_stmt->bind_param("i", $hewan_id);
        $delete_stmt->execute();

        $_SESSION['message'] = "Data hewan telah di hapus";
    } else {
        $_SESSION['message'] = "Data hewan tidak dapat ditemukan";
    }


    header("Location: index.php");
    exit;
} else {

    header("Location: index.php");
    exit;
}
?>
