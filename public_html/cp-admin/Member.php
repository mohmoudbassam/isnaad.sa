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
    <!-- ion_range -->
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.css" />
    <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css" />

    <!-- colorpicker -->
    <link href="css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet">
    
    <script src="js/jquery.min.js"></script>

  <script>
function Delete(id,user)
{
	if(confirm("هل أنت متأكد من عملية الحذف ؟  "))
{	

var url="Delete_Porduct1.php?id="+id+"&user="+user;	
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
                                    <h2 style="text-align:right; float:right; height:30px;">الملف الشخصي</h2>
                                  
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">

                                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                                        <div class="profile_img">


                                  <?php								
								 $Member= $_GET['id'];
								 $_SESSION['Member']=$Member;
								 $sql_Member="select * from user where idUser='$Member' ";
                                 $result_Member=mysql_query($sql_Member,$link);
								 $row_Member=mysql_fetch_array($result_Member);

									?>


                                            <!-- end of image cropping -->
                                            <div id="crop-avatar">
                                                <!-- Current avatar -->
                                                <div class="avatar-view" title="تغير الصورة">
                                                    <img src="../image/User/<?php echo $row_Member['Image']; ?>" alt="Avatar">
                                                </div>


                                                <!-- Loading state -->
                                                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                                            </div>
                                            <!-- end of image cropping -->

                                        </div>
<br>


                                        <ul class="list-unstyled user_data" style="margin-right:13%; text-align:justify; direction:rtl;">
                                             <li> <i class="fa fa-user user-profile-icon"></i> إسم العضو :  <span style="color:#3366FF;"> <?php echo $row_Member['Name']; ?> </span>

                                            <li> <i class="fa fa-briefcase user-profile-icon"></i> الإشتراك : 
                                            <?php 
											 if ($row_Member['Type']==2)                                           
                                            echo' <span style="color:#ffbf00;"> فنان </span>';
											
											else  if ($row_Member['Type']==1)
											echo' <span style="color:#00acd1;"> عادي  </span>'; 
											?>
                                            </li>

                                            <li>
                                                <i class="fa fa-money user-profile-icon"></i> النقاط : <span style="color:#DF0909;"> <?php echo $row_Member['Point']; ?> نقطة </span>
                                            </li>

                                          
                                        </ul>
<br>

                                      <?php  echo'<a  href="Profile.php?id='.$Member.'" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>تعديل الملف الشخصي</a>'; ?>
                                        <br />
<br>
<br>

                                        <!-- start skills -->
                                        <h4>تقييم العضو</h4>
                                        <ul class="list-unstyled user_data">
                                            <li>
                                                <p style="text-align:center;">المنتجات في موقعنا</p>
                                                <div class="progress progress_sm">
                                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="50"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <p style="text-align:center;">نسبة البيع</p>
                                                <div class="progress progress_sm">
                                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="70"></div>
                                                </div>
                                            </li>
                                            <li>
                                                <p style="text-align:center;">نسبة المشاهدة</p>
                                                <div class="progress progress_sm">
                                                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="30"></div>
                                                </div>
                                            </li>
                                           
                                        </ul>
                                        <!-- end of skills -->

                                    </div>
                                    <div class="col-md-9 col-sm-9 col-xs-12">

                                        <div class="profile_title">
                                            <div class="col-md-12">
                                                <h2 style="text-align:right;">المنتجات</h2>
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                              <div id="myDiv"> 
                                             <table class="table table-striped projects">
                                        <thead>
                                            <tr>
                                                <th style="width: 1%">#</th>
                                                <th style="width: 20%">إسم المنتج</th>
                                                <th>صلاحية الإعلان/ أيام</th>
                                                <th>صورة المنتج</th>
                                                <th>الظهور</th>
                                                <th>الحالة</th>
                                                <th style="width: 20%">#خيارات </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                            <?php								
								         $sql_P="select * from product where F_User='$Member' ";
                                         $result_P=mysql_query($sql_P,$link);
								         while($row_P=@mysql_fetch_array($result_P))
										 {
											 
											    $Product=$row_P['idProduct'];
											
		                                        $sql2="select * from product_image  Where F_Product='$Product'";
		                                        $result2=mysql_query($sql2,$link);
		                                         $row2=mysql_fetch_array($result2);

                                         echo'   <tr>
                                                <td>#</td>
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'">'.$row_P['Name'].'</a>
                                                   
                                                </td>
                                                <td>
                                                   
                                      ';
									  
									    
												
												
										  $S_Date=strtotime(date("Y/m/d"));
                                          $E_Date = strtotime($row_P['E_Date']); 
                                          $datediff = $E_Date- $S_Date ;
                                          $x= floor($datediff/(60*60*24));
										  $_SESSION['T']=$x;
										 
										 
										 if ($row_P['Type']==0)
										 {
										   echo '<div style="color:Green;">مفتوح</div>';
										 }
										 else
										 {
											  if ($x<=0)
											  {
												  $_SESSION['T']=0;
												   echo'<div style="color:Red;">إنتهت الفترة</div>';
												   
											  }
											 else
											 echo $x;
										 }
										 
										 
									
										
										  
									  
									  
                                               
                                        echo'        </td>
                                             
                                              <td>
                                                <img class="img-circle " style="width:70px; height:70px;" src="../image/Product/'.$row2['Link'].'" alt="">';
                                            
                                                echo'</td>
                                                <td>';
												if ($row_P['Sho']==2)
                                                    echo'<button type="button" class="btn btn-success btn-xs">ظاهر</button>';
										        else if($row_P['Sho']==1)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مخفي</button>';
                                                echo'
												</td>';
                                                   echo'<td>';
												if ($row_P['Sold']==2)
                                                    echo'<button type="button" class="btn btn-warning btn-xs">مباع</button>';
										        else if($row_P['Sold']==1)
                                                    echo'<button type="button" class="btn btn-success btn-xs">متاح</button>';
                                                echo'</td>';
												
											echo'
                                                <td>
                                                    <a href="Product.php?id='.$row_P['idProduct'].'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> تعديل </a>
                                                    <a href="#" class="btn btn-danger btn-xs"  onclick="Delete('.$row_P['idProduct'].','.$Member.');"><i class="fa fa-trash-o"></i> حذف </a>           
                                                </td>
                                            </tr>';
										 }
                                          ?>
                                          
                                        </tbody>
                                    </table>
                                        </div>    
                                               
                                            </div>
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
    <!-- daterangepicker -->
    <script type="text/javascript" src="js/moment.min2.js"></script>
    <script type="text/javascript" src="js/datepicker/daterangepicker.js"></script>
    <!-- input mask -->
    <script src="js/input_mask/jquery.inputmask.js"></script>
    <!-- knob -->
    <script src="js/knob/jquery.knob.min.js"></script>
    <!-- range slider -->
    <script src="js/ion_range/ion.rangeSlider.min.js"></script>
    <!-- color picker -->
    <script src="js/colorpicker/bootstrap-colorpicker.js"></script>
    <script src="js/colorpicker/docs.js"></script>

    <!-- image cropping -->
    <script src="js/cropping/cropper.min.js"></script>
    <script src="js/cropping/main2.js"></script>


    <!-- datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {

            var cb = function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange_right span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
            }

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'right',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };

            $('#reportrange_right span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

            $('#reportrange_right').daterangepicker(optionSet1, cb);

            $('#reportrange_right').on('show.daterangepicker', function () {
                console.log("show event fired");
            });
            $('#reportrange_right').on('hide.daterangepicker', function () {
                console.log("hide event fired");
            });
            $('#reportrange_right').on('apply.daterangepicker', function (ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            });
            $('#reportrange_right').on('cancel.daterangepicker', function (ev, picker) {
                console.log("cancel event fired");
            });

            $('#options1').click(function () {
                $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
            });

            $('#options2').click(function () {
                $('#reportrange_right').data('daterangepicker').setOptions(optionSet2, cb);
            });

            $('#destroy').click(function () {
                $('#reportrange_right').data('daterangepicker').remove();
            });

        });
    </script>
    <!-- datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {

            var cb = function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert("Callback has fired: [" + start.format('MMMM D, YYYY') + " to " + end.format('MMMM D, YYYY') + ", label = " + label + "]");
            }

            var optionSet1 = {
                startDate: moment().subtract(29, 'days'),
                endDate: moment(),
                minDate: '01/01/2012',
                maxDate: '12/31/2015',
                dateLimit: {
                    days: 60
                },
                showDropdowns: true,
                showWeekNumbers: true,
                timePicker: false,
                timePickerIncrement: 1,
                timePicker12Hour: true,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                opens: 'left',
                buttonClasses: ['btn btn-default'],
                applyClass: 'btn-small btn-primary',
                cancelClass: 'btn-small',
                format: 'MM/DD/YYYY',
                separator: ' to ',
                locale: {
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }
            };
            $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
            $('#reportrange').daterangepicker(optionSet1, cb);
            $('#reportrange').on('show.daterangepicker', function () {
                console.log("show event fired");
            });
            $('#reportrange').on('hide.daterangepicker', function () {
                console.log("hide event fired");
            });
            $('#reportrange').on('apply.daterangepicker', function (ev, picker) {
                console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
            });
            $('#reportrange').on('cancel.daterangepicker', function (ev, picker) {
                console.log("cancel event fired");
            });
            $('#options1').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
            });
            $('#options2').click(function () {
                $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
            });
            $('#destroy').click(function () {
                $('#reportrange').data('daterangepicker').remove();
            });
        });
    </script>
    <!-- /datepicker -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#single_cal1').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_1"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal2').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_2"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal3').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_3"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $('#single_cal4').daterangepicker({
                singleDatePicker: true,
                calender_style: "picker_4"
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#reservation').daterangepicker(null, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
        });
    </script>
    <!-- /datepicker -->
    <!-- input_mask -->
    <script>
        $(document).ready(function () {
            $(":input").inputmask();
        });
    </script>
    <!-- /input mask -->
    <!-- ion_range -->
    <script>
        $(function () {
            $("#range_27").ionRangeSlider({
                type: "double",
                min: 1000000,
                max: 2000000,
                grid: true,
                force_edges: true
            });
            $("#range").ionRangeSlider({
                hide_min_max: true,
                keyboard: true,
                min: 0,
                max: 5000,
                from: 1000,
                to: 4000,
                type: 'double',
                step: 1,
                prefix: "$",
                grid: true
            });
            $("#range_25").ionRangeSlider({
                type: "double",
                min: 1000000,
                max: 2000000,
                grid: true
            });
            $("#range_26").ionRangeSlider({
                type: "double",
                min: 0,
                max: 10000,
                step: 500,
                grid: true,
                grid_snap: true
            });
            $("#range_31").ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 30,
                to: 70,
                from_fixed: true
            });
            $(".range_min_max").ionRangeSlider({
                type: "double",
                min: 0,
                max: 100,
                from: 30,
                to: 70,
                max_interval: 50
            });
            $(".range_time24").ionRangeSlider({
                min: +moment().subtract(12, "hours").format("X"),
                max: +moment().format("X"),
                from: +moment().subtract(6, "hours").format("X"),
                grid: true,
                force_edges: true,
                prettify: function (num) {
                    var m = moment(num, "X");
                    return m.format("Do MMMM, HH:mm");
                }
            });
        });
    </script>
    <!-- /ion_range -->
    <!-- knob -->
    <script>
        $(function ($) {

            $(".knob").knob({
                change: function (value) {
                    //console.log("change : " + value);
                },
                release: function (value) {
                    //console.log(this.$.attr('value'));
                    console.log("release : " + value);
                },
                cancel: function () {
                    console.log("cancel : ", this);
                },
                /*format : function (value) {
                 return value + '%';
                 },*/
                draw: function () {

                    // "tron" case
                    if (this.$.data('skin') == 'tron') {

                        this.cursorExt = 0.3;

                        var a = this.arc(this.cv) // Arc
                            ,
                            pa // Previous arc
                            , r = 1;

                        this.g.lineWidth = this.lineWidth;

                        if (this.o.displayPrevious) {
                            pa = this.arc(this.v);
                            this.g.beginPath();
                            this.g.strokeStyle = this.pColor;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, pa.s, pa.e, pa.d);
                            this.g.stroke();
                        }

                        this.g.beginPath();
                        this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, a.s, a.e, a.d);
                        this.g.stroke();

                        this.g.lineWidth = 2;
                        this.g.beginPath();
                        this.g.strokeStyle = this.o.fgColor;
                        this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                        this.g.stroke();

                        return false;
                    }
                }
            });

            // Example of infinite knob, iPod click wheel
            var v, up = 0,
                down = 0,
                i = 0,
                $idir = $("div.idir"),
                $ival = $("div.ival"),
                incr = function () {
                    i++;
                    $idir.show().html("+").fadeOut();
                    $ival.html(i);
                },
                decr = function () {
                    i--;
                    $idir.show().html("-").fadeOut();
                    $ival.html(i);
                };
            $("input.infinite").knob({
                min: 0,
                max: 20,
                stopper: false,
                change: function () {
                    if (v > this.cv) {
                        if (up) {
                            decr();
                            up = 0;
                        } else {
                            up = 1;
                            down = 0;
                        }
                    } else {
                        if (v < this.cv) {
                            if (down) {
                                incr();
                                down = 0;
                            } else {
                                down = 1;
                                up = 0;
                            }
                        }
                    }
                    v = this.cv;
                }
            });
        });
    </script>
    <!-- /knob -->
</body>

</html>