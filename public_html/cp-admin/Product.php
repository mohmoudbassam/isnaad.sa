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
    <!-- editor -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <link href="css/editor/external/google-code-prettify/prettify.css" rel="stylesheet">
    <link href="css/editor/index.css" rel="stylesheet">
    <!-- select2 -->
    <link href="css/select/select2.min.css" rel="stylesheet">
    <!-- switchery -->
    <link rel="stylesheet" href="css/switchery/switchery.min.css" />

    <script src="js/jquery.min.js"></script>
<link rel="stylesheet" href="./minified/themes/default.min.css" type="text/css" media="all" />

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="./minified/jquery.sceditor.bbcode.min.js"></script>



<script src="js/nicEdit.js" type="text/javascript"></script>
<script type="text/javascript">
bkLib.onDomLoaded(function() {
	new nicEditor({fullPanel : true}).panelInstance('Info');
	new nicEditor({fullPanel : true}).panelInstance('Info_E');
	new nicEditor({fullPanel : true}).panelInstance('Tags');
	new nicEditor({fullPanel : true}).panelInstance('Tags_E');
});
</script>

		<style>
			
			
			code:before {
				position: absolute;
				content: 'Code:';
				top: -1.35em;
				left: 0;
			}
			code {
				margin-top: 1.5em;
				position: relative;
				background: #eee;
				border: 1px solid #aaa;
				white-space: pre;
				padding: .25em;
				min-height: 1.25em;
			}
			code:before, code {
				display: block;
				text-align: left;
			}
		</style>

		<script>
		
		
		
function Delete(Product,Num)
{

var url="ajax/Edit_Product.php?Product="+Product+"&Num="+Num;
	
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
  }
xmlhttp.open("GET",url,true);
xmlhttp.send();
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

                   <?php  include ("../include/Left_Menue.php"); ?>

                  
                </div>
            </div>

            <!-- top navigation -->
          <?php   include("../include/Head_Menue.php"); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">

                    <div class="page-title">
                        <div class="title_right">
                        </div>
                       
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title" >
                                    <h4 style="text-align:right; float:right;">تعديل  الكائن   </h4>
                                    <ul class="nav navbar-left panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                       
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <br />
                                    
                                                                     <?php
                                     if(isset($_SESSION['Done']))
                                    {
										if ($_SESSION['Done']==1)
										{
                                    echo' <div class="alert alert-success alert-dismissible fade in" style="text-align:right;" role="alert">
                                   
                                    <strong>تم التعديل </strong> 
                                </div>';
								 unset($_SESSION['Done']);
										}
										else
										{
                                
                                      echo'<div class="alert alert-danger alert-dismissible fade in" style="text-align:right; direction:rtl;" role="alert">
                                  
                                    <strong>حدث خطأ ما ! </strong> 
                                </div>';
								 unset($_SESSION['Done']);
										}
									}
								
								?>
                                
                                
           <?php
           $product= $_GET['id'];
		   $sql="select * from product  Where idProduct='$product'";
		   $result=mysql_query($sql,$link);
		   $row=mysql_fetch_array($result);
		   
		    if ($row['Seen']==1)
			 {
				$sql21="update  product Set seen='2' Where idProduct='$product'";
				$result21=mysql_query($sql21,$link);	 
			 }
		   
		   
           ?>
                                    <form id="demo-form2" action="Edit_Product.php" method="post"  enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                                    
                                      <script type="text/javascript">
        $("body").on("click", "#btnUpload", function () {
            var allowedFiles = [".jpg",".jpeg",".png",".JPG",".JPEG",".PNG"];
            var fileUpload = $("#Image");
			var img= document.getElementById("Image").value;
			if (img != '')
			{
            var lblError = $("#lblError");
            var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
            if (!regex.test(fileUpload.val().toLowerCase())) {
                lblError.html(" <b>" + allowedFiles.join(', ') + "</b> : فضلاً يجب أن تكون صيغة الملف ");
                return false;
            }
            lblError.html('');
			}
            return true;
        });
    </script>
                                    
                                    
                                     <input type="hidden" name="id"  id="hiddenField"   value="<?php echo $product; ?>"/>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> العنوان   <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" style="text-align:right; direction:rtl;" id="Name" name="Name" value="<?php echo $row['Name']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> Title <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Name_E" name="Name_E" value="<?php echo $row['Name_E']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                    
                                     
                                     
                                        
                                         
                                      
                                     
                                     
                                 
                                     <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">القسم</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select style="height:40px; " class="select2_single form-control" name="Category" id="Category"  tabindex="-1">
                                         <?php 
										 
                                         $sql_CC="select * from category";
                                         $result_CC=mysql_query($sql_CC,$link);
								         while($Category=@mysql_fetch_array($result_CC))
										 {
                                           if( $row['F_Category']==$Category['idCategory']) 
                                          echo'<option value="'.$Category['idCategory'].'" selected>'.$Category['Name'].'</option>';
										  else
										    echo'<option value="'.$Category['idCategory'].'" >'.$Category['Name'].'</option>';
                                                  
										 }
										 
                                               ?>
                                                  
                                                </select>
                                            </div>
                                        </div>
                                     
                                     
                                    
                                    <br>
                                    <br>
                                    
                                    
                                    

			 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">تفاصيل <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Info" name="Info" style="width:72%"><?php echo $row['Info']; ?></textarea>

				  </div>
			</div>

			

                  <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map"> Details<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Info_E" name="Info_E" style="width:72%"><?php echo $row['Info_E']; ?></textarea>

				  </div>
			</div>

