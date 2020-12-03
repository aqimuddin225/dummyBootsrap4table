<?php
$user = 'root';
$pass = 'mypass';
$dbh = new PDO('mysql:host=localhost;dbname=pengolahsampah', $user, $pass);
// use the connection here
$sth = $dbh->prepare('select * from sampah order by tanggal_masuk desc');
$sth->execute();
$tbsampah = $sth->fetchAll();

$sth = $dbh->prepare('select * from komposter order by tanggal desc');
$sth->execute();
$tbkompos=$sth->fetchAll();

$sth = $dbh->prepare('select * from kategori inner join daurulang on daurulang.id_kategori = kategori.id_kategori order by tanggal desc');
$sth->execute();
$tbdaurulang = $sth->fetchAll();

$sth = null;
$dbh = null;
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>SI Pemanfaatan Sampah</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tabel Data
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Tabel Sampah TPA</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Tabel Komposter</a>
              <a class="dropdown-item" href="#">Tabel Daur Ulang</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
          </li>
        </ul>
        <a type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Log In</a>
      </div>
    </nav>
  <div class="container mt-3">
    <div class="row">
      <h1>Tabel Data Sampah TPA</h1>
    </div>
    <div class="row">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Sampah Masuk (Kg)</th>
            <th scope="col">Sampah Organik (Kg)</th>
            <th scope="col">Sampah Anorganik (Kg)</th>
            <th scope="col">Residu (Kg)</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1;
            foreach ($tbsampah as $data){
              ?>
              <tr>
                <th scope="row"><?=$i?></th>
                <td><?=$data['tanggal_masuk']?></td>
                <td><?=$data['massa_total']?></td>
                <td><?=$data['organik']?></td>
                <td><?=$data['anorganik']?></td>
                <td><?=$data['residu']?></td>
              </tr>
          <?php
            $i++;}
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="container mt-3">
    <div class="row">
      <h1>Tabel Data Komposter</h1>
    </div>
    <div class="row">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Suhu ('C)</th>
            <th scope="col">Kondisi</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1;
            foreach ($tbkompos as $data){
              ?>
              <tr>
                <th scope="row"><?=$i?></th>
                <td><?=$data['tanggal']?></td>
                <td><?=$data['suhu']?></td>
                <td><?=$data['kondisi']?></td>
                <td><?=$data['keterangan']?></td>
              </tr>
          <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="container mt-3">
    <div class="row">
      <h1>Tabel Data Bank Sampah</h1>
    </div>
    <div class="row">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Kategori</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1;
            foreach ($tbdaurulang as $data){
              ?>
              <tr>
                <th scope="row"><?=$i?></th>
                <td><?=$data['tanggal']?></td>
                <td><?=$data['nama_kategori']?></td>
                <td><?=$data['jumlah']?></td>
                <td><?=$data['keterangan']?></td>
              </tr>
          <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Log In</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
        <div class="form-group">
          <input type="text" class="form-control" id="username" placeholder="Username">
        </div>
        <div class="form-group">
          <input type="text" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Login</button>
      </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
  
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>