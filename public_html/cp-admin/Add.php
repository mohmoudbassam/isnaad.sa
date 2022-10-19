<?php session_start(); 
 
 if(!isset($_SESSION['i']))
   {
	$_SESSION['i']=1;     
   }
    if(!isset($_SESSION['total']))
   {
	$_SESSION['total']=0;     
   }
?>
<head> <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> </head>
<?php
include("include/dataconnect.php");
// Security one

if ( $_SESSION['User'] >0)
{ //1
$idProduct=$_GET["idProduct"];
$Num=$_GET["Num"];

 $q="select * from product where idProduct=$idProduct";
 $r=mysql_query($q,$link);
 $row=@mysql_fetch_array($r);
  $Price=$row['Price'];


$Cost=$Num*$Price;
$_SESSION['total']+=$Cost;

if(isset($_SESSION['Cart']))
{
$OK=0;
foreach($_SESSION['Cart'] as $x => $x_value) 
  {
	if ($x==$idProduct)
     $OK=1;
  }
}
else
{
$OK=0;	
}
  if($OK ==0)
{ //2
    
	
	$_SESSION['pro'][$idProduct]='	<tr>
							<td class="cart_product">
                            <p> '.$row['idProduct'].'</p>		
				         	</td>
							<td class="cart_description">
								<h5><a href="">'.$row['Name'].'</a></h5>
								
							</td>
							<td class="cart_price">
								<p>ريال '.$row['Price'].'</p>
							</td>
								
							<td class="cart_price">
								<p>'.$Num.'</p>
							</td>
							
							<td class="cart_total">
								<p class="cart_total_price">ريال ' .$Cost.'</p>
							</td>
							<td class="cart_delete">
						  <a class="cart_quantity_delete"  onclick="Delete('.$idProduct.','.$Num.');"><i class="fa fa-times"></i></a>
							</td>
						</tr>';


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
	
	
$_SESSION['i']=$_SESSION['i']+1;

if(isset($_SESSION['Cart']))
{
$_SESSION['Cart'][$idProduct]=$Num;		
}
else
{
	
	$_SESSION['Cart']= array($idProduct=>$Num);
}

	
	foreach($_SESSION['Cart'] as $x => $x_value) 
  {
			
	$_SESSION['Table'].=$_SESSION['pro'][$x];
	
	}
	
	 echo'           
					</tbody>
				</table>
			</div>';





echo ' <input type="hidden" name="id"  id="id"   value="'.$idProduct.'"/>
                                
									<span style="font-size:20px;">'.$Price.' ريال </span>
									<label>الكمية:</label>
									<input type="number" id="Num" name="Num" min="1" value="1" data-bind="value:replyNumber" />
                                   
                                   
									<button disabled type="button" onclick="Add()" style="margin-top:11px;" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										تمت الإضافة
									</button>
                                    ';

}//2
else
{//3
echo ' <input type="hidden" name="id"  id="id"   value="'.$idProduct.'"/>
                                
									<span style="font-size:20px;">'.$Price.' ريال </span>
									<label>الكمية:</label>
									<input type="number" id="Num" name="Num" min="1" value="1" data-bind="value:replyNumber" />
                                   
                                   
									<button disabled type="button" onclick="Add()" style="margin-top:11px;" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										مضاف مسبقا
									</button>
                                    ';
	
}//3

	

} //1
else
{ //5
		echo "<META HTTP-EQUIV='Refresh' Content='0;URL=login.php'>";
	
}//5
?>