<br>

<br>
                
                                        
                                        
                                           <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> رابط الموقع الإلكتروني
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Link1" name="Link1" value="<?php echo $row['Link1']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                             <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> رابط التطبيق في متجر ايفون 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Link2" name="Link2" value="<?php echo $row['Link2']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                             <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> رابط التطبيق في متجر أندرويد 
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Link3" name="Link3" value="<?php echo $row['Link3']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                    
                                     
                                        
                                        
                                        
                                        
                                        <br>
<br>

                                        
			

                                     <div class="form-group">
                                         <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"> السعر  <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="text" id="Price" name="Price" value="<?php echo $row['Price']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                       
                                       <br>
                                      


  <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">المتبقي من المدة / يوم <span class="required"></span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="D" name="D" value="<?php 
												
												
										  $this_Date=strtotime(date("Y/m/d"));
                                          $E_Date = strtotime($row['E_Date']); 
                                          $datediff = $E_Date- $this_Date ;
										  
                                          $x= floor($datediff/(60*60*24));
										  $_SESSION['T']=$x;
										
										 
										 if ($row['Type']==0)
										 {
										   echo 'مفتوح';
										 }
										 else
										 {
											  if ($x<=0)
											  {
												  $_SESSION['T']=0;
												   echo'إنتهت الفترة من حوالي ' .abs ($x). ' يوم';
												   
											  }
											 else
											 echo $x;
										 }
										 
										 
									
										  ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
<br>


                         

                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">ظهور </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                 <select class="select2_single form-control" name="Sho" id="Sho" tabindex="-1">
                                              	<?php	   
		                                           	if( $row['Sho']==1)		
		                                             echo" <option value='1' selected> مخفي</option>";
		                                            else
		                                             echo" <option value='1'> مخفي</option>";
           
		   
		                                        	if( $row['Sho']==2)		
		                                             echo" <option value='2' selected> ظاهر</option>";
		                                             else
		                                                echo" <option value='2'> ظاهر</option>";
		   

	                                              	?>   
                                               
                                                  
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <br>
                                       
                                        
                                        
                                        
                                       
                                        
                                        <br>
<br>
<br>

                                        
                                        
                                        
                                        

