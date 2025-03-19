<?php
session_start();

extract($_REQUEST);
include("../connection.php");
$gtotal=array();
$ar=array();
$total=0;
if(isset($_GET['product']))//product id
{
	$product_id=$_GET['product'];
}
else
{
	$product_id="";
}
 if(isset($_SESSION['cust_id']))
 {
 $cust_id=$_SESSION['cust_id'];
 $qq=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
	 $qqr= mysqli_fetch_array($qq);
 }
if(empty($cust_id))
{
	header("location:index.php?msg=you must login first");
}
if(!empty($product_id && $cust_id ))
{
if(mysqli_query($con,"insert into tblcart (fld_product_id,fld_customer_id) values ('$product_id','$cust_id') "))
{
	$product_id="";
	header("location:cart.php");
}
else
{
	echo "failed";
}
}
if(isset($del))
{
	
	if(mysqli_query($con,"delete from tblcart where fld_cart_id='$del' && fld_customer_id='$cust_id'"))
	{
		header("location:deletecart.php");
	}
	
}
 
 
 if(isset($logout))
 {
	 session_destroy();
	 
	 header("location:../index.php");
 }
 if(isset($login))
 {
	 session_destroy();
	 
	 header("location:index.php");
 }
 
 //update section
  $cust_details=mysqli_query($con,"select * from tblcustomer where fld_email='$cust_id'");
  $det_res=mysqli_fetch_array($cust_details);
  $fld_name=$det_res['fld_name'];
  $fld_email=$det_res['fld_email'];
  $fld_mobile=$det_res['fld_mobile'];
  $fld_password=$det_res['password'];
  if(isset($update))
  {
	   
	 if(mysqli_query($con,"update tblcustomer set fld_name='$name',fld_mobile='$mobile',password='$pswd' where fld_email='$fld_email'"))
      {
	   header("location:customerupdate.php");
	  }
  }
  
  $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
  $re=mysqli_num_rows($query);
  
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HomeBites | Cart</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
     <style>
		ul li{list-style:none;}
		ul li a {color:black;text-decoration:none; }
		ul li a:hover {color:black;text-decoration:none; }
		
	 </style>
	 <script>
		  function del(id)
		  {
			  if(confirm('Are you sure?')== true)
			  {
				  window.location.href='cancelorder.php?id=' +id;
			  }
		  }
		</script>

</head>
<body>
<style>
    /* Slightly dark transparent navbar */
    .navbar {
        background: rgba(52, 50, 50, 0.85) !important;
        backdrop-filter: blur(5px);
        transition: all 0.3s ease-in-out;
    }

    .navbar-brand {
        font-weight: bold;
        color: #fff !important;
        font-size: 24px;
    }

    .nav-item a {
        font-size: 18px;
        font-weight: 500;
    }

    .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">
            <i class="fas fa-utensils"></i> HomeBites
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07"
            aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?php if (!empty($cust_id)) { ?>
                        <a class="navbar-brand" style="color:#1fafdb; text-decoration:none;">
                            <i class="far fa-user"></i> <?php if (isset($cust_id)) { echo $qqr['fld_name']; } ?>
                        </a>
                    </li>
                    <?php } ?>

                    <?php if (empty($cust_id)) { ?>
                        <a href="form/index.php?msg=you must be login first">
                            <span style="color:red; font-size:20px;">
                                <i class="fa fa-shopping-cart" aria-hidden="true">
                                    <span style="color:red;" id="cart" class="badge badge-light">0</span>
                                </i>
                            </span>
                        </a>
                        &nbsp;
                        <button class="btn btn-outline-danger my-2 my-sm-0" name="login" type="submit">Log In</button>&nbsp;&nbsp;&nbsp;
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="cart.php">
                                <span style="color:green; font-size:20px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true">
                                        <span style="color:green;" id="cart" class="badge badge-light">
                                            <?php if (isset($re)) { echo $re; } ?>
                                        </span>
                                    </i>
                                </span>
                            </a>
                            <a href="../logout.php">
                                <button class="btn btn-success my-2 my-sm-0" type="submit">Log Out</button>
                            </a>
                        </li>
                    <?php } ?>
            </ul>
            <form class="form-inline my-2 my-md-0">
                <a href="../sellerSignUp.php">
                    <button type="button" class="btn btn-lg btn-block btn-primary">
                        HomeBites Business <i class="fas fa-arrow-circle-right"></i>
                    </button>
                </a>
            </form>
        </div>
    </div>
</nav>


<br><br>
<div class="container" style="  padding:60px; border:1px solid red;">
       <!--tab heading-->
	   <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" style="color:black ;" id="viewitem-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="viewitem" aria-selected="true">View Cart</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" style="color:black;" id="manageaccount-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="manageaccount" aria-selected="false">Account Settings</a>
          </li>
		  <li class="nav-item">
              <a class="nav-link" style="color:black;" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">Orders</a>
          </li>
		  
       </ul>
	   <br>

