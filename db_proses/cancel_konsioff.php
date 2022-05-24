<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	$count =0;
	// 1 - data kosong
	// 2 - sudah diproses
	
	$kode_nota= $_POST['kode_nota'];
	$staff = $_COOKIE['idstaff_bill'];
	
  if (empty($kode_nota)||empty($staff)){
		$valid=1;
	}
	
	$query = "SELECT * FROM tb_jual_konsi WHERE id_jk='$kode_nota'";
	$result = mysqli_query($kon, $query);
	$baris = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$kantor = $baris['kantor_jk'];
	$tgl_order = $baris['tgl_order_jk'];
	$status_order = $baris['status_jk'];

	if($status_order=='CANCEL'){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);

		$sql="SELECT * FROM tb_detail_jual_konsi WHERE nota_detjk='$kode_nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detjk'];
			$jum=$data['qty_detjk'];
			
			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='OFFICE'";
			$resltt = mysqli_query($kon,$sli);
	
			if(!$resltt) {    
				$cek=$cek+1;
			}			
		}	

  	$sql1 = "UPDATE tb_jual_konsi SET tgl_order_jk='$tgl_order', tgl_approv_jk=NOW(), status_jk='CANCEL' WHERE id_jk='$kode_nota'";
		$result1 = mysqli_query($kon,$sql1);
	
		if(!$result1) {    
			$cek=$cek+1;
		}	
		
		if ($cek==0){
			mysqli_commit($kon);
			$status['nilai']=1; //bernilai benar
			$status['error']="Data Berhasil Di Cancel";
		}else{          
			mysqli_rollback($kon);
			$status['nilai']=0; //bernilai salah
			$status['error']="Data Gagal Di Cancel";
    }
		mysqli_close($kon);
	}elseif($valid==1){
		$status['nilai']=0; //bernilai salah
    $status['error']="Inputan Tidak Boleh Kosong";
	}elseif($valid==2){
		$status['nilai']=0; //bernilai salah
		$status['error']="Sudah di Cancel"; 
	}
	
	echo json_encode($status);
?>