<div class="form-group">

               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">صور الكائن <span class="required"></span>  </label>

                  <table  class="control-label col-md-10 col-sm-10 col-xs-12" style=" border:hidden; " >
               <tr>
    <td  style="vertical-align:middle;" align="right" >   <span class="btn btn-file" style="font-size:14px; "><input  class="btn btn-success" type="file" name="Image" id="Image"/></span>
    
     <br />
   <center> <span id="lblError" style="color:#900;"></span> </center>
    <br />
 
    
    </td>
    <td  style="font-size:14px; vertical-align:middle; text-align:center; font-weight:700;">   <img width="170" height="170"
     style="
 /* top-left corner */
border-top-left-radius: 10px;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;

/* bottom-right corner */
border-bottom-right-radius: 10px;
-moz-border-radius-bottomright: 10px;
-webkit-border-bottom-right-radius: 10px;


/* bottom-left corner */
border-bottom-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
" 
 src="../image/1.png"  /></td>
 
  
 
  </tr>
  </table>
                </div> 
                          
                          
                          
                      <br>
<br>
<br>
    
                          <div class="form-group">


        <div id="myDiv">


  <table style="margin-left:22px; border:hidden; " width="90%"  border="0">
  <tr style="text-align:center;">
  <?php
  $i=1;
 	  $q35="select * from product_image where F_Product='$product'";
                      $r35=mysql_query($q35,$link);
           while($row35=@mysql_fetch_array($r35))
		                  {
							  $j=$row35['Num'];	

							  if($i<4)
{
    echo '<td> '; 
echo" <img src='img/Delete-icon.png'  width='20' height='20' style='margin-bottom:62px; cursor:pointer;'  onclick='Delete(".$product.",".$j.")'/> ";
   echo' <img width="100" height="100"
     style="
 /* top-left corner */
border-top-left-radius: 10px;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;

/* bottom-right corner */
border-bottom-right-radius: 10px;
-moz-border-radius-bottomright: 10px;
-webkit-border-bottom-right-radius: 10px;


/* bottom-left corner */
border-bottom-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
" 
 src="../image/Product/'.$row35['Link'].'"  />
 </td>';
 $i++;
}

else
{
	    echo '<td> '; 
echo" <img src='img/Delete-icon.png'  width='20' height='20' style='margin-bottom:62px; cursor:pointer;'  onclick='Delete(".$product.",".$j.")'/> ";
   echo' <img width="100" height="100"
     style="
 /* top-left corner */
border-top-left-radius: 10px;
-moz-border-radius-topleft: 10px;
-webkit-border-top-left-radius: 10px;

/* bottom-right corner */
border-bottom-right-radius: 10px;
-moz-border-radius-bottomright: 10px;
-webkit-border-bottom-right-radius: 10px;


/* bottom-left corner */
border-bottom-left-radius: 10px;
-moz-border-radius-bottomleft: 10px;
-webkit-border-bottom-left-radius: 10px;
" 
 src="../image/Product/'.$row35['Link'].'"  />
 </td>';
	
	
	
	echo "</tr>  <tr style='text-align:center;'>
";
							$i=1;
}
						  }
						  ?>
 
   
  </tr>
