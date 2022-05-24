<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$staff = $_COOKIE["idstaff_bill"];
	// $office = $_COOKIE['office_bill'];
	$kode_nota= $_REQUEST['kode_nota'];

  if (empty($kode_nota)||empty($staff)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sqlre2= "SELECT * FROM tb_retur_event WHERE id_returevt = '$kode_nota'";
		$resultre2 = mysqli_query($kon,$sqlre2);	  
		$rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);
		$evt = $rowre2['event_returevt'];
		$office2 = $rowre2['kantor_returevt'];

		$sql3= "SELECT * FROM tb_detail_retur_event 
			INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_retur_event.produk_detretevt 
			WHERE tb_detail_retur_event.id_detretevt='$kode_nota'";
		$result3 = mysqli_query($kon,$sql3);
		while($baris3 = mysqli_fetch_assoc($result3)){
			$qty = $baris3['jumret_detretevt'];
			$kode_pro = $baris3['produk_detretevt'];

			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$qty', supplier_gudang='$staff', staff_gudang='$staff', 
			tgl_update_gudang=NOW() WHERE kode_produk_gudang='$kode_pro' AND kode_office_gudang='$office2' AND event_gudang='$evt'";
			$resltt = mysqli_query($kon,$sli);
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}

		$sql1 = "DELETE FROM tb_retur_event WHERE id_returevt='$kode_nota'";
		$result1 = mysqli_query($kon,$sql1);	
		if(!$result1) {    
			$cek=$cek+1;
		}	

		$sql = "DELETE FROM tb_detail_retur_event WHERE id_detretevt='$kode_nota'";
		$result = mysqli_query($kon,$sql);
		if(!$result) {    
			$cek=$cek+1;
		}
	
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Dihapus";	
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Dihapus";
		}
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
		$status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
