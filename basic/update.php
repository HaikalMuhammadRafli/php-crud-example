<?php
// mengimport kode program yang ada didalam database.php
include 'database.php';

// mengecek apakah ada value msg di dalam url dengan menggunakan $_get
if (isset($_GET['id'])) {
    // memasukkan value dari url ke dalam variabel
    $id = htmlspecialchars($_GET['id']);
    // query sql
    $query = "SELECT * FROM barangs WHERE id = ?";
    // parameter atau data yang akan dimasukkan ke dalam tanda tanya (?) di query
    $params = [$id];
    // eksekusi query
    $sql = sqlsrv_query($conn, $query, $params);

    // jika query berhasil maka data yang didapat akan dimasukkan ke dalam variabel
    if ($sql) {
        $barang = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);
    } else {
        header('Location:index.php');
    }
} else {
    header('Location:index.php');
}

// mengecek apakah ada data bernama 'submit'
if (isset($_POST['submit'])) {
    // memasukkan value bersih dari $_POST ke dalam variabel-variabel
    $nama = htmlspecialchars($_POST['nama']);   
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $harga = htmlspecialchars($_POST['harga']);
    $id = htmlspecialchars($_POST['id']);

    // mengecek apakah $nama dan $harga sudah terisi
    if (isset($nama) && isset($harga)) {
        // query sql
        $query = "UPDATE barangs SET nama = ?, deskripsi = ?, harga = ? WHERE id = ?";
        // parameter atau data yang akan dimasukkan ke dalam tanda tanya (?) di query
        $params = [
            $nama,
            $deskripsi,
            $harga,
            $id
        ];
        // eksekusi query
        $sql = sqlsrv_query($conn, $query, $params);

        // jika query berhasil maka akan dikembalikan ke halaman index
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
    <h3 class="text-center my-3">UPDATE</h3>
    <div class="card mx-5 py-2 px-3">
        <form action="update.php" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Barang</label>
                <!-- input nama dengan value yang didapatkan dari variabel barang hasil query php diatas -->
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $barang['nama'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                <!-- input deskripsi dengan value yang didapatkan dari variabel barang hasil query php diatas -->
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= $barang['deskripsi'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Barang</label>
                <!-- input harga dengan value yang didapatkan dari variabel barang hasil query php diatas -->
                <input type="number" class="form-control" id="harga" name="harga" value="<?= $barang['harga'] ?>" required>
            </div>
            <!-- mencantumkan id barang untuk digunakan dalam query nantinya -->
            <input type="hidden" name="id" value="<?= $barang['id'] ?>">
            <!-- tombol kirim yang memiliki nama 'submit' -->
            <button class="btn btn-primary" type="submit" name="submit">SIMPAN</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>