</table>
</div>
                </div>              
                                       
                                       
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit"  id="btnUpload"  class="btn btn-success">تعديل </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#birthday').daterangepicker({
                                singleDatePicker: true,
                                calender_style: "picker_4"
                            }, function (start, end, label) {
                                console.log(start.toISOString(), end.toISOString(), label);
                            });
                        });
                    </script>


                    <div class="row">
                  <form id="demo-form" data-parsley-validate>
                                       
                                    </form>

  
                  
                </div>
                <!-- /page content -->

                <!-- footer content -->
                <footer>
                    <div class="">
                        <p class="pull-right">
                            <span class="lead"> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"></span>
                            
                                 

                        </p>
                    </div>
                    <div class="clearfix"></div>
                </footer>
                <!-- /footer content -->

            </div>

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
        <!-- tags -->
        <script src="js/tags/jquery.tagsinput.min.js"></script>
        <!-- switchery -->
        <script src="js/switchery/switchery.min.js"></script>
        <!-- daterangepicker -->
        <script type="text/javascript" src="js/moment.min2.js"></script>
        <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
        <!-- richtext editor -->
        <script src="js/editor/bootstrap-wysiwyg.js"></script>
        <script src="js/editor/external/jquery.hotkeys.js"></script>
        <script src="js/editor/external/google-code-prettify/prettify.js"></script>
        <!-- select2 -->
        <script src="js/select/select2.full.js"></script>
        <!-- form validation -->
        <script type="text/javascript" src="js/parsley/parsley.min.js"></script>
        <!-- textarea resize -->
        <script src="js/textarea/autosize.min.js"></script>
        <script>
            autosize($('.resizable_textarea'));
        </script>
        <!-- Autocomplete -->
        <script type="text/javascript" src="js/autocomplete/countries.js"></script>
        <script src="js/autocomplete/jquery.autocomplete.js"></script>
        <script type="text/javascript">
            $(function () {
                'use strict';
                var countriesArray = $.map(countries, function (value, key) {
                    return {
                        value: value,
                        data: key
                    };
                });
                // Initialize autocomplete with custom appendTo:
                $('#autocomplete-custom-append').autocomplete({
                    lookup: countriesArray,
                    appendTo: '#autocomplete-container'
                });
            });
        </script>
        <script src="js/custom.js"></script>


        <!-- select2 -->
        <script>
            $(document).ready(function () {
                $(".select2_single").select2({
                    placeholder: "Select a state",
                    allowClear: true
                });
                $(".select2_group").select2({});
                $(".select2_multiple").select2({
                    maximumSelectionLength: 4,
                    placeholder: "With Max Selection limit 4",
                    allowClear: true
                });
            });
        </script>
        <!-- /select2 -->
        <!-- input tags -->
        <script>
            function onAddTag(tag) {
                alert("Added a tag: " + tag);
            }

            function onRemoveTag(tag) {
                alert("Removed a tag: " + tag);
            }

            function onChangeTag(input, tag) {
                alert("Changed a tag: " + tag);
            }

            $(function () {
                $('#tags_1').tagsInput({
                    width: 'auto'
                });
            });
        </script>
        <!-- /input tags -->
        <!-- form validation -->
        <script type="text/javascript">
            $(document).ready(function () {
                $.listen('parsley:field:validate', function () {
                    validateFront();
                });
                $('#demo-form .btn').on('click', function () {
                    $('#demo-form').parsley().validate();
                    validateFront();
                });
                var validateFront = function () {
                    if (true === $('#demo-form').parsley().isValid()) {
                        $('.bs-callout-info').removeClass('hidden');
                        $('.bs-callout-warning').addClass('hidden');
                    } else {
                        $('.bs-callout-info').addClass('hidden');
                        $('.bs-callout-warning').removeClass('hidden');
                    }
                };
            });

            $(document).ready(function () {
                $.listen('parsley:field:validate', function () {
                    validateFront();
                });
                $('#demo-form2 .btn').on('click', function () {
                    $('#demo-form2').parsley().validate();
                    validateFront();
                });
                var validateFront = function () {
                    if (true === $('#demo-form2').parsley().isValid()) {
                        $('.bs-callout-info').removeClass('hidden');
                        $('.bs-callout-warning').addClass('hidden');
						
                    } else {
                        $('.bs-callout-info').addClass('hidden');
                        $('.bs-callout-warning').removeClass('hidden');
                    }
                };
            });
            try {
                hljs.initHighlightingOnLoad();
            } catch (err) {}
        </script>
        <!-- /form validation -->
        <!-- editor -->
     
        <!-- /editor -->
</body>

</html>