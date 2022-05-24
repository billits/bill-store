<?php
	session_start();
	
	if(!isset($_COOKIE['id_pegawai'])){
		echo '<script language="javascript">alert("Anda harus Login!"); document.location="../login.php";</script>';
	}else {
		if($_COOKIE['status_pegawai']!= "Event"){
			echo '<script language="javascript">alert("Anda Tidak Memiliki Akses Login!"); document.location="../login.php";</script>';
		}
	}
?>