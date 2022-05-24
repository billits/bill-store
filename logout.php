<?php
  unset($_COOKIE["idstaff_bill"]);
  unset($_COOKIE["office_bill"]);
  unset($_COOKIE["status_bill"]);
  unset($_COOKIE["region_bill"]);
  setcookie("idstaff_bill", null, time() - (86400 * 30), '/');
  setcookie("office_bill", null, time() - (86400 * 30), '/');
  setcookie("status_bill", null, time() - (86400 * 30), '/');
  setcookie("region_bill", null, time() - (86400 * 30), '/');
  
  header("Location:login.php");
	exit();
?>