<?php
	include "koneksi.php";
	
	$nota = $_GET['nota'];

	$query="SELECT * FROM jual INNER JOIN pegawai ON pegawai.id_pegawai=jual.counter_jual 
	INNER JOIN office ON office.id_office=jual.kantor_jual 
	WHERE jual.id_jual='$nota'";
	$result = mysqli_query($kon, $query);
	
	$arraydata = array();
	
	while($baris = mysqli_fetch_assoc($result)){
		$arraydata[] = $baris;
	}
	echo json_encode($arraydata);

?>
