<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$total = $_POST['total'];
	$nota = $_POST['nota'];
	$cont = $_POST['cont'];
	$staff = $_POST['staff'];

	//copy addstorageoffice

  	if ($cont!=0){
		$status['nilai']=0; //bernilai salah
    	$status['error']="Jumlah Order Produk Melebihi Stok Gudang";
	}else {
		$nota1 = str_replace("PO","NTJK",$nota);
		$sl = "UPDATE beli SET id_beli = '$nota1', status_beli='SUCCESS', total_beli='$total', supplier_beli='$staff' WHERE id_beli='$nota'";
		$reslt = mysqli_query($kon,$sl);

		$sql="SELECT * FROM detail_beli WHERE nota_detbeli='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){

			$pro=$data['produk_detbeli'];
			$jum=$data['qty_detbeli'];

			$sli = "UPDATE gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='PST' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);

			// $squl = "INSERT INTO temp_gudang (nota_temp, produk_temp, jml_temp, tgl_update_temp) VALUES 
			// ('$nota', '$pro', '$jum', NOW())";
			// $resuult = mysqli_query($kon,$squl);
			
		}	
		
		$s2 = "UPDATE detail_beli SET nota_detbeli='$nota1' WHERE nota_detbeli='$nota'";
		$reslt2 = mysqli_query($kon,$s2);

		$status['nilai']=1; //bernilai benar
		$status['error']="Data PO Berhasil Di Approve";
	}
	echo json_encode($status);
?>
