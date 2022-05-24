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
            <li class="breadcrumb-item active">Pegawai</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataPegawai">          
          </div>


          <!-- Modal Popup untuk Tambah Data Pegawai--> 
          <div id="ModalAdd" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Tambah Data Pegawai</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-tambah">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Nama Pegawai*</label>
                      <input class="form-control" type="text" name="nama_pegawai" id="nama_pegawai" placeholder="Nama Pegawai" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Alamat*</label>
                      <input class="form-control" type="text" name="alamat_pegawai" id="alamat_pegawai" placeholder="Alamat Pegawai" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kota">Telepon*</label>
                      <input class="form-control" type="text" name="tlp_pegawai" id="tlp_pegawai" placeholder="Telepon Pegawai" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Jenis Kelamin*</label>
                      <select class="form-control" name="jekel_pegawai" id="jekel_pegawai">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>                        
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Username*</label>
                      <input class="form-control" type="text" name="uname_pegawai" id="uname_pegawai" placeholder="Username Pegawai" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kota">Password*</label>
                      <input class="form-control" type="text" name="pwd_pegawai" id="pwd_pegawai" placeholder="Password Pegawai" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Office*</label>
                      <select class="form-control" name="office_pegawai" id="office_pegawai">
                        <option value="">Pilih Office Pegawai</option>
    <?php
      $sumber = "http://localhost/BillServer/data_office.php";
      $konten = file_get_contents($sumber);
      $json = json_decode($konten, true);
                      
      for($a=0; $a < count($json); $a++)
        {
    ?>
                      <option value="<?php echo $json[$a]['id_office']; ?>"><?php echo $json[$a]['nama_office']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Status*</label>
                      <select class="form-control" name="status_pegawai" id="status_pegawai">
                        <option value="">Pilih Status Pegawai</option>
                        <option value="Admin">Admin</option>                        
                        <option value="GudangPusat">Gudang Pusat</option>
                        <option value="PICCounter">PIC Counter</option>                        
                        <option value="Counter">Counter</option>
                        <option value="Gudang">Gudang</option>            
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

          <!-- Modal Popup untuk Edit Data Region-->
          <div id="ModalEdit" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form role="form" id="form-edit">
                  <div class="modal-header">
                    <h5 class='modal-title' id='exampleModalLabel'>Edit Data Pegawai</h5>
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
        var datausr = "data_user.php";
        $('#DataPegawai').load(datausr); 

        $('#form-tambah').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-tambah").serialize();
          $.ajax({
            url:"http://localhost/BillServer/add_user.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $("#nama_pegawai").val('');
                $("#alamat_pegawai").val('');
                $("#tlp_pegawai").val('');
                $("#jekel_pegawai").val('');
                $("#uname_pegawai").val('');
                $("#pwd_pegawai").val('');
                $("#office_pegawai").val('');
                $("#status_pegawai").val('');
                $('#ModalAdd').modal('hide');
                $('#DataPegawai').load(datausr);
              }else{
                alert(obj.error); 
              }
            }
          })
        })

        $(document).on('click','#edit',function(e){
          e.preventDefault();
          $("#ModalEdit").modal('show');
          $.post('edit_user.php',
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
            url: "http://localhost/BillServer/update_user.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                $('#ModalEdit').modal('hide');
                $('#DataPegawai').load(datausr);
              }else{
                alert(obj.error); 
              }
            }
          });
        });

        $(document).on('click','#hapus',function(e){
          e.preventDefault();
          var pid = $(this).attr('data-id');
          bootbox.dialog({
            message: "Apakah Anda Ingin Menghapus Data Pegawai ?",
            title: "",
            buttons: {
              danger: {
                label: "Ya",
                className: "btn-success",
                callback: function() {
                  $.post('http://localhost/BillServer/delete_user.php', { 'delete':pid })
                  .done(function(html){
                    $('#DataPegawai').load(datausr);      
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

      })
    </script>

  </body>
  
</html>

