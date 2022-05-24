
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
          
          $kantor = $_COOKIE['office_bill'];
          $evt = $_GET['evt'];
          $laku = 0;
          $fisik = 0;

          $sqlev= "SELECT * FROM tb_detail_events 
          WHERE id_det_event='$evt'";
          $resultev = mysqli_query($kon,$sqlev);
          $rowev = mysqli_fetch_array($resultev,MYSQLI_ASSOC);

        ?>
              Stok Produk Event <?php echo $rowev['nama_det_event'] ?>
            </div>  

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
                      <th>kategori</th>
                      <th>Stok</th>
                      <th>Laku</th>
                      <th>Fisik</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
                      <th>kategori</th>
                      <th>Stok</th>
                      <th>Laku</th>
                      <th>Fisik</th>  
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
        
        $query="SELECT * FROM tb_gudang INNER JOIN tb_produk ON tb_produk.id_produk=tb_gudang.kode_produk_gudang   
        INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_gudang.event_gudang 
        INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk WHERE tb_gudang.kode_office_gudang='$kantor' 
        AND tb_gudang.event_gudang='$evt'";
        $result = mysqli_query($kon, $query);
        
        while($baris = mysqli_fetch_assoc($result)){
          $pdk_tmp=$baris['id_produk'];
          $temp_jum=0;
          $sql3= "SELECT * FROM tb_detail_jual 
            INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
            INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual.produk_detjual
            WHERE tb_detail_jual.produk_detjual='$pdk_tmp' AND tb_jual.kantor_jual='$kantor' AND tb_jual.acara_jual='$evt' AND tb_jual.status_jual='PENDING'";
          $result3 = mysqli_query($kon,$sql3);
          while($row3 = mysqli_fetch_assoc($result3)){
            $temp_jum = $temp_jum + $row3['qty_detjual'];
          }
          $final_jml = $baris['jml_produk_gudang']+$temp_jum;
          $laku = $temp_jum;
          $fisik = $baris['jml_produk_gudang'];
    ?>
                    <tr>
                      <td><?php echo $baris['kode_produk_gudang']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $baris['nama_kategori']; ?></td>
                      <td><?php echo $final_jml; ?></td> 
                      <td><?php echo $laku; ?></td>
                      <td><?php echo $fisik; ?></td>
                    </tr>              
    <?php
      }
    ?>                
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <a href="#" class="btn btn-danger" id="kembali">              
                Kembali
              </a>
            </div> 