<?php

require_once 'process.php';

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

$sth = $dbh->prepare('select * from kategori');
$sth->execute();
$view=$sth->fetchAll();

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

    <title>Admin</title>
  </head>
  <body>
    
    <?php
      if (isset($_SESSION['message'])): ?>

      <div class="alert alert-<?=$_SESSION['msg_type'];?>" role="alert">
        <?=$_SESSION['message'];?>
      </div>
    <?php 
      unset($_SESSION['message']);
      endif
    ?>
    
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
        <a class="btn btn-primary" href="home.php" role="button">Log Out</a>
      </div>
    </nav>
  <div class="container mt-3">
    <div class="row">
      <h1>Tabel Data Sampah TPA</h1>
    </div>
    <div class="row mb-3">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddItemModal">
        Add Items
      </button>
    </div>
    <div class="row">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Sampah Masuk (Kg)</th>
            <th scope="col">Sampah Organik (Kg)</th>
            <th scope="col">Sampah Anorganik (Kg)</th>
            <th scope="col">Residu (Kg)</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $i = 1;
            foreach ($tbsampah as $data){
              ?>
              <tr>
                <th scope="row"><?=$i?></th>
                <td><?=$data['massa_total']?></td>
                <td><?=$data['organik']?></td>
                <td><?=$data['anorganik']?></td>
                <td><?=$data['residu']?></td>
                <td><?=$data['tanggal_masuk']?></td>
                <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#message<?php echo $data['id_sampah'];?>">Edit</button>
                <div id="message<?php echo $data['id_sampah'];?>" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="AddItemModalLabel">Edit Item </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="process.php" method="POST">
                            <div class="form-group">
                                <label for="formGroupExampleInput">Massa Total :</label>
                                <input hidden type="text" name="id" value="<?=$data['id_sampah']?>" id="formGroupExampleInput" placeholder=". . . Kg">
                                <input type="text" name="jumlah" value="<?=$data['massa_total']?>" class="form-control" id="formGroupExampleInput" placeholder=". . . Kg">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Sampah Organik :</label>
                                <input type="text" name="organik" value="<?=$data['organik']?>" class="form-control" id="formGroupExampleInput2" placeholder=". . . Kg">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Sampah Anorganik :</label>
                                <input type="text" name="anorganik" value="<?=$data['anorganik']?>" class="form-control" id="formGroupExampleInput2" placeholder=". . . Kg">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput2">Residu :</label>
                                <input type="text" name="residu" value="<?=$data['residu']?>" class="form-control" id="formGroupExampleInput2" placeholder=". . . Kg">
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="edit">Save changes</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                      </div>
                    </div>
                  </div>
                </div>
                <a class="btn btn-danger" href="process.php?delete=<?= $data['id_sampah'];?>" role="button">Delete</a>
                </td>
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
      <h1>Tabel Data Komposter</h1>
    </div>
    <div class="row mb-3">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddKomposModal">
        Add Items
      </button>
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
            <th scope="col">Action</th>
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
                <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#kompos<?php echo $data['id_kompos'];?>">Edit</button>
                <a class="btn btn-danger" href="process.php?deleteKompos=<?= $data['id_kompos'];?>" role="button">Delete</a>
                <div id="kompos<?php echo $data['id_kompos'];?>" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="AddKomposModalLabel">Tambahkan Item </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="process.php" method="POST">
                          <div class="form-group">
                          <input hidden type="text" name="id" value="<?=$data['id_kompos']?>" id="formGroupExampleInput" placeholder=". . . Kg">
                              <label for="formGroupExampleInput">Kondisi :</label>
                              <input type="text" name="kondisi" class="form-control" value="<?=$data['kondisi']?>" id="formGroupExampleInput" placeholder="Kondisi terakhir kompos">
                          </div>
                          <div class="form-group">
                              <label for="formGroupExampleInput2">Suhu :</label>
                              <input type="text" name="suhu" class="form-control" value="<?=$data['suhu']?>" id="formGroupExampleInput2" placeholder=". . . C">
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Keterangan :</label>
                            <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1" value="<?=$data['keterangan']?>" rows="3"></textarea>
                          </div>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" name="editKompos">Save changes</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </div>
                </div>
                </div>
                </td>
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
      <h1>Tabel Data Bank Sampah</h1>
    </div>
    <div class="row mb-3">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#BankSampahModal">
        Add Items
      </button>
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
            <th scope="col">Action</th>
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
                <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#daurUlang<?php echo $data['id'];?>">Edit</button>
                <a class="btn btn-danger" href="process.php?deleteDaurUlang=<?= $data['id'];?>" role="button">Delete</a>
                <div id="daurUlang<?php echo $data['id'];?>" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="BankSampahLabel">Tambahkan Item </h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="process.php" method="POST">
                          <div class="form-group">
                          <select name="kategori" class="form-control">
                            <option disabled selected>Default select</option>
                            <?php
                              foreach ($view as $row){
                                if ($row['id_kategori']==$data['id_kategori']){
                                  echo '<option value="'.$row['id_kategori'].'" selected>'.$row['nama_kategori'].'.</option>';
                                }else {
                                ?>
                                <option value="<?=$row['id_kategori'];?>"><?=$row['nama_kategori'];?></option>
                              <?php
                                }
                              }
                            ?>
                          </select>
                          </div>
                          <div class="form-group">
                          <input hidden type="text" name="id" value="<?=$data['id']?>" id="formGroupExampleInput" placeholder=". . . Kg">
                              <label for="formGroupExampleInput2">Jumlah :</label>
                              <input type="text" name="jumlah" value="<?=$data['jumlah']?>" class="form-control" id="formGroupExampleInput2"  placeholder=". . . ">
                          </div>
                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Keterangan :</label>
                            <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1"  rows="3"><?=$data['keterangan']?></textarea>
                          </div>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" name="editDaurUlang">Save changes</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                  </div>
                </div>
                </div>
                </td>
              </tr>
          <?php
            $i++;}
          ?>
        </tbody>
      </table>
    </div>
  </div>
    <!-- Modal Add-->
