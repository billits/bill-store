<?php
	include "koneksi.php";
	date_default_timezone_set('Asia/Jakarta');
	
	$cek=0;
	$valid=0;
	$count =0;
	// 1 - data kosong
	// 2 - sudah diproses

	$kode_nota= $_POST['nota'];
	$staff = $_COOKIE['idstaff_bill'];
	
  if (empty($kode_nota)||empty($staff)){
		$valid=1;
	}

	$query = "SELECT * FROM tb_jual WHERE id_jual='$kode_nota'";
	$result = mysqli_query($kon, $query);
	$baris = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$count = mysqli_num_rows($result);

	$acara = $baris['acara_jual'];
	$kantor = $baris['kantor_jual'];
	$tgl_order = $baris['tgl_order_jual'];
	$status_order = $baris['status_jual'];

	if($status_order=='CANCEL'){
		$valid=2;
	}

	if ($valid==0){
		mysqli_autocommit($kon, false);
		
		$sql="SELECT * FROM tb_detail_jual 
		INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual.produk_detjual 
		INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
		WHERE tb_detail_jual.nota_detjual='$kode_nota'";
		$ss=mysqli_query($kon,$sql);
		while($data=mysqli_fetch_array($ss)){
			$pro=$data['produk_detjual'];
			$jum=$data['qty_detjual'];
			
			$sli = "UPDATE tb_gudang SET jml_produk_gudang=jml_produk_gudang+'$jum', supplier_gudang='$staff', staff_gudang='$staff', 
					tgl_update_gudang=NOW() WHERE kode_produk_gudang='$pro' AND kode_office_gudang='$kantor' AND event_gudang='$acara'";
			$resltt = mysqli_query($kon,$sli);
	
			if(!$resltt) {    
				$cek=$cek+1;
			}
		}	

  	$sql1 = "UPDATE tb_jual SET tgl_order_jual='$tgl_order', tgl_approv_jual=NOW(), status_jual='CANCEL' WHERE id_jual='$kode_nota'";
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
