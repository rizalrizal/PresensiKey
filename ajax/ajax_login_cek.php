<?php
include "../koneksi.php";
session_start();
if($_GET['action'] == "cek_login"){
	$username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
	$salted = "87123yhejhagdsagsd7aw".$password."babsjhasbsbhhq13bjbj";
	$hashed = hash("sha512", $salted);
	$cekuser = "SELECT * FROM tbl_user WHERE username='$username' AND password='$hashed'";
	$stmt = $dbh->query($cekuser);
	$jmluser = $stmt->rowCount();
	$row = $stmt->fetchObject();
	if($jmluser > 0){
	   $_SESSION['username']     = $row->username;
	   $_SESSION['password']     = $row->password;
	   $_SESSION['nama']    	 = $row->nama;
	   $_SESSION['iduser']       = $row->id;

	   $_SESSION['timeout'] = time()+1000;
	   $_SESSION['login'] = 1;
	   echo "ok";
	}else{
	   echo "<b>Username</b> atau <b>password</b> tidak terdaftar!";
	}
}
?>