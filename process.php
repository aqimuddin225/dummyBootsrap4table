<?php

$mysqli = new mysqli('localhost', 'root', 'mypass', 'pengolahsampah') or die(mysqli_error($mysqli));

$id = '';

session_start();

if (isset($_POST['save'])){
    $weight = $_POST['jumlah'];
    $organik = $_POST['organik'];
    $anorganik = $_POST['anorganik'];
    $residu = $_POST['residu'];
    $tfix = date("Y-m-d",time());

    $_SESSION['message'] = "Record has been saved";
    $_SESSION['msg_type'] = "success";
    
    $mysqli->query("insert into sampah (massa_total, organik, anorganik, residu, tanggal_masuk) value ('$weight','$organik','$anorganik','$residu' , '$tfix')") or die($mysqli->error);
    header('Location: admin.php');
}
if (isset($_POST['saveKompos'])){
    $kondisi = $_POST['kondisi'];
    $suhu = $_POST['suhu'];
    $ket = $_POST['keterangan'];
    $tfix = date("Y-m-d",time());

    $_SESSION['message'] = "Record has been saved";
    $_SESSION['msg_type'] = "success";
    
    $mysqli->query("insert into komposter (tanggal,suhu,kondisi,keterangan) value ('$tfix','$suhu','$kondisi','$ket')") or die($mysqli->error);
    header('Location: admin.php');
}
if (isset($_POST['saveBankSampah'])){
    $kategori = $_POST['kategori'];
    $jumlah = $_POST['jumlah'];
    $ket = $_POST['keterangan'];
    $tfix = date("Y-m-d",time());

    $_SESSION['message'] = "Record has been saved";
    $_SESSION['msg_type'] = "success";
    
    $mysqli->query("insert into daurulang (tanggal,jumlah,id_kategori,keterangan) value ('$tfix','$jumlah','$kategori','$ket')") or die($mysqli->error);
    header('Location: admin.php');
}
if (isset($_POST['edit'])){
    $id = $_POST['id'];
    $weight = $_POST['jumlah'];
    $organik = $_POST['organik'];
    $anorganik = $_POST['anorganik'];
    $residu = $_POST['residu'];
    $tfix = date("Y-m-d",time());
    
        $_SESSION['message'] = "Record has been updated";
        $_SESSION['msg_type'] = "warning";
        
        $mysqli->query("update sampah set massa_total='$weight', organik='$organik', anorganik='$anorganik', residu='$residu', tanggal_masuk='$tfix' where id_sampah='$id' ") or die($mysqli->error);
        header('Location: admin.php');
    }
if (isset($_POST['editKompos'])){
    $id = $_POST['id'];
    $kondisi = $_POST['kondisi'];
    $suhu = $_POST['suhu'];
    $ket = $_POST['keterangan'];
    $tfix = date("Y-m-d",time());
    
        $_SESSION['message'] = "Record has been updated";
        $_SESSION['msg_type'] = "warning";
        
        $mysqli->query("update komposter set kondisi ='$kondisi', suhu='$suhu', keterangan='$ket' where id_kompos='$id' ") or die($mysqli->error);
        header('Location: admin.php');
    }
if (isset($_POST['editDaurUlang'])){
    $id = $_POST['id'];
    $jumlah = $_POST['jumlah'];
    $kategori = $_POST['kategori'];
    $tfix = date("Y-m-d",time());
    
        $_SESSION['message'] = "Record has been updated";
        $_SESSION['msg_type'] = "warning";
        
        $mysqli->query("update daurulang set jumlah ='$jumlah', id_kategori='$kategori', tanggal='$tfix' where id='$id' ") or die($mysqli->error);
        header('Location: admin.php');
    }
    if (isset($_GET['delete'])){
        $id = $_GET['delete'];
        
            $_SESSION['message'] = "Record has been deleted";
            $_SESSION['msg_type'] = "danger";
        
    $mysqli->query("delete from sampah where sampah.id_sampah = '$id'") or die($mysqli->error);
    header('Location: admin.php');
}
    if (isset($_GET['deleteKompos'])){
        $id = $_GET['deleteKompos'];
        
            $_SESSION['message'] = "Record has been deleted";
            $_SESSION['msg_type'] = "danger";
        
    $mysqli->query("delete from komposter where komposter.id_kompos = '$id'") or die($mysqli->error);
    header('Location: admin.php');
}
    if (isset($_GET['deleteDaurUlang'])){
        $id = $_GET['deleteDaurUlang'];
        
            $_SESSION['message'] = "Record has been deleted";
            $_SESSION['msg_type'] = "danger";
        
    $mysqli->query("delete from daurulang where daurulang.id = '$id'") or die($mysqli->error);
    header('Location: admin.php');
}
