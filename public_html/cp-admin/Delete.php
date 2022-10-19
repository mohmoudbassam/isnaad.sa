<?php session_start();?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("include/dataconnect.php");
$idProduct=$_GET["idProduct"];
$Amount=$_GET["Amount"];
unset($_SESSION['pro'][$idProduct]);

unset($_SESSION['Cart'][$idProduct]);

 $q="select * from product where idProduct=$idProduct";
 $r=mysql_query($q,$link);
 $row=@mysql_fetch_array($r);
 
 $Price=$row['Price'];	
 $Cost=$Price*$Amount;
 
 $_SESSION['total']-=$Cost;
					
				
 
  echo'	<section id="cart_items">
		<div class="container">
			<br>
<br>
';
					
				
 
 if(isset($_SESSION['Cart']) && ($_SESSION['Cart'] != NULL) )
   {
		
		$_SESSION['Table']=' 
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">رقم المنتج</td>
							<td class="description">الوصف</td>
							<td class="price">السعر</td>
							<td class="quantity">الكمية</td>
							<td class="total">المجموع</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
	
	
	';
		foreach($_SESSION['Cart'] as $x => $x_value) 
  {
			
	$_SESSION['Table'].=$_SESSION['pro'][$x];
	
	}
	echo $_SESSION['Table'];

	 echo'           
					</tbody>
				</table>
			</div>

          
            
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3></h3>
				<p style="text-align:right;">قم بإتمام عملية الدفع</p>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_option">
							<li>
								<input type="checkbox">
								<label>Use Coupon Code</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Use Gift Voucher</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Estimate Shipping & Taxes</label>
							</li>
						</ul>
						<ul class="user_info">
							<li class="single_field">
								<label>Country:</label>
								<select>
									<option>United States</option>
									<option>Bangladesh</option>
									<option>UK</option>
									<option>India</option>
									<option>Pakistan</option>
									<option>Ucrane</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
								
							</li>
							<li class="single_field">
								<label>Region / State:</label>
								<select>
									<option>Select</option>
									<option>Dhaka</option>
									<option>London</option>
									<option>Dillih</option>
									<option>Lahore</option>
									<option>Alaska</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
							
							</li>
							<li class="single_field zip-field">
								<label>Zip Code:</label>
								<input type="text">
							</li>
						</ul>
						<a class="btn btn-default update" href="">Get Quotes</a>
						<a class="btn btn-default check_out" href="">Continue</a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li style="text-align:right; direction:rtl;">مجموع مشتريات السلة  <span>'.$_SESSION['total'].' ريال</span></li>
							<li style="text-align:right; direction:rtl;">تكلفة الشحن <span> 50 ريال</span></li>
							<li style="text-align:right; direction:rtl;">التكلفة النهائية  <span>'; 
							$F=$_SESSION['total']+50;
							echo $F;
							echo ' ريال</span></li>
						</ul>
							<a class="btn btn-default check_out" href="">أتمم الشراء</a>
					</div>
				</div>
				';
				 }
				 	   else
	   {
		   
		  echo' <div class="heading">
				<h3></h3>
				<br>
				<p style="text-align:center;">سلتك فارغة  <a href="index.php"> قم بالتسوق الأن </a></p>
				<br>
                <br>
			    </div>';
		   
	   }

echo'

	</div>
		</div>
	</section><!--/#do_action-->

';
?>			





 