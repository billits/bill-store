<?php
	include "koneksi.php";
	$jum=0;
	$jum1=0;
	$query="SELECT * FROM produk";
    $result = mysqli_query($kon, $query);
      
    while($baris = mysqli_fetch_assoc($result)){
		$kode=$baris['id_produk'];

		$sqlre= "SELECT * FROM gudang WHERE kode_produk_gudang= '$kode'";
		$resultre = mysqli_query($kon,$sqlre);
		$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
		$countre = mysqli_num_rows($resultre);
		
		if($countre == 0) {				     
			$sql = "INSERT INTO gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) 
			SELECT '$kode', off.id_office, '0', '$staff', '$staff', NOW(), 'OFFICE'
			FROM office off";
			$rest = mysqli_query($kon,$sql);   
			
			$jum1=$jum1+1; 
		}
		else{
			$jum1=$jum1+1;
		}
	}
	echo "Data Baru :".$jum;
	echo "<br>";
	echo "Data Lama :".$jum1;
?>
