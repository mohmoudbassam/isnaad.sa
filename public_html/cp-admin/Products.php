<?php include("Check.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> لوحة التحكم   </title>

    <!-- Bootstrap core CSS -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="css/custom.css" rel="stylesheet">
    <link href="css/icheck/flat/green.css" rel="stylesheet">


    <script src="js/jquery.min.js"></script>
   <script>
   
   function Search(Word,Catg)
{

var url="Search_Product.php?Word="+Word+"&Catg="+Catg;	
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	
	 document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
	else
	{
	 document.getElementById("myDiv").innerHTML="<img src=images/loading.gif></img>";
	
	}
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();

}


   
   
function Delete(id,Catg)
{
	if(confirm("هل أنت متأكد من عملية الحذف ؟  "))
{	

var url="Delete_Product.php?id="+id+"&Catg="+Catg;	
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	
	 document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
	else
	{
	 document.getElementById("myDiv").innerHTML="<img src=images/loading.gif></img>";
	
	}
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();
}
else
	return false;
}


</script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                   <div class="navbar nav_title" style="border: 0;">
                        <a href="index.php" class="site_title"> <span> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"> </span></a>
                    </div>
                    <div class="clearfix"></div>

                     <?php   include("../include/Left_Menue.php"); ?>

                </div>
            </div>

            <!-- top navigation -->
             <?php   include("../include/Head_Menue.php"); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">

                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                           
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                     <div class="input-group">
                                <?php
								 $Catg= $_GET['id'];
                                    echo'<input type="search" id="Word" name="Word" style="direction:rtl;" class="form-control"   placeholder="إبحث عن منتجك">';
									?>
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                            
                            
                              <script>
							   var simple = '<?php echo  $Catg ?>';
							var timeout = null;
$('#Word').on('keyup', function () {
    var that = this;
    if (timeout !== null) {
        clearTimeout(timeout);
    }
    timeout = setTimeout(function () {
        Search($(that).val(),simple);
    }, 1500);
});
							
							</script>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title">
                                
                                  
                                <?php
								
								/// رقم التصنيف
								 $Catg= $_GET['id'];
								 
								 $_SESSION['Catg']=$Catg;
								
								 $sql_Catg="select * from category where idCategory='$Catg' ";
                                 $result_Catg=mysql_query($sql_Catg,$link);
								 $row_Catg=mysql_fetch_array($result_Catg);
								 
								 $o=$row_Catg['F_Section'];
								  $sql_S="select * from section where idSection='$o' ";
                                 $result_S=mysql_query($sql_S,$link);
								 $row_S=mysql_fetch_array($result_S);

                                   echo' <h4 style="text-align:right; direction:rtl; float:right;">'.$row_S['Name'].' &nbsp; > &nbsp;'.$row_Catg['Name'].' &nbsp;</h4>';
								   echo"<h4 style='text-align:right; direction:rtl; float:right;'>";
								 $sql1="select Count(*) as num from product  where F_Category='$Catg'";
								 $result1=mysql_query($sql1,$link);
								 $row1=@mysql_fetch_array($result1);
								 echo" ( "; echo $row1['num']; echo '<span style="color:Blue;"> كائن </span>';
								 echo" ) ";
								 echo"</h4>";
									?>
                                    <br>
<br>
<br>
<br>

                       <div style="float:right;"> <a href="New_Product.php" class="btn btn-primary btn-xs"><i class="fa fa-archive"></i> كائن جديد </a> </div>

                                    <ul class="nav navbar-left panel_toolbox">
                                    
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                       
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>

                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                
                                   <div id="myDiv">  


                                    <!-- start project list -->
                                    <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم الكائن</th>
                                                
                                                <th> الكائن</th>
                                                <th>الظهور</th>
                                               
                                                <th>السعر</th>
                                                <th style="width: 20%"> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                           <?php 
										   
										    
										 $sql_P="select * from product where F_Category='$Catg' order by idProduct DESC ";
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
                                                $Product=$row_P['idProduct'];
											    $User=$row_P['F_User'];
												
		                                        $sql2="select * from product_image  Where F_Product='$Product'";
		                                        $result2=mysql_query($sql2,$link);
		                                         $row2=mysql_fetch_array($result2);
												 
												 
												 $sql_User="select * from user where idUser=$User";
                                                 $result_User=mysql_query($sql_User,$link);
             								     $row_User=mysql_fetch_array($result_User);
												
												
										 echo'
                                        
                                            <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'">'.$row_P['Name'].'</a>
                                                   
                                                </td>
                                               
                                              <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Product/'.$row2['Link'].'" alt="">';
                                            
                                                echo'</td>';
												
												
                                                echo'<td>';
												if ($row_P['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row_P['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'</td>';
												
												
												
											
												
												
												echo'
												
												 <td>
                                                   '.$row_P['Price'].'
                                                   
                                                </td>
												
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                      <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idProduct'].','.$Catg.');"><i class="fa fa-trash-o"></i> حذف </a>                                                </td>
                                            </tr>';
										 }
										 ?>
                                     
                                           
                                        </tbody>
                                    </table>
                                    <!-- end project list -->
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>


              <footer>
                    <div class="">
                         <p class="pull-right">
                            <span class="lead"> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"></span>
                            
                                 

                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="js/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="js/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="js/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="js/icheck/icheck.min.js"></script>

    <script src="js/custom.js"></script>

</body>

</html>