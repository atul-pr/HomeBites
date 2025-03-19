<?php
session_start();
include("connection.php");
extract($_REQUEST);
if(isset($_SESSION['id']))
{
 $id=$_SESSION['id'];
 $vq=mysqli_query($con,"select * from tblvendor where fld_email='$id'");
 $vr=mysqli_fetch_array($vq);
 $vrid=$vr['fldvendor_id'];
}

if(!isset($_SESSION['id']))
{
	header("location:sellerSignIn.php?msg=Please Login To continue");
}
else
{
$query=mysqli_query($con,"select * from tblvendor   where fld_email='$id'");
if(mysqli_num_rows($query))
{   if(!file_exists("image/restaurant/".$id."/foodimages"))
	{
		$dir=mkdir("image/restaurant/".$id."/foodimages");
	}
	$row=mysqli_fetch_array($query);
    $v_id=$row['fldvendor_id'];
}
else
{
	
	header("location:index.php");
	
	
}
}


if(isset($add))
{   if(isset($_SESSION['id']))
	{
    $img_name=$_FILES['food_pic']['name'];
    if(!empty($chk)) 
	{
	$paymentmode=implode(",",$chk);
	if(mysqli_query($con,"insert into tbfood(fldvendor_id,foodname,cost,cuisines,paymentmode,fldimage) values
	
	('$v_id','$food_name','$cost','$cuisines','$paymentmode','$img_name')"))
	{
        move_uploaded_file($_FILES['food_pic']['tmp_name'],"image/restaurant/$id/foodimages/".$_FILES['food_pic']['name']);
        header("location:dashboard.php");
	}
	else{
		echo "failed";
	}
  }
  else 
  {
	  $paymessage="Please select food type";
  }
	}
	else
	{
		header("location:sellerSignIn.php");
	}
}

if(isset($logout))
{
	session_destroy();
	header("location:index.php");
}
			  
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HomeBites | Dashboard</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>

<style>
		ul li{}
		ul li a {color:white;padding:40px; }
		ul li a:hover {color:white;}
	 </style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background: rgba(57, 55, 55, 0.85);">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="index.php">
    <i class="fas fa-utensils"></i> <strong>HomeBites</strong>
</a>

        	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          	<span class="navbar-toggler-icon"></span>
        	</button>

        	<div class="collapse navbar-collapse" id="navbarsExample07">
         		<ul class="navbar-nav mr-auto">
          			<li class="nav-item">
          				<?php
							if(!empty($id))
								{
						?>
						<a class="navbar-brand" style="color:white; text-decoration:none;"><i class="far fa-user"> </i>  Welcome , <?php if(isset($id)) { echo $vr['fld_name']; }?></a>
						<?php
								}
						?>
                    </li>
		  	    </ul>
          <form class="form-inline my-2 my-md-0">
          	<?php
				if(empty($_SESSION['id']))
					{
			?>
		   	<button class="btn btn-outline-danger my-2 my-sm-0" name="login"><i class="fas fa-sign-in-alt"></i> Log In</button>
            <?php
					}
			else
					{
			?>
			<button class="btn btn-outline-success my-2 my-sm-0" name="logout" type="submit"><i class="fas fa-sign-out-alt"></i> Log Out</button>
			<?php
					}
			?>
          </form>
        	</div>
    </div>
</nav> 
<br>
<div class="container">
    <main role="main">
        <div class="jumbotron" style="background: url(assets/images/foodthumb2.jpg) margin-top: 200px; / cover;">
          <div class="col-sm-8 mx-auto">
            <h1>Thank You for joining with us.</h1>
            <h4>Account Details</h4>
			<?php
				$vendor = "SELECT * FROM tblvendor where fld_email='$id'";
        		$res_data = mysqli_query($con,$vendor);
				while($row = mysqli_fetch_array($res_data))
					{
			?>
            <p><i class="fas fa-utensils"></i> <?php echo $row['fld_name']; ?><br>
			<i class="fas fa-envelope"></i> <?php echo $row['fld_email']; ?><br>
			<i class="fas fa-phone-square"></i> <?php echo $row['fld_mob']; ?><br>
			<i class="fas fa-map-marked-alt"></i> <?php echo $row['fld_address']; ?>		
			</p>
			<?php
					}
			?>
          </div>
        </div>
    </main>
</div>
<div class="container" style=" padding:40px; border:1px solid #ED2553;  width:100%;">
      
	   <ul class="nav nav-tabs nabbar_inverse" id="myTab" style="background:#ED2553;border-radius:10px 10px 10px 10px;" role="tablist">
          <li class="nav-item">
             <a class="nav-link active" id="home-tab" data-toggle="tab" href="#viewitem" role="tab" aria-controls="home" aria-selected="true">MENU</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#manageaccount" role="tab" aria-controls="profile" aria-selected="false">ADD DISH</a>
          </li>
		  <li class="nav-item">
              <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" role="tab" aria-controls="status" aria-selected="false">ORDER STATUS</a>
          </li>
		  
       </ul>
	   <br><br>
	   <span style="color:green;"><?php if(isset($msgs)) { echo $msgs; }?></span>
	  
	   <div class="tab-content" id="myTabContent">
	   
            <div class="tab-pane fade show active" id="viewitem" role="tabpanel" aria-labelledby="home-tab">
            <div class="container table-responsive"> 
			 <table border="1" bordercolor="#F0F0F0" cellpadding="20px">
			 <th>Image</th>
			 <th>Name</th>
			 <th>Cost/person</th>
			 <th>Cuisine</th>
			 <th>Dish Type</th>
			 <th>Delete Item</th>
			   <?php
					  if($query=mysqli_query($con,"select tblvendor.fldvendor_id,tblvendor.fld_email,tbfood.food_id,tbfood.foodname,tbfood.cost,tbfood.paymentmode,tbfood.cuisines,tbfood.fldimage,tblvendor.fld_name from tblvendor inner join tbfood on tblvendor.fldvendor_id=tbfood.fldvendor_id where tblvendor.fld_email='$id'"))
					  {
						  if(mysqli_num_rows($query))
						  {
						 while($row=mysqli_fetch_array($query))
						 {
			    ?>
			     <tr>
				 				 
				<td><img src="<?php echo 'image/restaurant/'.$id.'/foodimages/'.$row['fldimage'];?>" height="100px" width="150px"></td>
				<td style="width:150px;"><?php  echo $row['foodname']."<br>";?></td>
				<td align="center" style="width:150px;"><?php  echo $row['cost']."<br>";?></td>
				<td  align="center" style="width:150px;"><?php  echo $row['cuisines']."<br>";?></td>
				<td align="center" style="width:150px;"><?php  echo $row['paymentmode']."<br>";?></td>
				
				<td align="center" style="width:150px;">
				
				<a href="vendor_delete_food.php?food_id=<?php echo $row['food_id'];?>"><button type="button" class="btn btn-warning">Delete </button></a>
				
				</td>
				</tr>
				
				<?php 
					
                    $foodname="";
                    $cuisines="";
                    $cost="";					
						 }
					  }
					  else 
						  
						  {
							   $msg="please add some Items";
						  }
					  }
					  else 
					  {
						  echo "failed";
					  }
					  
					  ?>
			 </table>
			 </div>    	 
	        </div>
			
            <div class="tab-pane fade" id="manageaccount" role="tabpanel" aria-labelledby="profile-tab">
			         <!--add dish-->
                <form action="" method="post" enctype="multipart/form-data">
            		<div class="form-group">
                         <label for="food_name">Dish Name:</label>
                            <input type="text" class="form-control" id="food_name" value="<?php if(isset($food_name)) { echo $food_name;}?>" placeholder="Enter Dish Name" name="food_name" required>
                    </div>
							 
							 
                    <div class="form-group">
                        <label for="cost">Price:</label>
                            <input type="number" class="form-control" id="cost"  value="<?php if(isset($cost)) { echo $cost;}?>" placeholder="Enter Dish Price" name="cost" required>
                    </div>
							 				 
	                <div class="form-group">
                        <label for="cuisines">Cuisines:</label>
                            <input type="text" class="form-control" id="cuisines" value="<?php if(isset($cuisines)) { echo $cuisines;}?>" placeholder="Enter Cuisines" name="cuisines" required>
                    </div>
							        
					<div class="form-group">
                        <label for="Food Type">Food Type:  </label><br>
                            <input type="radio" name="chk[]" value="Veg"/> Veg<br>
			                <input type="radio" name="chk[]" value="Non-Veg"/> Non-Veg
						    <br>
						    <span style="color:red;"><?php if(isset($paymessage)){ echo $paymessage;}?></span>
			      	</div>
						
	                <div class="form-group">
                        Food Snaps <br>
                            <input type="file" accept="image/*" name="food_pic" required/> 
                            </div>
                            <button type="submit" name="add" class="btn btn-primary">Add Dish</button>
							<br>
							<span style="color:red;"><?php if (isset($msg)){ echo $msg;}?></span>
                </form>
				   
			</div>

			<div class="tab-pane fade table-responsive" id="status" role="tabpanel" aria-labelledby="status-tab">
	            <table class="table">
				<thead>
				<tr>
				<th>Order Id</th>
				<th>Customer Email</th>
				<th>Food Id</th>
				<th>Quantity</th>
				<th>Order Status</th>
				<th>Update Status</th>
				</tr>
				</thead>
				<tbody>
			<?php
				$orderquery=mysqli_query($con,"select * from tblorder where fldvendor_id='$vrid'");
				if(mysqli_num_rows($orderquery))
				{
					while($orderrow=mysqli_fetch_array($orderquery))
					{
						$stat=$orderrow['fldstatus'];
						?>
						<tr>
						<td><?php echo $orderrow['fld_order_id']; ?></td>
						<td><?php echo $orderrow['fld_email_id']; ?></td>
						<td><?php echo $orderrow['fld_food_id']; ?></td>
						<td><?php echo isset($orderrow['fld_quantity']) ? $orderrow['fld_quantity'] : '1'; ?></td>
			   <?php
			   if($stat=="cancelled" || $stat=="Out Of Stock")
			   {
			   ?>
			   <td><i style="color:orange;" class="fas fa-exclamation-triangle"></i>&nbsp;<span style="color:red;"><?php echo $orderrow['fldstatus']; ?></span></td>
			   <?php
			   }
			   else
				   
			   {
			   ?>
			   <td><span style="color:green;"><?php echo $orderrow['fldstatus']; ?></span></td>
			   <?php
			   }
			   ?>
				<form method="post">
				<td><a href="changestatus.php?order_id=<?php echo $orderrow['fld_order_id']; ?>"><button type="button" name="changestatus" >Update Status</button></a></td>
				</form>
				<tr>
			<?php
					}
				}
			?>
				</tbody>
				</table>
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

