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
            <li class="breadcrumb-item active">Retur Produk Ke Supplier</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataNTJK">          
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
        var datakat = "data_retur_sup.php";
        $('#DataNTJK').load(datakat); 
        
        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_det_ret_sup.php?id="+datatmp;
          $('#DataNTJK').load(datalap); 
        });

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataNTJK').load(datakat); 
        });

        $(document).on('click','#addtrans',function(e){
          e.preventDefault();
          $.ajax({
            url:"../db_proses/add_ret_sup.php",
            type:"POST",
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                window.location= 'det_retur_sup.php?nota='+obj.nota;
              }else{
                alert(obj.error); 
              }
            }
          })
        });

        $(document).on('click','#cetak',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          window.open(
            '../Print Nota BTR Pusat.php?nota='+datatmp,
            '_blank' // <- This is what makes it open in a new window.
          );
          var datalap = "data_det_ret_sup.php?id="+datatmp;
          $('#DataNTJK').load(datalap); 
        });
        
        // $('#form-approv').submit(function(e){
        //   e.preventDefault();
        //   var dataform = $("#form-approv").serialize();
        //   $.ajax({
        //     url:"../db_proses/add_ret_evt.php",
        //     type:"POST",
        //     data: dataform,
        //     success:function(result){
        //       var obj= JSON.parse(result);
        //       if(obj.nilai===1){
        //         // alert(obj.error); 
        //         var nota_temp = obj.nota_id;
        //         var evt = document.getElementById("event").value;   
        //         window.location= 'det_retur.php?nota='+nota_temp+'&evt='+evt;
        //       }else{
        //         alert(obj.error); 
        //       }
        //     }
        //   })
        // })
        
      })
    </script>

  </body>
  
</html>

