    
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
      
      $query="SELECT * FROM tb_beli_event INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli_event.staff_beli_event
      INNER JOIN tb_office ON tb_office.id_office=tb_beli_event.kantor_beli_event 
      INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_beli_event.event_beli_event 
      WHERE tb_beli_event.id_beli_event='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
              <table>
                <tr>
                  <th>Kode </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_beli_event']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_beli_event'])); ?></td>
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
                <tr>
                  <th>Event </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_det_event']; ?></td>
                </tr>
                <tr>
                  <th>Keterangan </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['keterangan_beli_event']; ?></td>
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
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Harga</th>
                      <th>Qty</th>
                      <th>Stok</th>
                      <th>Total</th>
										  <th>Action</th>
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

      $query1="SELECT * FROM tb_detail_beli_event INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev 
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev 
      WHERE tb_beli_event.id_beli_event='$nota'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
        $bayar=$bayar+$baris1['total_jumlah_detbelev'];
        $produk=$baris1['id_produk'];
        
        $query2="SELECT * FROM tb_gudang WHERE event_gudang='OFFICE' AND kode_office_gudang='PST' AND kode_produk_gudang='$produk'";
        $result2 = mysqli_query($kon, $query2);
    ?>
                    <tr>
                      <td><?php echo $baris1['id_produk']; ?></td>
                      <td><?php echo $baris1['nama_produk']; ?></td>
                      <td><?php echo rupiah($baris1['harga_harian']); ?></td>
                      <td><?php echo $baris1['qty_detbelev']; ?></td>
      <?php

      while($baris2 = mysqli_fetch_assoc($result2)){
        if ($baris1['qty_detbelev'] > $baris2['jml_produk_gudang']){
          $cont=$cont+1;
        }
      ?>
                      <td><?php echo $baris2['jml_produk_gudang']; ?></td>
      <?php
      }
      ?>
                      <td><?php echo rupiah($baris1['total_jumlah_detbelev']); ?></td>
                      <td>
                        <a href="#" id="edit" class="btn btn-small text-primary" data-pdk="<?php echo $baris1['id_produk']; ?>" data-id="<?php echo $nota; ?>"><i class="fas fa-edit"></i> Edit </a>
                        <a href="#" id="hapus" class="btn btn-small text-danger" data-pdk="<?php echo $baris1['id_produk']; ?>" data-id="<?php echo $nota; ?>" data-jum="<?php echo $baris1['total_jumlah_detbelev']; ?>"><i class="fas fa-trash"></i> Hapus</a>
                      </td>
                    </tr>    
                    
    <?php
      }
    ?>             
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5">Total Bayar</th>
                      <th><?php echo rupiah($bayar); ?></th>
										  <th></th>
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
                  <input type="hidden" name="total" value="<?php echo $bayar; ?>">
                  <input type="hidden" name="cont" value="<?php echo $cont; ?>">
                  <input type="hidden" name="staff" value="<?php echo $org; ?>">
                  <button type="submit" class="btn btn-success" name="aprov" id="aprov">Approve</button>         
                  <button type="submit" class="btn btn-primary" name="cetak" data-id="<?php echo $nota; ?>" id="cetak">Cetak</button>       
                  <button type="submit" class="btn btn-danger" name="kembali" id="kembali" >Kembali</button>  
              </form> 
            </div>
          </div>

          
