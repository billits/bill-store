<?php
	session_start();
	
	if(!isset($_SESSION['id_pegawai'])){
		echo '<script language="javascript">alert("Anda harus Login!"); document.location="../login.php";</script>';
	}else {
		if($_SESSION['status_pegawai']!= "SuperAdmin"){
			echo '<script language="javascript">alert("Anda Tidak Memiliki Akses Login!"); document.location="../login.php";</script>';
		}
	}
?>