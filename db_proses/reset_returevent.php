<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$kode_nota= $_POST['kode_nota'];	
	$kode_pro= $_POST['kode_pro'];	
	$office = $_COOKIE["office_bill"];
	$staff = $_COOKIE["idstaff_bill"];

  if (empty($kode_nota)||empty($kode_pro)){
		$valid=1;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		$sqlre2= "SELECT * FROM tb_retur_event WHERE id_returevt = '$kode_nota'";
		$resultre2 = mysqli_query($kon,$sqlre2);	  
		$rowre2 = mysqli_fetch_array($resultre2,MYSQLI_ASSOC);
		$evt = $rowre2['event_returevt'];
		$office2 = $rowre2['kantor_returevt'];

		$sqlre1= "SELECT * FROM tb_detail_retur_event WHERE id_detretevt = '$kode_nota' AND produk_detretevt='$kode_pro'";
		$resultre1 = mysqli_query($kon,$sqlre1);	  
		$rowre1 = mysqli_fetch_array($resultre1,MYSQLI_ASSOC);
		$qty = $rowre1['jumret_detretevt'];

		$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$qty', supplier_gudang='$staff', staff_gudang='$staff', 
		tgl_update_gudang=NOW() WHERE kode_produk_gudang='$kode_pro' AND kode_office_gudang='$office2' AND event_gudang='$evt'";
		$resltt = mysqli_query($kon,$sli);

		$sql = "DELETE FROM tb_detail_retur_event WHERE id_detretevt='$kode_nota' AND produk_detretevt='$kode_pro'";
		$result = mysqli_query($kon,$sql);
		
		if(!$resltt) {    
			$cek=$cek+1;
		}
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
