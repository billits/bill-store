<?php
  include ('akses.php');
  include ('../_partials/partial_sa.php');
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
            <li class="breadcrumb-item active"> Produk</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataProduk">
          </div>

          <!-- Modal Popup untuk Tambah Data Produk--> 
          <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Tambah Data Produk</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Produk*</label>
                      <input class="form-control" type="text" name="kode_produk" id="kode_produk" placeholder="Kode Produk" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Produk*</label>
                      <input class="form-control" type="text" name="nama_produk" id="nama_produk" placeholder="Nama Produk" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori">Kategori Produk*</label>
                      <select class="form-control" name="kategori_produk" id="kategori_produk">
                        <option value="">Pilih Kategori Produk</option>
    <?php
      $sumber = "http://localhost/BillServer/data_kategori.php";
      $konten = file_get_contents($sumber);
      $json = json_decode($konten, true);
                      
      for($a=0; $a < count($json); $a++)
        {
    ?>
                      <option value="<?php echo $json[$a]['id_kategori']; ?>"><?php echo $json[$a]['nama_kategori']; ?></option>
    <?php
        }
    ?>
                      </select>
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


          <!-- Modal Popup untuk Edit Data Produk-->
          <div id="ModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Data Produk</h5>
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
                    <h5 class='modal-title' id='exampleModalLabel'>Detail Data Produk</h5>
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
          <h5 class='modal-title' id='exampleModalLabel'>Set Harga Produk</h5>
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
        var datapro = "data_produk.php";
        $('#DataProduk').load(datapro); 

        $('#form-tambah').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-tambah").serialize();
          $.ajax({
            url:"http://localhost/BillServer/add_produk.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#kode_produk").val('');
                $("#nama_produk").val('');
                $("#kategori_produk").val('');
                $('#ModalAdd').modal('hide');
                $('#DataProduk').load(datapro);
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        
        $(document).on('click','#hapus',function(e){
          e.preventDefault();
          var pid = $(this).attr('data-id');
          bootbox.dialog({
            message: "Apakah Anda Ingin Menghapus Data Produk ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('http://localhost/BillServer/delete_produk.php', { 'delete':pid })
                  .done(function(html){             
                    $('#DataProduk').load(datapro);   
                  })
                  .fail(function(){
                    bootbox.alert('Something Went Wrog ....');
                  })
                }
              }, 
              success: {
                label: "Tidak",
                className: "btn-danger",
                callback: function() {
                  $('.bootbox').modal('hide');
                }
              }
            }
          });
        });

$(document).on('click','#detail',function(e){
  e.preventDefault();
  $("#ModalDetail").modal('show');
  $.post('detail_produk.php',
    {id:$(this).attr('data-id')},
    function(html){
      $("#data-detail").html(html);
    }  
  );
});

        $(document).on('click','#setharga',function(e){
          e.preventDefault();
          $("#ModalSet").modal('show');
          $.post('set_produk.php',
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
            url: "http://localhost/BillServer/set_produk.php",
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

        $(document).on('click','#edit',function(e){
          e.preventDefault();
          $("#ModalEdit").modal('show');
          $.post('edit_produk.php',
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
            url: "http://localhost/BillServer/update_produk.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalEdit').modal('hide');
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

