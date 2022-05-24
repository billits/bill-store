
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
              <i class="fas fa-fw fa-layer-group"></i> Stok Produk Gudang Event <?php session_start(); echo $_COOKIE['nama_office']; ?> 
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>kategori Produk</th>
                      <th>Stok Produk</th>
                      <th>Produk Laku</th>
                      <th>Produk Fisik</th>
                      <th>Event</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>kategori Produk</th>
                      <th>Stok Produk</th>
                      <th>Produk Laku</th>
                      <th>Produk Fisik</th>
                      <th>Event</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      function rupiah($angka) {
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      
      $reg = $_COOKIE['region'];
      $kantor = $_COOKIE['id_office'];
      
      $laku = 0;
      $fisik = 0;

      $query="SELECT * FROM gudang INNER JOIN produk ON produk.id_produk=gudang.kode_produk_gudang   
      INNER JOIN detail_events ON detail_events.id_det_event=gudang.event_gudang 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk WHERE gudang.kode_office_gudang='$kantor' 
      AND gudang.event_gudang!='OFFICE'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $pdk_tmp=$baris['id_produk'];
        $evt_tmp=$baris['id_det_event'];

        $sql1= "SELECT * FROM paket_produk WHERE det_produk='$pdk_tmp' AND status_paket='ON'";
        $result1 = mysqli_query($kon,$sql1);
        $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
        $count1 = mysqli_num_rows($result1);

        if ($count1>=1){
          $temp_jum=0;
          $paket=$row1['produk_paket'];
          $jum_pro_paket=$row1['jum_pro_paket'];

          $sql2= "SELECT * FROM temp_jual_event 
          INNER JOIN jual ON jual.id_jual=temp_jual_event.nota_jual_temp  
          WHERE temp_jual_event.produk_temp='$paket' AND temp_jual_event.kantor_temp='$kantor' AND jual.acara_jual='$evt_tmp' AND temp_jual_event.status_temp='BELUM'";
          $result2 = mysqli_query($kon,$sql2);          
          $count2 = mysqli_num_rows($result2);

          if ($count2>=1){
            while($row2 = mysqli_fetch_assoc($result2)){
              $temp_jum = $jum_pro_paket * $row2['jml_pdk_temp'];
            }
          }
          
          $sql3= "SELECT * FROM temp_jual_event 
          INNER JOIN jual ON jual.id_jual=temp_jual_event.nota_jual_temp 
          INNER JOIN produk ON produk.id_produk=temp_jual_event.produk_temp
          WHERE temp_jual_event.produk_temp='$pdk_tmp' AND temp_jual_event.kantor_temp='$kantor' AND jual.acara_jual='$evt_tmp' AND temp_jual_event.status_temp='BELUM'";
          $result3 = mysqli_query($kon,$sql3);
            
          while($row3 = mysqli_fetch_assoc($result3)){
            $temp_jum = $temp_jum + $row3['jml_pdk_temp'];
          }
          $final_jml = $baris['jml_produk_gudang']+$temp_jum;
          $laku = $temp_jum;
          $fisik = $baris['jml_produk_gudang'];
            
        }else{
          $temp_jum=0;
          $sql3= "SELECT * FROM temp_jual_event 
          INNER JOIN jual ON jual.id_jual=temp_jual_event.nota_jual_temp 
          INNER JOIN produk ON produk.id_produk=temp_jual_event.produk_temp
          WHERE temp_jual_event.produk_temp='$pdk_tmp' AND temp_jual_event.kantor_temp='$kantor' AND jual.acara_jual='$evt_tmp' AND temp_jual_event.status_temp='BELUM'";
          $result3 = mysqli_query($kon,$sql3);
          while($row3 = mysqli_fetch_assoc($result3)){
            $temp_jum = $temp_jum + $row3['jml_pdk_temp'];
          }
          $final_jml = $baris['jml_produk_gudang']+$temp_jum;
          $laku = $temp_jum;
          $fisik = $baris['jml_produk_gudang'];
        }
    ?>
                    <tr>
                      <td><?php echo $baris['kode_produk_gudang']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $baris['nama_kategori']; ?></td>
                      <?php
                        if ($baris['id_kategori']=="PKT"){
                      ?>
                        <td>~</td> 
                      <?php
                        }else{
                      ?>
                        <td><?php echo $final_jml; ?></td> 
                      <?php
                        }
                      ?>
                      <td><?php echo $laku; ?></td>
                      <td><?php echo $fisik; ?></td>
                      <td><?php echo $baris['nama_det_event']; ?></td> 
                    </tr>              
    <?php
      }
    ?>             
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          