<?php 
session_start();
if (isset($_SESSION['username'])) {

  include_once 'nav_bar.php';
}else {
  header("location: login.php");
}
include_once 'products_crud.php';
?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>FunCraft Ordering System : Products Catalogue</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="page-header">
          <h2 style="text-align: center">Product Catalogue</h2>
        </div>
      </div>
    </div>

    <div class="row">


     <?php
      // Read
     $per_page = 9;
     if (isset($_GET["page"]))
      $page = $_GET["page"];
    else
      $page = 1;
    $start_from = ($page-1) * $per_page;

    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT * from tbl_products_a160979_pt2 LIMIT $start_from, $per_page");
      $stmt->execute();
      $result = $stmt->fetchAll();
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
    foreach($result as $readrow) {
      ?>  
      <div class="col-xs-12 col-sm-6 col-md-4" style="height: 460px;">
        <div class="thumbnail">
          <?php if ($readrow['fld_product_num'] == "" ) {?>
            <img src="products/nophoto.jpg" class="img-responsive">
          <?php }else { ?>
            <img src="products/<?php echo $readrow['fld_product_num']?>.jpg" class="img-responsive" style="height:60%;" >
          <?php } ?>
        </div>  

        <div class="caption">
          <p><?php echo $readrow['fld_product_name']; ?></p>
          <p>Product ID: <?php echo $readrow['fld_product_num']; ?></p>
          <p>Price: RM<?php echo $readrow['fld_product_price']; ?></p>
          <a href="products_details.php?pid=<?php echo $readrow['fld_product_num']; ?>" class="btn btn-warning btn-xs" role="button">Details</a>
          <a href="products.php?edit=<?php echo $readrow['fld_product_num']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
          <a href="catalogue.php?delete=<?php echo $readrow['fld_product_num']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
        </div>

      </div>



      <?php
    }
    $conn = null;
    ?>
  </div>


  <div class="row">
    <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
      <nav>
        <ul class="pagination">
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_products_a160979_pt2");
            $stmt->execute();
            $result = $stmt->fetchAll();
            $total_records = count($result);
          }
          catch(PDOException $e){
            echo "Error: " . $e->getMessage();
          }
          $total_pages = ceil($total_records / $per_page);
          ?>
          <?php if ($page==1) { ?>
            <li class="disabled"><span aria-hidden="true">«</span></li>
          <?php } else { ?>
            <li><a href="catalogue.php?page=<?php echo $page-1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
            <?php
          }
          for ($i=1; $i<=$total_pages; $i++)
            if ($i == $page)
              echo "<li class=\"active\"><a href=\"catalogue.php?page=$i\">$i</a></li>";
            else
              echo "<li><a href=\"catalogue.php?page=$i\">$i</a></li>";
            ?>
            <?php if ($page==$total_pages) { ?>
              <li class="disabled"><span aria-hidden="true">»</span></li>
            <?php } else { ?>
              <li><a href="catalogue.php?page=<?php echo $page+1 ?>" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
            <?php } ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>

</body>
</html>