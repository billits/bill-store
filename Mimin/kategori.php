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
            <li class="breadcrumb-item active">Kategori Produk </li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataKatProduk">          
          </div>


          <!-- Modal Popup untuk Tambah Data Kategori Produk--> 
          <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Tambah Data Kategori Produk</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Kode">Kode Kategori</label>
                      <input type="text" name="kode_kategori"  id="kode_kategori" class="form-control" placeholder="Kode Kategori" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Nama">Nama Kategori</label>
                      <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Nama Kategori" required/>
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

          <!-- Modal Popup untuk Edit Data Kategori Produk-->
          <div id="ModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Data Kategori Produk</h5>
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
        var datakat = "data_kategori.php";
        $('#DataKatProduk').load(datakat); 

        $('#form-tambah').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-tambah").serialize();
          $.ajax({
            url:"../db_proses/add_kategori.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#kode_kategori").val('');
                $("#nama_kategori").val('');
                $('#ModalAdd').modal('hide');
                $('#DataKatProduk').load(datakat);
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#edit',function(e){
          e.preventDefault();
          $("#ModalEdit").modal('show');
          $.post('edit_kategori.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-edit").html(html);
            }  
          );
        });
        
        $("#form-edit").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-edit").serialize();
          $.ajax({
            url: "../db_proses/update_kategori.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalEdit').modal('hide');
                $('#DataKatProduk').load(datakat);
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

