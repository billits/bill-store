<?php
	session_start();
	
	if(!isset($_COOKIE['idstaff_bill'])){
		echo '<script language="javascript">alert("Anda harus Login!"); document.location="../login.php";</script>';
	}else {
		if($_COOKIE['status_bill']!= "COUNTER"){
			echo '<script language="javascript">alert("Anda Tidak Memiliki Akses Login!"); document.location="../login.php";</script>';
		}
	}
?>