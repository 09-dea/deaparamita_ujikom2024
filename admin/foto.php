<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['status'] != 'login') {
    echo "<script> 
    alert('Anda Belum Login!');
    location.href='../index.php';
    </script>";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Galeri Foto</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">

</head>
<style>
    body {
        background-color: #BCB88A;
    }
</style>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Website Galeri Foto</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse mt-2" id="navbarNavAltMarkup">
      <div class="navbar-nav me-auto">
      <a href="home.php" class="nav-link">Home</a>
        <a href="foto.php" class="nav-link">foto</a>
      </div>
      <a href="../config/aksi_logout.php" class="btn btn-outline-danger m-1">Keluar</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-4">
         <div class="card mt-2">
            <div class="card-header">Tambah Foto</div>
            <div class="card-body">
                <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
                    <label class="form-label">Judul Foto</label>
                    <input type="text" name="judul_foto" class="form-control" required>
                    <label class="form-label">Dekripsi</label>
                    <textarea  class="form-control" name="dekripsi_foto" required></textarea>
                    <label class="form-label">File</label>
                    <input type="file" class="form-control" name="lokasi_file" required>
                    <button type="submit" class="btn btn-primary mt-2" name="tambah">Tambah Data</button>
                </form>
            </div>
         </div>
        </div>

        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header">Data Album</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <th>#</th>
                            
                            <th>Judul Foto</th>
                            <th>Dekripsi</th>
                            <th>Tanggal</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $user_id = $_SESSION['user_id'];
                            $sql = mysqli_query($koneksi, "SELECT * FROM foto WHERE user_id='$user_id'");
                            while($data = mysqli_fetch_array($sql)){
                            ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                               
                                <td><?php echo $data['judul_foto'] ?></td>
                                <td><?php echo $data['dekripsi_foto'] ?></td>
                                <td><?php echo $data['tanggal_unggah'] ?></td>
                                <td><a href="../assets/img/<?php echo $data['lokasi_file']?>" ><img src="../assets/img/<?php echo $data['lokasi_file']?>" alt="" width="50px"></a></td>
                                <td>
                        
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?php echo $data['foto_id']?>">Edit</button>

<!-- Modal -->
<div class="modal fade" id="edit<?php echo $data['foto_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
      </div>
      <div class="modal-body">
        <form action="../config/aksi_foto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id']?>">
            <label class="form-label">Judul Foto</label>
                    <input type="text" name="judul_foto" value="<?php echo $data ['judul_foto']?>" class="form-control" required>
                    <label class="form-label">Dekripsi</label>
                    <textarea  class="form-control" name="dekripsi_foto" required> <?php echo $data['dekripsi_foto'];?></textarea>
                    
                    <label class="form-label">Foto</label>
                    <div class="row">
                        <div class="col-md-4">
                        <img src="../assets/img<?php echo $data['lokasi_file'] ?>" width="100">
                        </div>
                        <div class="col-md-8">
                        <label class="form-label"> Ganti File</label>
                        <input type="file" class="form-control" name="lokasi_file" >
                        </div>
                    </div>
                   
                    
        
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-primary">Edit Data</button>
        </form>
      </div>
    </div>
  </div>
</div>


<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $data['foto_id']?>">Hapus</button>

<div class="modal fade" id="hapus<?php echo $data['foto_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
      </div>
      <div class="modal-body">
        <form action="../config/aksi_foto.php" method="POST">
            <input type="hidden" name="foto_id" value="<?php echo $data['foto_id']?>">
            Apakah anda yakin ingin menghapus data? <strong><?php echo $data['judul_foto']?></strong>
        
      </div>
      <div class="modal-footer">
        <button type="submit" name="hapus" class="btn btn-primary">Hapus Data</button>
        </form>
      </div>
    </div>
  </div>
</div>

                              </td>
                            </tr>
                           <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; UKK RPL 2024 | Dhea Paramita</p>
</footer>
 <script type="text/javascript" src="../Assets/js/bootstrap.min.js"></script>
</body>
</html>