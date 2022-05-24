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
            <li class="breadcrumb-item active"> Office</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataOffice">
          </div>

          <!-- Modal Popup untuk Tambah Data Office--> 
          <div id="ModalAddOffice" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Tambah Data Office</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah-office">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Office*</label>
                      <input class="form-control" type="text" name="kode_office" id="kode_office" placeholder="Kode Office" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Office*</label>
                      <input class="form-control" type="text" name="nama_office" id="nama_office" placeholder="Nama Office" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kota">Kota Office*</label>
                      <input class="form-control" type="text" name="kota_office" id="kota_office" placeholder="Kota Office" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Alamat Office*</label>
                      <input class="form-control" type="text" name="alamat_office" id="alamat_office" placeholder="Alamat Office" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Telepon Office*</label>
                      <input class="form-control" type="text" name="telepon_office" id="telepon_office" placeholder="Telepon Office" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Region Office*</label>
                      <select class="form-control" name="region_office" id="region_office">
                        <option value="">Pilih Region</option>
    <?php
      $sumber = "http://localhost/BillServer/data_region.php";
      $konten = file_get_contents($sumber);
      $json = json_decode($konten, true);
                      
      for($a=0; $a < count($json); $a++)
        {
    ?>
                      <option value="<?php echo $json[$a]['id_region']; ?>"><?php echo $json[$a]['nama_region']; ?></option>
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


          <!-- Modal Popup untuk Edit Data Office-->
          <div id="ModalEditOff" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit-office">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Data Office</h5>
                    <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                      <span aria-hidden='true'>×</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div id="data-edit-office">
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
        var dataoff = "data_office.php";
        $('#DataOffice').load(dataoff); 

        $('#form-tambah-office').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-tambah-office").serialize();
          $.ajax({
            url:"http://localhost/BillServer/add_office.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#kode_office").val('');
                $("#nama_office").val('');
                $("#kota_office").val('');
                $("#alamat_office").val('');
                $("#telepon_office").val('');
                $("#region_office").val('');
                $('#ModalAddOffice').modal('hide');
                $('#DataOffice').load(dataoff);
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        
        $(document).on('click','#hapus_off',function(e){
          e.preventDefault();
          var pid = $(this).attr('data-id');
          bootbox.dialog({
            message: "Apakah Anda Ingin Menghapus Data Office ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('http://localhost/BillServer/delete_office.php', { 'delete':pid })
                  .done(function(html){             
                    $('#DataOffice').load(dataoff);   
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

        $(document).on('click','#edit_off',function(e){
          e.preventDefault();
          $("#ModalEditOff").modal('show');
          $.post('edit_office.php',
            {id:$(this).attr('data-id')},
            function(html){
              $("#data-edit-office").html(html);
            }  
          );
        });
        
        $("#form-edit-office").submit(function(e) {
          e.preventDefault();
          var dataform = $("#form-edit-office").serialize();
          $.ajax({
            url: "http://localhost/BillServer/update_office.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalEditOff').modal('hide');
                $('#DataOffice').load(dataoff);
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

