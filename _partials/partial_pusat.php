<?php
  include "../db_proses/koneksi.php";

  $kantor=$_COOKIE["office_bill"];

  $jml_data=0;
  $menu1="";
  $menu2="";
  $menu3="";

  $sql="SELECT * FROM tb_po INNER JOIN tb_staff ON tb_staff.kode_staff=tb_po.staff_po 
  INNER JOIN tb_office ON tb_office.id_office=tb_po.kantor_po 
  WHERE tb_po.event_po='OFFICE' AND tb_po.status_po='REQUEST' AND tb_po.kantor_po!='$kantor' AND tb_po.total_po!=0";
  $ss=mysqli_query($kon,$sql);
  $jml_data1=mysqli_num_rows($ss);

  $sql2="SELECT * FROM tb_beli_event WHERE tb_beli_event.stat_beli_event='REQUEST' AND total_beli_event!='0'";
  $ss2=mysqli_query($kon,$sql2);
  $jml_data2=mysqli_num_rows($ss2);

  $sql3="SELECT * FROM tb_retur_event WHERE event_returevt='OFFICE' AND status_returevt='PENDING' AND total_returevt!='0'";
  $ss3=mysqli_query($kon,$sql3);
  $jml_data3=mysqli_num_rows($ss3);

  $jml_data=$jml_data1+$jml_data2+$jml_data3;

  if ($jml_data!=0){
    $notif="<span class='badge badge-danger'>".$jml_data."</span>";
    if ($jml_data1!=0){
      $menu1="<a class='dropdown-item' href='../PST/inboxpo.php'>PO Cabang</a>";
    }
    if($jml_data2!=0){
      $menu2="<a class='dropdown-item' href='../PST/inboxpoevt.php'>PO Event</a>";
    }
    if($jml_data3!=0){
      $menu3="<a class='dropdown-item' href='../PST/inboxru.php'>Retur Cabang</a>";
    }
    
    $menu="<div class='dropdown-menu dropdown-menu-right' aria-labelledby='alertsDropdown'>
    ".$menu1.$menu2.$menu3."
    </div>";

  }else{
    $notif="";
    $menu="";
  }


$csjs1= "<meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>    
    <meta name='description' content='Billionaires Store'>
    <meta name='author' content='KiiGeeks'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='../img/favcon.png'>

    <title>BillStore - ".$_COOKIE["status_bill"]."</title>

    <!-- Bootstrap core CSS-->
    <link href='../vendor/bootstrap/css/bootstrap.min.css' rel='stylesheet'>

    <!-- Custom fonts for this template-->
    <link href='../vendor/fontawesome-free/css/all.min.css' rel='stylesheet' type='text/css'>

    <!-- Page level plugin CSS-->
    <link href='../vendor/datatables/dataTables.bootstrap4.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href='../css/sb-admin.css' rel='stylesheet'>";
	
$csjs2= "    <!-- Bootstrap core JavaScript-->
    <script src='../vendor/jquery/jquery.min.js'></script>
    <script src='../vendor/bootstrap/js/bootstrap.bundle.min.js'></script>

    <!-- Core plugin JavaScript-->
    <script src='../vendor/jquery-easing/jquery.easing.min.js'></script>

    <!-- Page level plugin JavaScript-->
    <script src='../vendor/chart.js/Chart.min.js'></script>
    <script src='../vendor/datatables/jquery.dataTables.js'></script>
    <script src='../vendor/datatables/dataTables.bootstrap4.js'></script>

    <!-- Custom scripts for all pages-->
    <script src='../js/sb-admin.min.js'></script>

    <!-- Demo scripts for this page-->
    <script src='../js/demo/datatables-demo.js'></script>
    <script src='../js/demo/chart-area-demo.js'></script>

    <!-- Konfirmasi/Alert Box-->
    <script src='../vendor/bootbox.min.js'></script>";

$footer= "<!-- Sticky Footer -->
<footer class='sticky-footer'>
  <div class='container my-auto'>
    <div class='copyright text-center my-auto'>
      <span>Copyright © Billionaires Indonesia ".date('Y')."</span>
    </div>
  </div>
</footer>";

