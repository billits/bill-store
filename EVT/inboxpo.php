<?php
  include ('akses.php');
  include ('../_partials/partial_evt.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
    <script>
      function myFunction() {        
        var qty=parseInt($('#qty').val());
        var price=parseInt($('#price').val());
        var tot_fix = qty*price;  

        var reverse = tot_fix.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
        document.getElementById("total").value = ribuan;   
      }
    </script>
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
            <li class="breadcrumb-item active">Inbox PO Event dari Pusat</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataPO">
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
        var datapo = "data_po_evt.php";
        $('#DataPO').load(datapo); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datapi = $(this).attr('data-pi');
          var datalap = "data_dettrans_evt.php?id="+datatmp+"&pi="+datapi;
          $('#DataPO').load(datalap); 
        });
        
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataPO').load(datapo); 
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NTJK.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

        $(document).on('click','#aprov',function(e){
          e.preventDefault();
          var dataform = $("#form-app").serialize();
          $.ajax({
            url: "../db_proses/update_pocl_evt.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                alert(obj.error); 
                location.reload();
                //$('#DataPO').load(datapo); 
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

