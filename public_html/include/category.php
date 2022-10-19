<?php
		 


  echo' 
  <br />

  <section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>قائمة المنتجات</h2>
						<div class="panel-group category-products" id="accordian" ><!--category-productsr-->';
						
						   $sql_Section="select * from section where Sho =2 ";
		                        $r_Section=mysql_query($sql_Section,$link); 
                                while ($Section=@mysql_fetch_array($r_Section))
		                         {
							
						echo'	<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordian" href="#'.$Section['idSection'].'">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
											'.$Section['Name'].'
										</a>
									</h4>
								</div>
								<div id="'.$Section['idSection'].'" class="panel-collapse collapse">
									<div class="panel-body">
										<ul>';
										  $i=$Section['idSection'];
									 $sql_Catg="select * from category Where F_Section='$i'";
		                        $r_Catg=mysql_query($sql_Catg,$link); 
                                while ($Catg=@mysql_fetch_array($r_Catg))
		                         {
                                  echo' <li><a href="Products.php?id='.$Catg['idCategory'].'">'.$Catg['Name'].' </a></li>';
								 }
									echo'	
										</ul>
									</div>
								</div>
							</div>';
								 }
							
							
							
					echo'	</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>الوكيل الحصري </h2>
							<div class="brands-name">
								<img src="images/11.png" style="height:200px; width:auto;"  alt="" />
							</div>
						</div><!--/brands_products-->
						
					
						
						<div class="shipping text-center"><!--shipping-->
							<img src="images/home/shipping.jpg"  alt="" />
						</div><!--/shipping-->
					
					</div>
				</div>
				
  
  
   ';
                    ?>