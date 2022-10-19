<?php include("Check.php"); ?>
<?php
        $sql="select * from home ";
        $result=mysql_query($sql,$link);
		$row=mysql_fetch_array($result);  
 ?>
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
	new nicEditor({fullPanel : true}).panelInstance('About_as');
	new nicEditor({fullPanel : true}).panelInstance('About_as_E');
	new nicEditor({fullPanel : true}).panelInstance('Ourthinking');
	new nicEditor({fullPanel : true}).panelInstance('Ourthinking_E');
    new nicEditor({fullPanel : true}).panelInstance('Ourgrowth');
	new nicEditor({fullPanel : true}).panelInstance('Ourgrowth_E');
	new nicEditor({fullPanel : true}).panelInstance('Ourfocus');
	new nicEditor({fullPanel : true}).panelInstance('Ourfocus_E');
	
	new nicEditor({fullPanel : true}).panelInstance('Practical');
	new nicEditor({fullPanel : true}).panelInstance('Practical_E');
	
	
	new nicEditor({fullPanel : true}).panelInstance('Confidence');
	new nicEditor({fullPanel : true}).panelInstance('Confidence_E');
	
	new nicEditor({fullPanel : true}).panelInstance('Forgetting');
	new nicEditor({fullPanel : true}).panelInstance('Forgetting_E');
	
	
	new nicEditor({fullPanel : true}).panelInstance('Feature');
	new nicEditor({fullPanel : true}).panelInstance('Feature_E');
	
    new nicEditor({fullPanel : true}).panelInstance('Map');


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
                        <div class="title_right">
                            <h4 style="text-align:right; ">معلومات التواصل والتعريف للموقع</h4>
                        </div>
                       
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title" >
                                    <h5 style="text-align:right; float:right;">حاول تعئبة الحقول بالشكل الكامل  </h5>
                                    
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
                                
                                
                                    <form id="demo-form2" method="post" action="Edit_About_us.php" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                                    
                                           
    <script type="text/javascript">
        $("body").on("click", "#btnUpload", function () {
            var allowedFiles = [".jpg",".pjpg",".png"];
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

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Title">إسم الشركة  <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" style="text-align:right; direction:rtl;" id="Title" name="Title" value="<?php echo $row['Title']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="E_Title">Combany Title <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Title_E" name="Title_E" value="<?php echo $row['Title_E']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">خريطة الموقع<span class="required">*</span>
                                            </label>
                                             <div class="col-md-8 col-sm-8 col-xs-12">  
                                            <textarea cols="60" id="Map" name="Map" style="width:72%"><?php echo $row['Map']; ?> </textarea>
                                            </div>
                                        </div>
                                        
                                                                                <br>
<br>

                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">جوال<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Mobile" name="Mobile" value="<?php echo $row['Mobile']; ?>"  required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">هاتف<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Phone" name="Phone" value="<?php echo $row['Phone']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                    
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">فاكس<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Fax" name="Fax" value="<?php echo $row['Fax']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">البريد الإلكتروني<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Email" name="Email" value="<?php echo $row['Email']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                                                                <br>
<br>

                                        
                                          <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Facebook">Facebook<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Facebook" name="Facebook" value="<?php echo $row['Facebook']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                       
                                       <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Twitter">Twitter<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Twitter" name="Twitter" value="<?php echo $row['Twitter']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                       
                                          
                                       <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Instagram">Youtube<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Youtube" name="Youtube" value="<?php echo $row['Youtube']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Instagram">Google<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Google" name="Google" value="<?php echo $row['Google']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Instagram">Instagram<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Instagram" name="Instagram" value="<?php echo $row['Instagram']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                         <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Instagram">Whatsapp<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Whatsapp" name="Whatsapp" value="<?php echo $row['Whatsapp']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        

                                         <div class="form-group">
                                             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Instagram">Linkedin<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Linkedin" name="Linkedin" value="<?php echo $row['Linkedin']; ?>"  class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                       
                                       
                                                                               <br>
<br>

                                       
                                       <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Address">العنوان<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Address" name="Address" value="<?php echo $row['Address']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                 
                 
                 
                                      <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Address<span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" id="Address_E" name="Address_E" value="<?php echo $row['Address_E']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                                         <br>
<br>

			 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">من نحن<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="About_as" name="About_as" style="width:72%"><?php echo $row['About_as']; ?> </textarea>

				  </div>
			</div>

			

                  <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Abous Us<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="About_as_E" name="About_as_E" style="width:72%"><?php echo $row['About_as_E']; ?> </textarea>
				  </div>
			</div>
            
            
            
            <br>
<br>






		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">  الرؤية <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Ourthinking" name="Ourthinking" style="width:72%"><?php echo $row['Ourthinking']; ?> </textarea>

				  </div>
			</div>

			

                  <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Our Vision<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Ourthinking_E" name="Ourthinking_E" style="width:72%"><?php echo $row['Ourthinking_E']; ?> </textarea>
				  </div>
			</div>
            
            
            <br>
<br>





		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">  الرسالة <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Ourgrowth" name="Ourgrowth" style="width:72%"><?php echo $row['Ourgrowth']; ?> </textarea>

				  </div>
			</div>

			

                  <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Our Message<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Ourgrowth_E" name="Ourgrowth_E" style="width:72%"><?php echo $row['Ourgrowth_E']; ?> </textarea>
				  </div>
			</div>
            
            <br>
<br>




		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map"> الطموح  <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Ourfocus" name="Ourfocus" style="width:72%"><?php echo $row['Ourfocus']; ?> </textarea>

				  </div>
			</div>

			

             <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Our Mission<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Ourfocus_E" name="Ourfocus_E" style="width:72%"><?php echo $row['Ourfocus_E']; ?> </textarea>
				  </div>
			</div>
            
            
            
            
                        <br>
<br>




		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map"> العملية  <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Practical" name="Practical" style="width:72%"><?php echo $row['Practical']; ?> </textarea>

				  </div>
			</div>

			

             <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Practical<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Practical_E" name="Practical_E" style="width:72%"><?php echo $row['Practical_E']; ?> </textarea>
				  </div>
			</div>





            <br>
<br>




		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map"> الثقة  <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Confidence" name="Confidence" style="width:72%"><?php echo $row['Confidence']; ?> </textarea>

				  </div>
			</div>

			

             <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Confidence<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Confidence_E" name="Confidence_E" style="width:72%"><?php echo $row['Confidence_E']; ?> </textarea>
				  </div>
			</div>





            <br>
<br>




		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map"> النسيان  <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Forgetting" name="Forgetting" style="width:72%"><?php echo $row['Forgetting']; ?> </textarea>

				  </div>
			</div>

			

             <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Forgetting<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Forgetting_E" name="Forgetting_E" style="width:72%"><?php echo $row['Forgetting_E']; ?> </textarea>
				  </div>
			</div>
            
            
            
            
                        <br>
<br>




		 <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map"> الميزة  <span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
                 <textarea cols="60" id="Feature" name="Feature" style="width:72%"><?php echo $row['Feature']; ?> </textarea>

				  </div>
			</div>

			

             <div class="form-group">
               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">Feature<span class="required">*</span>  </label>
                <div class="col-md-8 col-sm-8 col-xs-12">  
				<textarea cols="60" id="Feature_E" name="Feature_E" style="width:72%"><?php echo $row['Feature_E']; ?> </textarea>
				  </div>
			</div>




<br>
<br>
<br>



<div class="form-group">

               <label class="control-label col-md-3 col-sm-3 col-xs-12" for="Map">صورة من نحن<span class="required"></span>  </label>

                  <table  class="control-label col-md-10 col-sm-10 col-xs-12" style=" border:hidden; " >
               <tr>
    <td  style="vertical-align:middle;" align="right" >   <span class="btn btn-file" style="font-size:14px; "><input   class="btn btn-success" type="file" name="Image" id="Image"/></span>
    
     <br />
   <center> <span id="lblError" style="color:#900;"></span> </center>
    <br />
    </td>
    <td  style="font-size:14px; vertical-align:middle; text-align:center; font-weight:700;">  
     <img
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
width:auto; height:200px;
" 
 src="../image/Home/<?php echo $row['image']; ?>"  /></td>
  </tr>
  </table>
                </div> 
                                       
                                       
                                       
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                                <button type="submit"  id="btnUpload" class="btn btn-success">تعديل المعلومات</button>
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