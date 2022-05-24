<?php
	include "koneksi.php";
	
	if(isset($_POST["submit"])) {

    $uname=$_POST['inputEmail'];
    $upwd=$_POST['inputPassword'];
    $akses=$_POST['akses'];

    $sql = "SELECT * FROM tb_staff 
    INNER JOIN tb_office ON tb_office.id_office = tb_staff.office_staff 
    INNER JOIN tb_akses ON tb_akses.staff_akses = tb_staff.kode_staff
    WHERE tb_staff.uname_staff = '$uname' AND tb_staff.pass_staff = '$upwd' AND tb_akses.status_akses = '$akses' AND tb_staff.active_staff = 'ON'";
    $result = mysqli_query($kon,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
      
	  if($count == 1) {      
      $cookie_id_pegawai =  $row['kode_staff'];
      $cookie_id_office =  $row['id_office'];
      $cookie_status_pegawai =  $row['status_akses'];
      $cookie_region =  $row['region_office'];

      setcookie("idstaff_bill", $cookie_id_pegawai, time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie("office_bill", $cookie_id_office, time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie("status_bill", $cookie_status_pegawai, time() + (86400 * 30), "/"); // 86400 = 1 day
      setcookie("region_bill", $cookie_region, time() + (86400 * 30), "/"); // 86400 = 1 day

      // if($row["status_pegawai"]=="SuperAdmin"){
      //   header("location:../SA/home.php");
      // }else if($row["status_pegawai"]=="Admin"){
      //   header("location:../Mimin/home.php");
      // }else if($row["status_pegawai"]=="GudangPusat"){
      //   header("location:../PST/home.php");
      // }else if($row["status_pegawai"]=="PICCounter"){
      //   header("location:../PIC/home.php");
      // }else if($row["status_pegawai"]=="Counter"){
      //   header("location:../Counter/home.php");
      // }else if($row["status_pegawai"]=="Gudang"){
      //   header("location:../Gudang/home.php");
      // }else if($row["status_pegawai"]=="Event"){
      //   header("location:../EVT/home.php");
      // }

      
      if($akses=="PUSAT"){
        header("location:../PST/home.php");
      }elseif($akses=="SUPERADMIN"){
        header("location:../SA/home.php");
      }elseif($akses=="ADMIN"){
        header("location:../Mimin/home.php");
      }elseif($akses=="HEAD"){
        header("location:../PIC/home.php");
      }else if($akses=="COUNTER"){
        header("location:../Counter/home.php");
      }else if($akses=="GUDANG"){
        header("location:../Gudang/home.php");
      }
		}else{			
			echo "<script>alert ('ID & Password Belum Terdaftar, Silahkan Hubungi Admin');
						window.location.href='../login.php';</script>";
		}
  }
?>
