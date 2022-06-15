<?php
session_start();
// Jika tidak bisa login maka balik ke login.php
// jika masuk ke halaman ini melalui url, maka langsung menuju halaman login
if (!isset($_SESSION['login'])) {
    header('location:login.php');
    exit;
}

// Memanggil atau membutuhkan file function.php
require 'function.php';

// Menampilkan semua data dari table siswa berdasarkan nis secara Descending
$siswa = query("SELECT * FROM siswa ORDER BY nis DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <!-- Font Google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <!-- Own CSS -->
    <link rel="stylesheet" href="css/style.css">

    <title>DATA KESISWAAN | SMKN 56 JAKARTA</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-uppercase ">
        <div class="container">
            <a class="navbar-brand" href="index.php">DATA KESISWAAN | SMKN 56 JAKARTA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="smkn56jakarta.sch.id" target="_blank">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">| Logout |</a>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Close Navbar -->

    <!-- Container -->
    <div class="container">
        <div class="row my-2">
            <div class="col-md">
                <h3 class="text-center fw-bold text-uppercase">Data Kesiswaan</h3>
                <hr>
            </div>
        </div>
        <div class="row my-2">
            <div class="col-md">
                <a href="addData.php" class="btn btn-primary"><i class="bi bi-person-plus-fill"></i>&nbsp;Tambah Data</a>
                <a href="export.php" target="_blank" class="btn btn-success ms-1"><i class="bi bi-file-earmark-spreadsheet-fill"></i>&nbsp;Ekspor ke Excel</a>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-md">
            <div class="outer-wrapper">
                <div class="table-wrapper">
                <table id="data" class="table table-striped table-responsive table-hover text-center" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Umur</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($siswa as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['jekel']; ?></td>
                                <?php
                                $now = time();
                                $timeTahun = strtotime($row['tgl_Lahir']);
                                $setahun = 31536000;
                                $hitung = ($now - $timeTahun) / $setahun;
                                ?>
                                <td><?= floor($hitung); ?> Tahun</td>
                                <td><?= $row['jurusan']; ?></td>

                                <td class="action d-flex justify-content-between align-items-stretch">
                                    <button class="btn btn-success btn-sm text-white text-center detail " data-id="<?= $row['nis']; ?>" style="font-weight: 600;"><i class="bi bi-info-circle-fill"></i>&nbsp;
                                    <span class="d-none d-sm-inline">Detail</span></button> 

                                    <a href="ubah.php?nis=<?= $row['nis']; ?>" class="btn btn-warning btn-sm text-white edit-btn" style="font-weight: 600;"><i class="bi bi-pencil-square"></i>&nbsp;<span class="d-none d-sm-inline">Ubah</span></a> 

                                    <a href="hapus.php?nis=<?= $row['nis']; ?>" class="btn btn-danger btn-sm delete-btn" style="font-weight: 600;" onclick="return confirm('Apakah anda yakin ingin menghapus data <?= $row['nama']; ?> ?');"><i class="bi bi-trash-fill"></i>&nbsp;<span class="d-none d-sm-inline">Hapus</span></a>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Close Container -->

    <!-- Modal Detail Data -->
    <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detail" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg d-flex align-items-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-uppercase" id="detail">Detail Data Inventaris</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" id="detail-siswa">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Modal Detail Data -->

    <!-- Footer -->
    <footer class="bg-dark text-center text-sm-start text-light">
  <!-- Grid container -->
  <div class="container p-4">
    <!--Grid row-->
    <div class="row">
      <!--Grid column-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase fw-bold mb-4">Profil</h5>

        <p class="text-sm">
        Tumbuh dan berkembang menjadi lebih besar dan terbaik, merupakan tujuan warga sekolah SMK Negeri 56 Jakarta. Sejarah pengabdian SMK Negeri 56 yang mulai didirikan pada tahun 1984 dan diresmikan penggunaannya pada tanggal 2 Juli 1985 oleh Departemen Pendidikan dan Kebudayaan, berkat kerja sama antara Pemerintah, Industri dan Masyarakat.<br> Gedung sekolah ini merupakan sumbangan dari PT. ASAHIMAS FLAT GLASS CO.LTD.
        </p>
      </div>
      <!--Grid column-->

      <!-- Grid column -->
      <div class="col-md-12 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact
          </h6>
          <p><i class="bi bi-house-door-fill"></i> <a href="https://www.google.com/maps/place/Vocational+High+School+56/@-6.119239,106.795637,10z/data=!4m5!3m4!1s0x2e6a1d8a6ee3aa37:0xcb01d0610bf91d!8m2!3d-6.1191907!4d106.7944354?hl=en-US" target="_blank" style="text-decoration: none;" class="text-light">Alamat : Jl. Raya Pluit Timur No. 1 Penjaringan Jakarta Utara</a></p>
          <p>
          <i class="bi bi-envelope-fill"></i> smkn56jkt@yahoo.com
          </p>
          <p><i class="bi bi-telephone-fill"></i> +62216602880</p>
        </div>
    </div>
    <!--Grid row-->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2022 Copyright:
    <a class="text-light" href="#">KKN STMIK KELOMPOK 3</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Data Tables -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi Table
            $('#data').DataTable();
            // Fungsi Table

            // Fungsi Detail
            $('.detail').click(function() {
                var dataSiswa = $(this).attr("data-id");
                $.ajax({
                    url: "detail.php",
                    method: "post",
                    data: {
                        dataSiswa,
                        dataSiswa
                    },
                    success: function(data) {
                        $('#detail-siswa').html(data);
                        $('#detail').modal("show");
                    }
                });
            });
            // Fungsi Detail
        });
    </script>
</body>

</html>