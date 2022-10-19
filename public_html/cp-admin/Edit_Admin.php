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

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

<style>
.kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
    margin: 0;
    padding: 0;
    border: none;
    box-shadow: none;
    text-align: center;
}
.kv-avatar .file-input {
    display: table-cell;
    max-width: 220px;
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
                        <div class="title_left">
                            <h3>
                  
                </h3>
                        </div>

                        <div class="title_right">
                            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h2 style="float:right;">الملف الشخصي</h2>
                                    <ul class="nav navbar-left panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                      
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
<br>


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
                                     $Member=$_GET['id'];
		                             $sql="select * from admin  Where idAdmin='$Member'";
		                             $result=mysql_query($sql,$link);
		                             $row=mysql_fetch_array($result);
									 
                                   ?>
                                   <form class="form-horizontal form-label-left" novalidate id="demo-form2" method="post" action="Edit_Admin_Done.php" enctype="multipart/form-data" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="id"  id="hiddenField"   value="<?php echo $Member; ?>"/>
                                           
    


                                        <p > <code>تأكد من ملأ كامل التموذج</code>
                                        </p>



                                        <div class="item form-group">

                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                  <div class="avatar-view " style="margin-left:40%;" title="تغير الصورة">

                                                     <img src="images/img.jpg" alt="Avatar">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">الإسم الكامل  <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="Name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="Name"  required="required" value="<?php echo $row['Name']; ?>" type="text">
                                            </div>
                                        </div>
                                        
                                        
                                          <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">إسم المستخدم <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input id="Username" type="text" name="Username" value="<?php echo $row['Username']; ?>" data-validate-length-range="5" class="optional form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                        
                                     
                                        
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"  for="email">البريد الإلكتروني <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">تأكيد البريد <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="email" id="email2" value="<?php echo $row['Email']; ?>" name="confirm_email" data-validate-linked="email" required class="form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                      
                                      
                                        <div class="item form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">جوال <span class="required">*</span>
                                            </label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="Mobile" type="text" value="<?php echo $row['Mobile']; ?>" name="Mobile" data-validate-length-range="10" class="optional form-control col-md-7 col-xs-12">
                                            </div>
                                        </div>
                                        
                                     
                                        
                                        <div class="item form-group">
                                            <label for="password" class="control-label col-md-3">كلمة المرور</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="password" type="password" value="<?php echo md5($row['Password']); ?>" name="password" data-validate-length="6,8" class="form-control col-md-7 col-xs-12" required>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="password2" class="control-label col-md-3 col-sm-3 col-xs-12">تأكيد كلمة المرور</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input id="password2" type="password" value="<?php echo md5($row['Password']); ?>" name="password2" data-validate-linked="password" class="form-control col-md-7 col-xs-12" required>
                                            </div>
                                        </div>
                                        
                                       
                                        
                                  
                                       
                                       
                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-3">
                                                <button  type="submit" class="btn btn-success">تعديل </button>
                                            </div>
                                        </div>
                                    </form>



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
<br><br>
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
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
    <script>
        // initialize the validator function
        validator.message['date'] = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);

        $('.multi.required')
            .on('keyup blur', 'input', function () {
                validator.checkField.apply($(this).siblings().last()[0]);
            });

        // bind the validation to the form submit event
        //$('#send').click('submit');//.prop('disabled', true);

        $('form').submit(function (e) {
            e.preventDefault();
            var submit = true;
            // evaluate the form using generic validaing
            if (!validator.checkAll($(this))) {
                submit = false;
            }

            if (submit)
                this.submit();
            return false;
        });

        /* FOR DEMO ONLY */
        $('#vfields').change(function () {
            $('form').toggleClass('mode2');
        }).prop('checked', false);

        $('#alerts').change(function () {
            validator.defaults.alerts = (this.checked) ? false : true;
            if (this.checked)
                $('form .alert').remove();
        }).prop('checked', false);
    </script>

</body>

</html>