<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $query = "SELECT * FROM barangs WHERE id = ?";
    $params = [$id];
    $sql = sqlsrv_query($conn, $query, $params);

    if ($sql) {
        $barang = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);
    } else {
        header('Location:index.php');
    }
} else {
    header('Location:index.php');
}

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);   
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $harga = htmlspecialchars($_POST['harga']);
    $id = htmlspecialchars($_POST['id']);

    if (isset($nama) && isset($harga)) {
        $query = "UPDATE barangs SET nama = ?, deskripsi = ?, harga = ? WHERE id = ?";
        $params = [
            $nama,
            $deskripsi,
            $harga,
            $id
        ];

        $sql = sqlsrv_query($conn, $query, $params);
        if ($sql) {
            header("Location:index.php?msg=update");
        } else {
            $errors = print_r(sqlsrv_errors(), true);
            echo "<script>alert('$errors');</script>";
        }
    } else {
        echo "<script>alert('Nama dan Harga Barang harus diisi!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>BASIC CRUD</title>
</head>

<body>
    <h3 class="text-center my-3">CREATE</h3>
    <div class="card mx-5 py-2 px-3">
        <form action="update.php" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $barang['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $barang['deskripsi'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Barang</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?= $barang['harga'] ?>" required>
            </div>
            <input type="hidden" name="id" value="<?= $barang['id'] ?>">
            <button class="btn btn-primary" type="submit" name="submit">SIMPAN</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>