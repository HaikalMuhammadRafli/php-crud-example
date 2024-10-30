<?php
include 'database.php';

$query = "SELECT * FROM barangs";
$sql = sqlsrv_query($conn, $query);
$barangs = [];

if ($sql) {
    while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
        $barangs[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <title>BASIC CRUD</title>
</head>

<body>
    <section class="mx-5 mt-3">
        <?php
            if (isset($_GET['msg'])) {
                $msg = htmlspecialchars($_GET['msg']);
                switch ($msg) {
                    case "create":
                        echo "<div class='alert alert-success alert-dismissible fade show'>
                        Barang berhasil disimpan!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button></div>";
                        break;

                    case "update":
                        echo "<div class='alert alert-success alert-dismissible fade show'>
                        Perubahan berhasil disimpan!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button></div>";
                        break;

                    case "delete":
                        echo "<div class='alert alert-success alert-dismissible fade show'>
                        Barang berhasil dihapus!
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='close'></button></div>";
                        break;
                }
            }
        ?>
    </section>
    <h3 class="text-center my-3">DASHBOARD</h3>
    <div class="card mx-5 py-2 px-3">
        <section class="my-2 w-100 d-flex justify-content-between align-items-center">
            <h4>TABEL BARANG</h4>
            <a href="create.php" class="btn btn-primary">TAMBAH BARANG</a>
        </section>
        <section class="card px-3 py-2">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">NAMA BARANG</th>
                        <th scope="col">DESKRIPSI</th>
                        <th scope="col">HARGA</th>
                        <th scope="col">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($barangs as $barang) { ?>
                        <tr>
                            <th scope="row"><?= $i++ ?></th>
                            <td><?= $barang['nama'] ?></td>
                            <td><?= $barang['deskripsi'] ?></td>
                            <td>Rp <?= number_format($barang['harga']) ?></td>
                            <td class="d-flex">
                                <a href="update.php?id=<?= $barang['id'] ?>" class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i></a>
                                <div class="mx-1"></div>
                                <form action="delete.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $barang['id'] ?>">
                                    <button type="submit" name="submit" class="btn btn-danger">
                                        <i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>