<div class="modal fade" id="AddItemModal" tabindex="-1" aria-labelledby="AddItemModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddItemModalLabel">Tambahkan Item </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="formGroupExampleInput">Massa Total :</label>
                <input type="text" name="jumlah" class="form-control" id="formGroupExampleInput" placeholder=". . . Kg">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Sampah Organik :</label>
                <input type="text" name="organik" class="form-control" id="formGroupExampleInput2" placeholder=". . . Kg">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Sampah Anorganik :</label>
                <input type="text" name="anorganik" class="form-control" id="formGroupExampleInput2" placeholder=". . . Kg">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Residu :</label>
                <input type="text" name="residu" class="form-control" id="formGroupExampleInput2" placeholder=". . . Kg">
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="save">Save changes</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
    <!-- Modal Add-->
<div class="modal fade" id="AddKomposModal" tabindex="-1" aria-labelledby="AddKomposLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddKomposModalLabel">Tambahkan Item </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">
            <div class="form-group">
                <label for="formGroupExampleInput">Kondisi :</label>
                <input type="text" name="kondisi" class="form-control" id="formGroupExampleInput"  placeholder="Kondisi terakhir kompos">
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Suhu :</label>
                <input type="text" name="suhu" class="form-control" id="formGroupExampleInput2"  placeholder=". . . C">
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Keterangan :</label>
              <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1"  rows="3"></textarea>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="saveKompos">Save changes</button>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
    <!-- Modal Add-->
<div class="modal fade" id="BankSampahModal" tabindex="-1" aria-labelledby="BankSampahLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="BankSampahLabel">Tambahkan Item </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="process.php" method="POST">
            <div class="form-group">
            <select name="kategori" class="form-control">
              <option disabled selected>Default select</option>
              <?php
                foreach ($view as $row){
                  ?>
                  <option value="<?=$row['id_kategori'];?>"><?=$row['nama_kategori'];?></option>
                <?php
                }
              ?>
            </select>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput2">Jumlah :</label>
                <input type="text" name="jumlah" class="form-control" id="formGroupExampleInput2"  placeholder=". . . ">
            </div>
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Keterangan :</label>
              <textarea class="form-control" name="keterangan" id="exampleFormControlTextarea1"  rows="3"></textarea>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="saveBankSampah">Save changes</button>
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