<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("../../include/dataconnect.php");
// Security one

$id=$_GET["id"];
	$sql="DELETE FROM image where idImage='$id'";
		  $result=mysql_query($sql,$link);



                       
                   
									    $sql="select * from image ";
		                                $result=mysql_query($sql,$link);
                                        while($row=@mysql_fetch_array($result))
                                       {
									   
                                       echo' <div class="col-md-55">
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <img style="width: 100%; display: block;" src="../image/Album/'.$row['Link'].'" alt="image" />
                                                    <div class="mask">
                                                        <p></p>
                                                        <div class="tools tools-bottom">
                                                            <a href="../image/Album/'.$row['Link'].'"><i class="fa fa-link"></i></a>
                                                            <a href="#" onclick="Delete('.$row['idImage'].')"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="caption">
                                                    <p style="text-align:right;">'.$row['Name'].'</p>
                                                </div>
                                                
                                            </div>
                                        </div>';
									   }
                           ?> 
                    
                            
                   