<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
    <div class="table-responsive">    
		<table class="table">
            <tbody>
				<th></th>
				<th>Item Name</th>
				<th>Price</th>
				<th>Cuisine</th>
				<th>Restaurant Name</th>
	               <?php
	                  $query=mysqli_query($con,"select tbfood.foodname,tbfood.fldvendor_id,tbfood.cost,tbfood.cuisines,tbfood.fldimage,tblcart.fld_cart_id,tblcart.fld_product_id,tblcart.fld_customer_id from tbfood inner  join tblcart on tbfood.food_id=tblcart.fld_product_id where tblcart.fld_customer_id='$cust_id'");
	                  $re=mysqli_num_rows($query);
	                   if($re)
	                    {
		                 while($res=mysqli_fetch_array($query))
		                  {
			                $vendor_id=$res['fldvendor_id'];
			               $v_query=mysqli_query($con,"select * from tblvendor where fldvendor_id='$vendor_id'");
			               $v_row=mysqli_fetch_array($v_query);
			               $em=$v_row['fld_email'];
			               $nm=$v_row['fld_name'];
	                ?>
                <tr>
                         <td><image src="../image/restaurant/<?php echo $em."/foodimages/".$res['fldimage'];?>" height="80px" width="100px"></td>
                         <td><?php echo $res['foodname'];?></td>
                         <td><?php echo "Rs. ".$res['cost'];?></td>
                         <td><?php echo $res['cuisines'];?></td>
                         <td><?php echo $nm; ?></td>
		                <form method="post" enctype="multipart/form-data">
                           <td><button type="submit" name="del"  value="<?php echo $res['fld_cart_id']?>" class="btn btn-danger">Delete</button></td>
                        </form>
                        <td><?php $total=$total+$res['cost']; $gtotal[]=$total;  ?></td>
                      </tr>
					  
					  
                   <?php
	                    }
						?>
						<tr>
					  <td>
					  <h5 style="color:red;">Grand total</h5>
					  </td>
					  <td>
					  <h5><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo end($gtotal); ?></h5>
					  </td>
					  <td>
					  
					  </td>
					  <td></td>
					  
					  <td style="padding:30px; text-align:center;">
					  <a href="order.php?cust_id=<?php echo $cust_id; ?>"><button type="button" style=" color: #5d5d5d; font-weight:bold; text-transform:uppercase;" class="btn btn-warning">Proceed to checkout</button></a>
					  </td>
					  <td></td>
					  </tr>
						
						<?php
	
	                  }
					  else
					  {
						  
	
	                 ?>
					 <tr><button type="button" class="btn btn-outline-success"><a href="../index.php" style="color:green; text-decoration:none;">No Items In cart Let's Shop Now</a></button></tr>
					 
					 <?php
					  }
					 ?>
                 </tbody>
	    </table>	
		</div> 
		<span style="color:green; text-align:centre;"><?php if(isset($success)) { echo $success; }?></span>
		       
    </div>	 
	  
<div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="manageaccount-tab">
	<form method="post" enctype="multipart/form-data">
    	<div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" value="<?php if(isset($fld_name)){ echo $fld_name;}?>" class="form-control" name="name" required="required"/>
        </div>
		<div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php if(isset($fld_email)){ echo $fld_email;}?>" class="form-control"  readonly/>
        </div>
					<div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="tel" id="mobile" class="form-control" name="mobile" pattern="[6-9]{1}[0-9]{2}[0-9]{3}[0-9]{4}" value="<?php if(isset($fld_mobile)){ echo $fld_mobile;}?>" placeholder="" required>
                    </div>
					
                   <div class="form-group">
                      <label for="pwd">Password:</label>
                     <input type="password" name="pswd" value="<?php if(isset($fld_password)) { echo $fld_password; }?>"class="form-control"  id="pwd" required/>
                   </div>
				   
				   
 
                  <button type="submit" name="update" style="background:#ED2553; border:1px solid #ED2553;" class="btn btn-primary">Update</button>
                  <div class="footer" style="color:red;"><?php if(isset($ermsg)) { echo $ermsg; }?><?php if(isset($ermsg2)) { echo $ermsg2; }?></div>
			 </form>
			</div>
			<!--tab 2 ends-->
			 <!--tab 3 starts-->
    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
	<div class="table-responsive">
		<table class="table">
				<th>Order Number</th>
				<th>Item Name</th>
				<th>Price</th>
				<th>Cancel order</th>
				    <tbody>
					<?php
					$quer_res=mysqli_query($con,"select * from tblorder where fld_email_id='$cust_id' && fldstatus='In Process'");
					while($roww=mysqli_fetch_array($quer_res))
					{   
				         $fid=$roww['fld_food_id'];
				         $qr=mysqli_query($con,"select * from tbfood where food_id='$fid'");
						 $qrr=mysqli_fetch_array($qr);
						
					  
					?>
					   <tr>
					   <td><?php echo $roww['fld_order_id']; ?></td>
					   <?php
					   if(empty($qrr['foodname']))
					   {
					   ?>
					   <td><span style="color:red;">Product Not Available Now</span></td>
					   <?php
					   }
					   else
					   {
						   ?>
						    <td><?php echo $qrr['foodname']; ?></td>
						   <?php
					   }
					   ?>
					  
					   <td><?php echo $qrr['cost']; ?></td>
					   <td><a href="#" onclick="del(<?php echo $roww['fld_order_id'];?>);"><button type="button" class="btn btn-danger">Cancel Order</button></a></td>
					   </tr>
					 <?php
					}
					 ?>  
					</tbody>
		</table>
		</div>
	</div>
</div>
</div>  
	  
	<footer class="container">
        <p class="float-right"><a href="#">Back to top</a></p>
      </footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>