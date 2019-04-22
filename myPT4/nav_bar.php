
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">FunCraft Store</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <li><a>Welcome <?php echo $_SESSION['fname'].' '.$_SESSION['lname']; ?>!</a></li>
    </ul>
      <form action="search_process.php" method="post">
      <ul class="nav navbar-nav navbar-right">
        <li><input type="search" class="form-control" name="keyword" placeholder="Search Products" style="margin-top: 7px;" required></li>
        <li><button class="btn btn-default form-control" type="submit" name="search_form" style="margin-top: 7px;"><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button></li>
        
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="products.php">Products</a></li>
            <li><a href="customers.php">Customers</a></li>
            <li><a href="staffs.php">Staffs</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </li>
      </ul>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<style type="text/css">
  .box{
        background-image: url("https://cdn.hipwallpaper.com/i/14/49/jJL0zF.jpg");
      } 
  .wood{
    background-image: url("https://i0.wp.com/www.knoxalliance.store/wp-content/uploads/2017/05/light-color-background-images-for-website-top-hd-images-for-free-background-for-website-in-light-color-1-1024x640.jpg");
    
  }
</style>