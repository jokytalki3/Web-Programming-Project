<?php
session_start();
if (isset($_SESSION['username'])) {
  
  include_once 'nav_bar.php';
}else {
  header("location: login.php");
}
include_once 'staffs_crud.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>FunCraft Ordering System : Staffs</title>
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
    <div class="row box">
      <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <div class="page-header">
          <h2 style="color: white;">Create New Staff</h2>
        </div>
        <form action="staffs.php" method="post">
            <div class="form-group">
              <label for="staffid" class="col-sm-3 control-label">Staff ID</label>
              <div class="col-sm-9">
                <input class="form-control" name="sid" type="text" placeholder="Staff ID" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_num']; ?>" required>
              </div>
            </div><br><br><br>
            <div class="form-group">
              <label for="stafffname" class="col-sm-3 control-label">First Name</label>
              <div class="col-sm-9">
                <input class="form-control" name="fname" type="text" placeholder="Staff FirstName" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_fname']; ?>" required>
              </div>
            </div><br><br>
            <div class="form-group">
              <label for="stafflname" class="col-sm-3 control-label">Last Name</label>
              <div class="col-sm-9">
                <input class="form-control" name="lname" type="text" placeholder="Staff LastName" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_lname']; ?>" required>
              </div>
            </div><br><br>
            <div class="form-group">
              <label for="staffgender" class="col-sm-3 control-label">Gender</label>
              <div class="col-sm-9">
                <div class="radio">
                  <label>
                    <input name="gender" type="radio" value="Male" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_gender']=="Male") echo "checked"; ?> required> Male
                  </label>
                </div>
                <div class="radio">
                  <label>
                   <input name="gender" type="radio" value="Female" <?php if(isset($_GET['edit'])) if($editrow['fld_staff_gender']=="Female") echo "checked"; ?> > Female
                 </label>
               </div>
             </div>
           </div><br><br>
           <div class="form-group">
            <label for="staffphone" class="col-sm-3 control-label">Phone</label>
            <div class="col-sm-9">
              <input class="form-control" name="phone" type="text" placeholder="Staff Phone" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_phone']; ?>" required>
            </div>
          </div><br><br>
          <div class="form-group">
            <label for="staffemail" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
              <input class="form-control" name="email" type="text" placeholder="Staff Email" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_email']; ?>" required>
            </div>
          </div><br><br>
          <div class="form-group">
            <label for="fpassword" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
              <input class="form-control" name="staffpassword" id="fpassword" placeholder="Staff Password" type="password" value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_password']; ?>" required>
            </div>
          </div><br><br>
          <div class="form-group">
            <label for="spassword" class="col-sm-3 control-label">Confirm Password</label>
            <div class="col-sm-9">
              <input class="form-control" name="confirmstaffpassword" id="spassword"type="password" placeholder="Staff Retype Password"  value="<?php if(isset($_GET['edit'])) echo $editrow['fld_staff_password']; ?>" required>
            </div>
          </div><br><br>
          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
              <?php if (isset($_GET['edit'])) { ?>
                <input type="hidden" name="oldsid" value="<?php echo $editrow['fld_staff_num']; ?>">
                <button class="btn btn-default" type="submit" name="update" onclick="return checkPassword();"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Update</button>
              <?php } else { ?>
                <button class="btn btn-default" type="submit" name="create" onclick="return checkPassword();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create</button>
              <?php } ?>
              <button class="btn btn-default" type="reset"><span class="glyphicon glyphicon-erase" aria-hidden="true"></span>Clear</button>
              <br><br>
            </div>
          </div>
        </form>
    </div>
  </div>
        <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
          <div class="page-header">
            <h2>Staff List</h2>
          </div>
          <table class="table table-striped table-bordered">
            <tr>
              <th>Staff ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Gender</th>
              <th>Phone Number</th>
              <th>Email Address</th>
              <th>Password</th>
              <th></th>
            </tr>
          </div>
        </div>
        <?php
      // Read
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
        foreach($result as $readrow) {
          ?>
          <tr>
             <td><?php echo $readrow['fld_staff_num']; ?></td>
              <td><?php echo $readrow['fld_staff_fname']; ?></td>
              <td><?php echo $readrow['fld_staff_lname']; ?></td>
              <td><?php echo $readrow['fld_staff_gender']; ?></td>
              <td><?php echo $readrow['fld_staff_phone']; ?></td>
              <td><?php echo $readrow['fld_staff_email']; ?></td>
              <td style="-webkit-text-security: disc;"><?php echo $readrow['fld_staff_password']; ?></td>
            <td>
              <a href="staffs.php?edit=<?php echo $readrow['fld_staff_num']; ?>" class="btn btn-success btn-xs" role="button">Edit</a>
              <a href="staffs.php?delete=<?php echo $readrow['fld_staff_num']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>

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

    <script type="text/javascript">
      function checkPassword(){
        var fpassword = document.getElementById('fpassword');
        var spassword = document.getElementById('spassword');
        if(fpassword.value!=spassword.value){
          alert("Password and Confirm Password is different, please try again.");
          fpassword.select();
          spassword.select();
          return false;
        }
      }
    </script>