    
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


          <div class="card mb-3">
            <div class="card-header">
    <?php
      include "../db_proses/koneksi.php";
      
      $org = $_COOKIE['idstaff_bill'];
      $nota = $_REQUEST['id'];      
      
      $query="SELECT * FROM tb_free_produk INNER JOIN tb_staff ON tb_staff.kode_staff=tb_free_produk.staff_fp 
      INNER JOIN tb_office ON tb_office.id_office=tb_free_produk.kantor_fp 
      WHERE tb_free_produk.id_fp='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $kantor=$baris['kantor_fp'];
    ?>
              <table>
                <tr>
                  <th>ID Nota </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_fp']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['waktu_fp'])); ?></td>
                </tr>
                <tr>
                  <th>Pegawai </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']; ?></td>
                </tr>
                <tr>
                  <th>Cabang </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_office']; ?></td>
                </tr>
              </table>                    
    <?php
      }
    ?> 
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Harga</th>
                      <th>Qty</th>
                      <th>Diskon</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;
      $cont=0;

      $query1="SELECT * FROM tb_detail_fp INNER JOIN tb_free_produk ON tb_free_produk.id_fp=tb_detail_fp.id_detfp 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_fp.produk_detfp 
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_fp.harga_detfp 
      WHERE tb_free_produk.id_fp='$nota'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
        $bayar=$bayar+$baris1['totjum_detfp'];
        $produk=$baris1['id_produk'];
        
        $query2="SELECT * FROM tb_gudang WHERE event_gudang='OFFICE' AND kode_office_gudang='PST' AND kode_produk_gudang='$produk'";
        $result2 = mysqli_query($kon, $query2);
    ?>
                    <tr>
                      <td><?php echo $baris1['id_produk']; ?></td>
                      <td><?php echo $baris1['nama_produk']; ?></td>
                      <td><?php echo rupiah($baris1['harga_harian']); ?></td>
                      <td><?php echo $baris1['jum_detfp']; ?></td>      
                      <td><?php echo rupiah($baris1['diskon_detfp']); ?></td>
                      <td><?php echo rupiah($baris1['totjum_detfp']); ?></td>
                    </tr>    
                    
    <?php
      }
    ?>             
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5">Total Bayar</th>
                      <th><?php echo rupiah($bayar); ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <form id="form-app" method="post">
                  <input type="hidden" name="nota" value="<?php echo $nota; ?>">
                  <button type="submit" class="btn btn-primary" name="cetak" data-id="<?php echo $nota; ?>" id="cetak">Cetak</button>       
                  <button type="submit" class="btn btn-danger" name="kembali" id="kembali" >Kembali</button>  
              </form> 
            </div>
          </div>

          
