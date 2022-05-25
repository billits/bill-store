<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	// 1 - data kosong
	
	$total = $_POST['bayar'];
	$nota = $_POST['nota'];
	$ketsup = $_POST['ket'];
	$kantor = $_POST['offc'];
	$staff = $_POST['pegawai'];

  if (empty($total)||empty($nota)||empty($ketsup)||empty($kantor)||empty($staff)){
		$valid=1;
	}
	
	$sql_tmp= "SELECT * FROM tb_restok WHERE id_restok= '$nota'";
  $result_tmp = mysqli_query($kon,$sql_tmp);
  $row_tmp = mysqli_fetch_array($result_tmp,MYSQLI_ASSOC);
	$waktu = $row_tmp['tgl_restok'];

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sl = "UPDATE tb_restok SET total_restok='$total', kantor_restok='$kantor', tgl_restok='$waktu', status_restok='APPROVE', keterangan_restok='$ketsup' 
						WHERE id_restok='$nota' AND status_restok='PENDING' AND event_restok='OFFICE'";
		$reslt = mysqli_query($kon,$sl);

		$sql="SELECT * FROM tb_detail_restok WHERE nota_detrestok='$nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){

			$pro=$data['produk_detrestok'];
			$jum=$data['qty_detrestok'];
			$sqlre= "SELECT * FROM tb_gudang WHERE kode_office_gudang='$kantor' AND kode_produk_gudang='$pro' AND event_gudang ='OFFICE'";
			$resultre = mysqli_query($kon,$sqlre);
			$rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
			$countre = mysqli_num_rows($resultre);
			
			if($countre == 1) {  
				$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' and kode_office_gudang='$kantor' and event_gudang='OFFICE'";
				$resltt = mysqli_query($kon,$sli);
			}
			else{
				$squl = "INSERT INTO tb_gudang (kode_produk_gudang, kode_office_gudang, jml_produk_gudang, supplier_gudang, staff_gudang, tgl_update_gudang, event_gudang) VALUES 
				('$pro', '$kantor', '$jum', '$staff', '$staff', NOW(), 'OFFICE')";
				$resltt = mysqli_query($kon,$squl);
			}
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}		

		if(!$reslt) {    
			$cek=$cek+1;
		}
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Orderan Berhasil Ditambahkan";
			$status['nota_id']=$nota;
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Ditambah";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}
	echo json_encode($status);
?>