$logout="<div class='modal fade' id='logoutModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
<div class='modal-dialog' role='document'>
  <div class='modal-content'>
    <div class='modal-header'>
      <h5 class='modal-title' id='exampleModalLabel'>Informasi</h5>
      <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>
    <div class='modal-body'>Anda Yakin Ingin Logout?</div>
    <div class='modal-footer'>
      <button class='btn btn-secondary' type='button' data-dismiss='modal'>Batal</button>
      <a class='btn btn-primary' href='../logout.php'>Logout</a>
    </div>
  </div>
</div>
</div>";

$topnav= "<nav class='navbar navbar-expand navbar-dark bg-dark static-top'>
<a class='navbar-brand mr-1' href='home.php'>BillStore</a>
<button class='btn btn-link btn-sm text-white order-1 order-sm-0' id='sidebarToggle' href='#'>
  <i class='fas fa-bars'></i>
</button>

<!-- Navbar Search -->
<form class='d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0'>
  
</form>

<!-- Navbar -->
<ul class='navbar-nav ml-auto ml-md-0'>
  <li class='nav-item dropdown no-arrow mx-1'>
    <a class='nav-link dropdown-toggle' href='#' id='alertsDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-bell fa-fw'></i>   
      ".$notif."
    </a>
    ".$menu."
  </li>
  <li class='nav-item dropdown no-arrow'>
    <a class='nav-link dropdown-toggle' href='#' id='userDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-user-circle fa-fw'></i>
    </a>
    <div class='dropdown-menu dropdown-menu-right' aria-labelledby='userDropdown'>
      <a class='dropdown-item' href='../PST/profil.php'>Profil</a>
      <div class='dropdown-divider'></div>
      <a class='dropdown-item' href='#' data-toggle='modal' data-target='#logoutModal'>Logout</a>
    </div>
  </li>
</ul>

</nav>";

$topside = "<!-- Sidebar -->
<ul class='sidebar navbar-nav'>
  <li class='nav-item active'>
    <a class='nav-link' href='home.php'>
      <i class='fas fa-fw fa-tachometer-alt'></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-inbox'></i>
      <span>Inbox</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='inboxpo.php'>PO Cabang</a>
      <a class='dropdown-item' href='inboxpoevt.php'>PO Event</a>
      <a class='dropdown-item' href='inboxru.php'>Retur Cabang</a>
    </div>
  </li>
  <li class='nav-item active'>
    <a class='nav-link' href='events.php'>
      <i class='far fa-clipboard'></i>
      <span>Events</span></a>
    </a>
  </li>
  <li class='nav-item active'>
    <a class='nav-link' href='restok.php'>
      <i class='fas fa-sign-in-alt'></i>
      <span>ReStok Gudang</span></a>
    </a>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-fw fa-layer-group'></i>
      <span>Produk</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='produk.php'>Produk</a>
      <a class='dropdown-item' href='pro_free.php'>Free Produk</a>
      <a class='dropdown-item' href='paketproduk.php'>Paket Produk</a>
      <a class='dropdown-item' href='kategori.php'>Kategori Produk</a>
      <a class='dropdown-item' href='storageoffice.php'>G. ".$_COOKIE["office_bill"]."</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fa fa-recycle'></i>
      <span>Retur</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
    <a class='dropdown-item' href='ru_evt.php'>Retur Event</a>
      <a class='dropdown-item' href='ru_sup.php'>Retur Supplier</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fa fa-users'></i>
      <span>Cabang</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='storagecabang.php'>Gudang Cabang</a>
      <a class='dropdown-item' href='konsi_cabang.php'>Konsi Gudang Cabang</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-folder-minus'></i>
      <span>Report Control</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='lp_restok.php'>Lp. ReStok</a>
      <a class='dropdown-item' href='lp_pst.php'>Lp. Pusat</a>
      <a class='dropdown-item' href='lp_off.php'>Lp. BTB Office</a>
      <a class='dropdown-item' href='lp_cabang.php'>Lp. BTB Cabang</a>
      <a class='dropdown-item' href='lp_evt.php'>Lp. BTB Event Pusat</a>
      <a class='dropdown-item' href='pu_btb.php'>Print Ulang BTB</a>
      <a class='dropdown-item' href='pu_ru_evt.php'>Print Retur Event</a>
      <a class='dropdown-item' href='pu_ru_sup.php'>Print Retur Supplier</a>
      <a class='dropdown-item' href='pu_off.php'>Print Konsi Office</a>
      <a class='dropdown-item' href='pu_evt.php'>Print Konsi Event</a>
    </div>
  </li>
</ul>";

?>