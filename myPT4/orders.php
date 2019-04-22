<?php
session_start();
if (isset($_SESSION['username'])) {
  
  include_once 'nav_bar.php';
}else {
  header("location: login.php");
}
include_once 'orders_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>FunCraft Ordering System : Orders</title>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container-fluid wood">
      <div class="row">
        <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
          <div class="page-header">
            <h2>Create New Order</h2>
          </div>
          <form action="orders.php" method="post">
            <div class="form-group">
              <label for="orderid" class="col-sm-3 control-label">Order ID</label>
              <div class="col-sm-9">
                <input class="form-control" name="oid" type="text" placeholder="Order ID" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['fld_order_num']; ?>" required>
              </div>
            </div><br><br><br>
            <div class="form-group">
              <label for="orderdate" class="col-sm-3 control-label">Order Date</label>
              <div class="col-sm-9">
                <input class="form-control" name="orderdate" type="text" placeholder="Order Date" readonly value="<?php if(isset($_GET['edit'])) echo $editrow['fld_order_date']; ?>">
              </div>
            </div><br><br><br>
            <div class="form-group">
              <label for="orderstaff" class="col-sm-3 control-label">Staff</label>
              <div class="col-sm-9">
                <select name="sid"class="form-control" required>
                  <?php
                  try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $conn->prepare("SELECT * FROM tbl_staffs_a160979_pt2");
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                  }
                  catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                  }
                  foreach($result as $staffrow) {
                    ?>
                    <?php if((isset($_GET['edit'])) && ($editrow['fld_staff_num']==$staffrow['fld_staff_num'])) { ?>
                      <option value="<?php echo $staffrow['fld_staff_num']; ?>" selected><?php echo $staffrow['fld_staff_fname']." ".$staffrow['fld_staff_lname'];?></option>
                    <?php } else { ?>
                      <option value="<?php echo $staffrow['fld_staff_num']; ?>"><?php echo $staffrow['fld_staff_fname']." ".$staffrow['fld_staff_lname'];?></option>
                    <?php } ?>
                    <?php } // while
                    $conn = null;
                    ?> 
                  </select> 
                </div>
              </div><br><br><br>
              <div class="form-group">
                <label for="ordercustomer" class="col-sm-3 control-label">Customer</label>
                <div class="col-sm-9">
                  <select name="cid" class="form-control" required>
                    <?php
                    try {
                      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $stmt = $conn->prepare("SELECT * FROM tbl_customers_a160979_pt2");
                      $stmt->execute();
                      $result = $stmt->fetchAll();
                    }
                    catch(PDOException $e){
                      echo "Error: " . $e->getMessage();
                    }
                    foreach($result as $custrow) {
                      ?>
                      <?php if((isset($_GET['edit'])) && ($editrow['fld_customer_num']==$custrow['fld_customer_num'])) { ?>
                        <option value="<?php echo $custrow['fld_customer_num']; ?>" selected><?php echo $custrow['fld_customer_name']?></option>
                      <?php } else { ?>
                        <option value="<?php echo $custrow['fld_customer_num']; ?>"><?php echo $custrow['fld_customer_name']?></option>
                      <?php } ?>
                      <?php
      } // while
      $conn = null;
      ?> 
    </select>
  </div>
</div><br><br><br>
<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9">
    <?php if (isset($_GET['edit'])) { ?>
      <button class="btn btn-default" type="submit" name="update"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Update</button>
    <?php } else { ?>
      <button class="btn btn-default" type="submit" name="create"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create</button>
    <?php } ?>
    <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Clear</button>
  </div>
</div>

</form>
</div>
</div>
<hr>
<div class="row">
  <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
    <div class="page-header">
      <h2>Staff List</h2>
    </div>
    <table class="table table-striped table-bordered">
      <tr>
        <th>Order ID</th>
        <th>Order Date</th>
        <th>Staff</th>
        <th>Customer</th>
        <th></th>
      </tr>
    </div>
  </div>
  <?php
      // Read
  try {
   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $sql = "SELECT * FROM tbl_orders_a160979_pt2, tbl_staffs_a160979_pt2, tbl_customers_a160979_pt2 WHERE ";
   $sql = $sql."tbl_orders_a160979_pt2.fld_staff_num = tbl_staffs_a160979_pt2.fld_staff_num and ";
   $sql = $sql."tbl_orders_a160979_pt2.fld_customer_num = tbl_customers_a160979_pt2.fld_customer_num";
   $stmt = $conn->prepare($sql);
   $stmt->execute();
   $result = $stmt->fetchAll();
 }
 catch(PDOException $e){
  echo "Error: " . $e->getMessage();
}
foreach($result as $orderrow) {
  ?>
  <tr>
   <td><?php echo $orderrow['fld_order_num']; ?></td>
   <td><?php echo $orderrow['fld_order_date']; ?></td>
   <td><?php echo $orderrow['fld_staff_fname']." ".$orderrow['fld_staff_lname'] ?></td>
   <td><?php echo $orderrow['fld_customer_name'] ?></td>
   <td>
    <a href="orders_details.php?oid=<?php echo $orderrow['fld_order_num']; ?>" class="btn btn-default btn-xs" role="button">Details</a>
    <a href="orders.php?edit=<?php echo $orderrow['fld_order_num']; ?>" class="btn btn-success btn-xs" role="button">Edit</a>
    <a href="orders.php?delete=<?php echo $orderrow['fld_order_num']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
  </td>
</tr>
<?php
}
$conn = null;
?>

</table>
</div>
</div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>