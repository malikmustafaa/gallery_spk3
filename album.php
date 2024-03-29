<?php
session_start();

include 'config/connect.php';

if ($_SESSION['login'] != 'Username') {
  echo "<script>
  alert('anda belum login');
  location.href='login.php';
  </script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
  <title>Website Gallery Foto</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-success" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="index.php">Website Gallery Foto</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse mt-2" id="navbarNav">
        <div class="navbar-nav me-auto">
          <!-- <a href="home.php" class="nav-link">Home</a> -->
          <a href="album.php" class="nav-link">Album</a>
          <a href="foto.php" class="nav-link">Foto</a>
        </div>
        <?php
        if (isset($_SESSION['login'])) {
          ?>
          <a href="config/aksi_logout.php" class="btn btn-outline-light m-1">Keluar</a>
        <?php } else { ?>
          <a href="register.php" class="btn btn-outline-success m-1">Daftar</a>
          <a href="login.php" class="btn btn-outline-success m-1">Login</a>
        <?php } ?>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card mt-2">
          <div class="card-header">Tambah Album</div>
          <div class="card-body">
            <form action="config/aksi_album.php" method="post">
              <label class="form-label">Nama Album</label>
              <input type="text" name="NamaAlbum" class="form-control" required>
              <label class="form-label">Deskripsi</label>
              <textarea type="text" name="Deskripsi" class="form-control" required></textarea>
              <button class="btn btn-success mt-2" name="tambah">Tambah Data</button>
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
                  <th>Nama Album</th>
                  <th>Deskripsi</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                $userid = $_SESSION['UserID'];
                $sql = mysqli_query($conn, "SELECT * FROM album WHERE UserID='$userid'");
                while ($data = mysqli_fetch_array($sql)) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $no++ ?>
                    </td>
                    <td>
                      <?php echo $data['NamaAlbum'] ?>
                    </td>
                    <td>
                      <?php echo $data['Deskripsi'] ?>
                    </td>
                    <td>
                      <?php echo $data['TanggalDiBuat'] ?>
                    </td>
                    <td>
                      <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#edit<?php echo $data['AlbumID'] ?>">Edit</button>

                      <div class="modal fade" id="edit<?php echo $data['AlbumID'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="config/aksi_album.php" method="POST">
                                <input type="hidden" name="AlbumID" value="<?php echo $data['AlbumID'] ?>">
                                <label class="form-label">Nama Album</label>
                                <input type="text" name="NamaAlbum" value="<?php echo $data['NamaAlbum'] ?>"
                                  class="form-control" required>
                                <label class="form-label">Deskripsi</label>
                                <textarea type="text" name="Deskripsi" value="<?php echo $data['Deskripsi'] ?>"
                                  class="form-control" required>
                                          <?php echo $data['Deskripsi']; ?>
                                        </textarea>
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="edit" class="btn btn-success">Edit Data</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#hapus<?php echo $data['AlbumID'] ?>">Hapus</button>

                      <div class="modal fade" id="hapus<?php echo $data['AlbumID'] ?>" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="config/aksi_album.php" method="POST">
                                <input type="hidden" name="AlbumID" value="<?php echo $data['AlbumID'] ?>">
                                Apakah anda ingin menghapus data? <strong>
                                  <?php echo $data['NamaAlbum'] ?>
                                </strong> ?
                            </div>
                            <div class="modal-footer">
                              <button type="submit" name="hapus" class="btn btn-danger">Hapus Data</button>
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

  <!-- <h2>Selamat datang, <?php echo $_SESSION['username']; ?>!</h2> -->

  <footer class="d-flex justify-content-center border-top mt-3 bg-light fixed-bottom">
    <p>&copy; UKK 2024 | Malik Mustafa Arif</p>
  </footer>

  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>