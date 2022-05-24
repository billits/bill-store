<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	session_start();
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['office'];
	$staff = $_POST['pegawai'];
	$acara = $_POST['event'];


	//copy addstorageoffice

  	if (empty($ketsup)){
		$status['nilai']=0; //bernilai salah
    	$status['error']="Keterangan Tidak Boleh Kosong";
	}else {
		$sl = "UPDATE beli_event SET total_beli_event='$total', keterangan_beli_event='$ketsup' WHERE id_beli_event='$nota'";
		$reslt = mysqli_query($kon,$sl);

		$sql="SELECT * FROM detail_beli_event WHERE nota_detbelev='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){

			$pro=$data['produk_detbelev'];
			$jum=$data['qty_detbelev'];
			$sqlre= "SELECT * FROM gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang ='$acara'";
			$resultre = mysqli_query($kon,$sqlre);
			$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
			$countre = mysqli_num_rows($resultre);
			
			if($countre == 1) {  
				$sli = "UPDATE gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='$acara'";
				$resltt = mysqli_query($kon,$sli);	
				$sli1 = "UPDATE gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='OFFICE'";
				$resltt1 = mysqli_query($kon,$sli1);
			}
			else{
				$squl = "INSERT INTO gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) VALUES 
				('$pro', '$kantor', '$jum', '$staff', '$staff', NOW(), '$acara')";
				$resuult = mysqli_query($kon,$squl);
				$squl1 = "UPDATE gudang SET jml_produk_gudang=jml_produk_gudang-'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='OFFICE'";
				$resuult1 = mysqli_query($kon,$squl1);
			}
		}		
		$status['nilai']=1; //bernilai benar
		$status['error']="Data Order Berhasil Ditambahkan di Gudang Event";
		$status['kode_nota']=$nota;
	}
	echo json_encode($status);
?>
