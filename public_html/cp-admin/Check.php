<?php @session_start();
     include("../include/dataconnect.php");



  if(isset($_SESSION['USERID']))
   {  
   
   
   
    if(isset($_SESSION['Manegar']))
	{
     $query1="select * from admin where idAdmin=".$_SESSION['USERID'];
      $result1=mysql_query($query1,$link);	
      $row1=mysql_fetch_array($result1);

           if(($row1['Log_in']) == 0) 
              {
	             session_destroy();
       
	            header("location:login.php");
       
			  }
			  

	}
   }
   else
   { session_destroy();
       
	            header("location:login.php");
	   
	   }

?>