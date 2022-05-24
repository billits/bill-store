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
            <li class="breadcrumb-item active">Region</li>
          </ol>

          <!-- DataTables Example -->
          <div id="lala">          
          </div>


          <!-- Modal Popup untuk Tambah Data Region--> 
          <div id="ModalAddReg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Tambah Data Region</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Region</label>
                      <input type="text" name="kode_region"  id="kode_region" class="form-control" placeholder="Kode Region" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Region</label>
                      <input type="text" name="nama_region" id="nama_region" class="form-control" placeholder="Nama Region" required/>
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

          <!-- Modal Popup untuk Edit Data Region-->
          <div id="ModalEditReg" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit-region">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Data Region</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-edit-region">
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
        var datareg = "data_region.php";
        $('#lala').load(datareg); 

        $('#form-tambah').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-tambah").serialize();
          $.ajax({
            url:"../db_proses/add_region.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#kode_region").val('');
                $("#nama_region").val('');
                $('#ModalAddReg').modal('hide');
                $('#lala').load(datareg);
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#edit_reg',function(e){
          e.preventDefault();
          $("#ModalEditReg").modal('show');
          $.post('edit_region.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-edit-region").html(html);
            }  
          );
        });
        
        $("#form-edit-region").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-edit-region").serialize();
          $.ajax({
            url: "../db_proses/update_region.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#kode_region").val('');
                $("#nama_region").val('');
                $('#ModalEditReg').modal('hide');
                $('#lala').load(datareg);
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

