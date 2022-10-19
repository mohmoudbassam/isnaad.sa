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
 function payment (idcart)
 {
	 window.location.href ='Payments.php?idcart='+idcart;
 }
 </script>

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
                            <h3>
                 
                    <small>
                        
                    </small>
                </h3>
                        </div>

                        <div class="title_right hidden-print">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="x_panel">
                                <div class="x_title hidden-print" >
                                    <h2 style="float:right;">طلبية</h2>
                                    <ul class="nav navbar-left panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                      
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                 <?php
                                     $Cart= $_GET['id'];
									 
									 $sql12="UPDATE  cart  SET Watch='2' Where idCart=$Cart";																
                                     $result12=mysql_query($sql12,$link);
									 
								     $sql="select * from cart 
								     inner join user
								     on cart.F_User=user.idUser and cart.idCart='$Cart' order by idCart DESC";
		                              $result=mysql_query($sql,$link);
		                              $row=mysql_fetch_array($result);
		                         
                                  ?>

                                    <section class="content invoice">
                                        <!-- title row -->
                                        <div class="row">
                                        
                                                     <div class="col-xs-6 invoice-header" style="direction:rtl;">
                                                <h3>
                                        
                                        <small class="pull-right" style="font-size:12px; "> <span style="color:#09F;"> المشتري</span> : <?php echo $row['Name']; ?>  </small>
                                    </h3>
                                    <br>

                                      <h3>
                                        
                                        <small class="pull-right" style="font-size:12px;"><span style="color:#09F;"> العنوان : </span><?php echo $row['Address']; ?>  </small>
                                    </h3>
                                     <br>

                                      <h3>
                                        
                                        <small class="pull-right" style="font-size:12px;"><span style="color:#09F;"> جوال : </span> <?php echo $row['Mobile']; ?>  </small>
                                    </h3>
                                            </div>
                                        
                                        
                                            <div class="col-xs-6 invoice-header">
                                                <h3>
                                        
                                        <small class="pull-right" style="font-size:12px;"> <?php echo $row['Date']; ?> <span style="color:#09F;">: تاريخ الفاتورة</span> </small>
                                    </h3>
                                    <br>

                                      <h3>
                                        
                                        <small class="pull-right" style="font-size:12px;"> <?php echo $row['idCart']; ?><span style="color:#09F;"> : رقم الفاتورة</span> </small>
                                    </h3>
                                     <br>

                                      <h3>
                                        
                                        <small class="pull-right" style="font-size:12px;"> 
										 <span style="color:#09F;"> حالة الفاتورة : </span> 
										<?php if ($row['Done']==2)
										echo 'مدفوعة';
										else
										echo 'غير مدفوعة';
										
										
										 ?> 
                                        
                                      
                                        
                                        
                                        </small>
                                    </h3>
                                            </div>
                                            
                                            
                                
                                            
                                            
                                            <!-- /.col -->
                                        </div>
<br>
<br>

                                        <!-- Table row -->
                                        <div class="row">
                                            <div class="col-xs-12 table">
                                                <table class="table table-striped" >
                                                    <thead>
                                                        <tr>
                                                           
                                                            <th>إسم المنتج</th>
                                                             <th>الكمية</th>
                                                            <th>سعر القطعة</th>
                                                            <th style="width: 59%">الوصف</th>
                                                            <th >البائع</th>
                                                            <th>التكلفة </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    
                                                    
                                                        <?php 
										 $sql_P="select product.Name as PName,product.idProduct as idProduct ,product.Price as Price,product.Info as Info , user.Name as UName,orderr.Amount as Amount,orderr.Cost as Cost,orderr.Info as Infoo from product  
								     inner join orderr
								     on product.idProduct=orderr.F_Product and orderr.F_Cart='$Cart'
									 inner join user
									 on user.idUser=product.F_User
									  ";
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
                                                      echo'  <tr>
                                                           
                                                            <td>'.$row_P['PName'].'</td>
															 <td>'.$row_P['Amount'].'</td>
                                                            <td>'.$row_P['Price'].' </td>
                                                            <td >'.$row_P['Infoo'].' </td>
                                                              <td >'.$row_P['UName'].' </td>
                                                            <td>'.$row_P['Cost'].'</td>
                                                        </tr>';
										 }
										 ?>
                                                     
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <div class="row">
                                            <!-- accepted payments column -->
                                            <div class="col-xs-6">
                                                <p class="lead">Payment Methods:</p>
                                                <img src="images/visa.png" alt="Visa">
                                                <img src="images/mastercard.png" alt="Mastercard">
                                                <img src="images/american-express.png" alt="American Express">
                                                <img src="images/paypal2.png" alt="Paypal">
                                                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                                </p>
                                            </div>
                                            <!-- /.col -->
                                            <div class="col-xs-6">
                                                <p class="lead" style="text-align:right;">المبلغ المستحق</p>
                                                <div class="table-responsive">
                                                    <table class="table" style="direction:rtl; ">
                                                        <tbody>
                                                            <tr>
                                                                <th style="width:50%">حاصل الجمع : </th>
                                                                <td> <?php $x=$row['Cost']-17; echo $x; ?> ريال</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>الشحن : </th>
                                                                <td>17 ريال</td>
                                                            </tr>
                                                            <tr>
                                                                <th>المجموع النهائي : </th>
                                                                <td> <?php echo $row['Cost']; ?> ريال</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <!-- /.row -->

                                        <!-- this row will not appear when printing -->
                                        <div class="row no-print hidden-print">
                                            <div class="col-xs-12">
                                                <button class="btn btn-warning" onclick="window.print();"><i class="fa fa-print"></i> طباعة</button>
                                                
                                                    <button class="btn btn-success pull-right" onclick="payment (<?php echo $Cart; ?>)"><i class="fa fa-print"></i> الدفعات</button>
                                               
                                               
                         
                                               
                                              <!--  <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>-->
                                            </div>
                                        </div>
                                    </section>
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


                <!-- footer content -->
                <footer class="hidden-print">
                    <div class="">
                        <p class="pull-right hidden-print">
                            <span class="lead hidden-print"> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"></span>
                            
                                 

                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->
            </div>
            <!-- /page content -->
        </div>

    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none hidden-print">
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