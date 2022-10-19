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
<script>



function Send()
{
	window.location="index.php";
	
}

function Log()
{
var User= document.getElementById("Username").value;
var Pass=document.getElementById("Password").value;

var url="log_in.php?User="+User+"&Pass="+Pass;	
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
	if (xmlhttp.responseText=='True')
	Send();
	else	
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


</script>
</head>

<body style="background:#F7F7F7;">
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
   <form id="form2" action="Log_In.php" >
                           <h1>Login Form</h1>
                        <div>
                            <input type="text" id="Username" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="password" id="Password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a id="AAA" class="btn btn-default submit" onClick="Log()">Log in</a>
                            <span id="myDiv"  style="color:#900;"></span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <p class="change_link">Lost your password?
                                <a href="#toregister" class="to_register"> Re Send Password </a>
                            </p>
                            <div class="clearfix"></div>
                            <br />
                            <div>
 <a href="index.html" class="site_title"> <span> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"> </span></a>
                                <p>©2019 All Rights Reserved </p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
            <div id="register" class="animate form">
                <section class="login_content">
   <form id="form2" action="ForgentPass.php" >
                        <h1>Re Send Password</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                       
                        <div>
                            <a class="btn btn-default submit" href="index.php">Submit</a>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <p class="change_link">Already a member ?
                                <a href="#tologin" class="to_register"> Log in </a>
                            </p>
                            <div class="clearfix"></div>
                            <br />
                            <div>
 <a href="index.html" class="site_title"> <span> <img src="images/sh.png" alt="..." style="width:100px; height:auto;"> </span></a>
                                <p>©2019 All Rights Reserved </p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

</body>

<script>
$(document).keypress(function(e) {
    if(e.which == 13) {
      Log ();
    }
});
</script>
</html>