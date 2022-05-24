<?php
  include ('akses.php');
  include ('../_partials/partial_pusat.php');
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
            <li class="breadcrumb-item active">Konsi Produk Ke Cabang</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataStok">          
          </div>

          <!-- Modal Popup untuk Pilih Data Event--> 
          <div id="ModalEv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Pilih Kantor Cabang</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-kantor">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Data Kantor*</label>
                        <select class="form-control m-bot15" name="kantor" id="kantor">
                          <option value="">Pilih Kantor</option>
    <?php
      include "../db_proses/koneksi.php";

      $query = "SELECT * FROM tb_office WHERE id_office != 'PST'";
      $result = mysqli_query($kon, $query);

      while($baris = mysqli_fetch_assoc($result)){
    ?>
                          <option value="<?php echo $baris['id_office']; ?>"><?php echo $baris['nama_office']." (".$baris['id_office'].")"; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Pilih</button>
                      <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                    </div>
                  </form>
                </div>
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
        var datastok = "data_konsi.php";
        $('#DataStok').load(datastok); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_detkonsi.php?id="+datatmp;
          $('#DataStok').load(datalap); 
        });

        $('#form-kantor').submit(function(e){
          e.preventDefault();        
          var dataform = $("#form-kantor").serialize();
          $.ajax({
            url:"../db_proses/add_stok_konsi.php",
            type:"POST",
            data: dataform,
            success:function(data){
              var obj= JSON.parse(data);
              if(obj.nilai===1){
                window.location= 'add_konsi.php?nota='+obj.nota;
              }else{
                alert(obj.error); 
              }
            }
          })
        });

        // $(document).on('click','#addstok',function(e){
        //   e.preventDefault();
        //   var evt =$(this).attr('data-et');
        //   var tmp = {event : evt}
        //   $.ajax({
        //     url:"../db_proses/add_stokevt.php",
        //     type:"POST",
        //     data: tmp,
        //     success:function(data){
        //       var obj= JSON.parse(data);
        //       if(obj.nilai===1){
        //         window.location= 'add_stokevt.php?nota='+obj.nota+"&evn="+obj.acara;
        //       }else{
        //         alert(obj.error); 
        //       }
        //     }
        //   })
        // });

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataStok').load(datastok); 
        });


        $(document).on('click','#cetak',function(e){
          e.preventDefault();
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NPO Cabang.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });
        
      })
    </script>

  </body>
  
</html>

