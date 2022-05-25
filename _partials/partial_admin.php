<?php

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
        </a>
      </li>
      <li class='nav-item dropdown no-arrow'>
        <a class='nav-link dropdown-toggle' href='#' id='userDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
          <i class='fas fa-user-circle fa-fw'></i>
        </a>
        <div class='dropdown-menu dropdown-menu-right' aria-labelledby='userDropdown'>
          <a class='dropdown-item' href='profil.php'>Profil</a>
          <div class='dropdown-divider'></div>
          <a class='dropdown-item' href='#' data-toggle='modal' data-target='#logoutModal'>Logout</a>
        </div>
      </li>
    </ul>
    
    </nav>";
	
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



$topside = "<!-- Sidebar -->
<ul class='sidebar navbar-nav'>
  <li class='nav-item active'>
    <a class='nav-link' href='home.php'>
      <i class='fas fa-fw fa-tachometer-alt'></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class='nav-item'>
    <a class='nav-link' href='user.php'>
      <i class='fas fa-fw fa-user'></i>
      <span>Pegawai</span></a>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='far fa-building'></i>
      <span>Office</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='office.php'>Office</a>
      <a class='dropdown-item' href='region.php'>Region Office</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
    <i class='far fa-clipboard'></i>
      <span>Events</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='events.php'>Event</a>
      <a class='dropdown-item' href='det_events.php'>Detail Event</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-fw fa-layer-group'></i>
      <span>Produk</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='produk.php'>Produk</a>
      <a class='dropdown-item' href='paketproduk.php'>Paket Produk</a>
      <a class='dropdown-item' href='kategori.php'>Kategori Produk</a>
      <a class='dropdown-item' href='storagecabang.php'>Gudang Produk</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-folder-minus'></i>
      <span>Lap. BTB</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='lp_btb_off.php'>Lp. BTB Office</a>
      <a class='dropdown-item' href='lp_btb_evt.php'>Lp. BTB Event</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
      <i class='fas fa-folder-minus'></i>
      <span>Lap. BTR</span>
    </a>
    <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
      <a class='dropdown-item' href='lp_btr_off.php'>Lp. BTR Office</a>
      <a class='dropdown-item' href='lp_btr_evt.php'>Lp. BTR Event</a>
    </div>
  </li>
  <li class='nav-item'>
    <a class='nav-link' href='lp_free_pdk.php'>
      <i class='fas fa-folder-minus'></i>
      <span>Lp. Free Produk</span>
    </a>
  </li>
  <li class='nav-item'>
    <a class='nav-link' href='lp_restok.php'>
      <i class='fas fa-folder-minus'></i>
      <span>Lp. ReStok Gudang</span>
    </a>
  </li>

</ul>";

// <li class='nav-item'>
// <a class='nav-link dropdown-toggle' href='#' id='pagesDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
//   <i class='fas fa-folder-minus'></i>
//   <span>Report Control</span>
// </a>
// <div class='dropdown-menu' aria-labelledby='pagesDropdown'>
//   <a class='dropdown-item' href='#'>Lp. Transaksi Per Item</a>
//   <a class='dropdown-item' href='#'>Lp. Transaksi Office</a>
//   <a class='dropdown-item' href='#'>Lp. Transaksi Event</a>
// </div>
// </li>

?>