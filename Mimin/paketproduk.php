<?php
  include ('akses.php');
  include ('../_partials/partial_admin.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
  </head>


  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Paket Produk</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataProduk">
          </div>

          <!-- Modal Popup untuk Edit Data Produk-->
          <div id="ModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Paket Produk</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-edit">
                    </div>             
                  </div>
                  <div class="modal-footer">                  
                    <button class="btn btn-success" id="btn-save" type="submit">Simpan</button>
                    <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                  </div>
                </form>    
              </div>
            </div>
          </div>

          <!-- Modal Popup untuk Detail Data Produk-->
          <div id="ModalDetail" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-det">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Detail Paket Produk</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-detail">
                    </div>             
                  </div>
                  <div class="modal-footer">                  
                    <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Kembali</button>
                  </div>
                </form>    
              </div>
            </div>
          </div>

<!-- Modal Popup untuk Set Harga Data Produk-->
<div id="ModalSet" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="form-set">
        <div class="modal-header">
          <h5 class='modal-title' id='exampleModalLabel'>Set Paket Produk</h5>
          <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="data-set">
          </div>             
        </div>
        <div class="modal-footer">                  
          <button class="btn btn-success" id="btn-save" type="submit">Simpan</button>
          <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
        </div>
      </form>    
    </div>
  </div>
</div>


        </div>
        <!-- /.container-fluid -->

        <?php
          echo $footer;
        ?>
        
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php
      echo $logout;
    ?>

    <?php
      echo $csjs2;
    ?>

    <script type="text/javascript">
      $(document).ready(function(){
        var datapro = "data_paket.php";
        $('#DataProduk').load(datapro); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          $("#ModalDetail").modal('show');
          $.post('detail_paket.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-detail").html(html);
            }  
          );
        });

        $(document).on('click','#setharga',function(e){
          e.preventDefault();
          $("#ModalSet").modal('show');
          $.post('set_paket.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-set").html(html);
            }  
          );
        });
        
        $("#form-set").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-set").serialize();
          $.ajax({
            url: "../db_proses/set_paket_produk.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalSet').modal('hide');
                $('#DataProduk').load(datapro);
              }else{
                alert(obj.error); 
              }
            }
          });
        });
      })
    </script>

  </body>
  
</html>

