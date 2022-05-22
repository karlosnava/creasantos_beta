<?php 

$excel = $_REQUEST['export']; 
header("Content-type: application/vnd.ms-excel"); 
header("Content-disposition: attachment; filename=exportar.xls"); 
print $excel; 
exit; 


?>