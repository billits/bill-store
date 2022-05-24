<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];

	//copy addstorageoffice

  	if (empty($ketsup)){
		$status['nilai']=0; //bernilai salah
    	$status['error']="Keterangan Tidak Boleh Kosong";
	}else {
		$sl = "UPDATE beli SET total_beli='$total', supplier_beli='$staff', 
		tgl_approv_beli=NOW(), counter_beli='$staff', keterangan_beli='$ketsup' 
		WHERE id_beli='$nota' AND status_beli='APPROVE' AND event_beli='OFFICE'";
		$reslt = mysqli_query($kon,$sl);

		$sql="select * from detail_beli where nota_detbeli='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){

			$pro=$data['produk_detbeli'];
			$jum=$data['qty_detbeli'];
			$sqlre= "SELECT * FROM gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang ='OFFICE'";
			$resultre = mysqli_query($kon,$sqlre);
			$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
			$countre = mysqli_num_rows($resultre);
			
			if($countre == 1) {  
			$sli = "update gudang set jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() where kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);
			}
			else{
			$squl = "INSERT INTO gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) VALUES 
			('$pro', '$kantor', '$jum', '$staff', '$staff', NOW(), 'OFFICE')";
			$resuult = mysqli_query($kon,$squl);
			}
		}		
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Orderan Berhasil Ditambahkan";
	}
	echo json_encode($status);
?>
