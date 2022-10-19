<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$id=$_GET["id"];
$sql="DELETE FROM video where idVideo='$id'";
$result=mysql_query($sql,$link);


                   
  
									    $sql="select * from video ";
		                                $result=mysql_query($sql,$link);
                                        while($row=@mysql_fetch_array($result))
                                       {
									   
                                       echo'
                                   
                            <div class="col-md-55">
                            <div class="tools tools-bottom">
                            <a href="#" onclick="Delete('.$row['idVideo'].')"><i class="fa fa-times"></i></a>
                            </div>
                            <div class="thumbnail">
                          <iframe width="230" height="190" src="https://www.youtube.com/embed/'.$row['Link'].'" frameborder="0" allowfullscreen></iframe>
                           </div>
                           </div>';
									   }
						
 
 
 ?>