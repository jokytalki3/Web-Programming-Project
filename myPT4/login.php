<?php 
session_start();
if (isset($_SESSION['username'])) {
  header("location: index.php");
}
include_once 'database.php';


$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$uname_error = "";
$pword_error = "";
$uname ="";
$pword="";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	//check the email field empty or not.
	if(empty(trim($_POST["username"]))){
		$uname_error = 'Please enter your registered email.';
	} else{
		$uname = trim($_POST["username"]);
		$uname_error = "";
	}

    //check the password field empty or not
	if(empty(trim($_POST["password"]))){
		$pword_error = 'Please enter password.';
	} else{
		$pword = trim($_POST["password"]);
		$pword_error = "";
	}

    //validate the email and password with database
	if(empty($uname_error) && empty($pword_error)){
    	//prepare statement
		$stmt = $conn->prepare("SELECT fld_staff_fname, fld_staff_lname, fld_staff_email, fld_staff_password FROM tbl_staffs_a160979_pt2 WHERE fld_staff_email = :email");
    	 // Bind variables to the prepared statement as parameters
		$stmt->bindParam(':email', $email_parameter, PDO::PARAM_STR);
		$email_parameter = trim($_POST["username"]);
    	//check if email exists in database
		$stmt->execute();
			// Check if username exists, if yes then verify password
			if($stmt->rowCount() == 1){
				if($row = $stmt->fetch()){
					$database_password = $row['fld_staff_password'];
					if($database_password == $pword){
                        /* Password is correct, so start a new session and
                        save the username to the session */
                        session_start();
                        $_SESSION['username'] = $uname;
                        $_SESSION['fname'] = $row['fld_staff_fname'];
                        $_SESSION['lname'] = $row['fld_staff_lname'];      
                        header("location: index.php");
                    } 
                    else{
                        // Display an error message if password is not valid
                        	$pword_error = 'The password you entered was not valid.';
                    }
                }
            }else{
             	// Display an error message if username doesn't exist
             	$uname_error = 'No account found with that email.';
            }            
        // Close statement
            unset($stmt);
        }
        // Close connection
        unset($conn);
    }        



    ?>
    <!DOCTYPE html>
    <html>
    <head>
    	<meta charset="utf-8">
  		<meta http-equiv="X-UA-Compatible" content="IE=edge">
  		<meta name="viewport" content="width=device-width, initial-scale=1">
  		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    	<title>Login: Collectibles Ordering System</title>
    	<link href="css/bootstrap.min.css" rel="stylesheet">

  		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    	<!--[if lt IE 9]>
     	 <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   		<![endif]-->
  		</head>
    	<style type="text/css">
    	.panel-login {
    		border-color: #ccc;
    		-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
    		-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
    		box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
    	}
    	.panel-login>.panel-heading {
    		color: #00415d;
    		background-color: #fff;
    		border-color: #fff;
    		text-align:center;
    	}
    	.panel-login>.panel-heading a{
    		text-decoration: none;
    		color: #666;
    		font-weight: bold;
    		font-size: 15px;
    		-webkit-transition: all 0.1s linear;
    		-moz-transition: all 0.1s linear;
    		transition: all 0.1s linear;
    	}
    	.panel-login>.panel-heading a.active{
    		color: #029f5b;
    		font-size: 18px;
    	}
    	.panel-login>.panel-heading hr{
    		margin-top: 10px;
    		margin-bottom: 0px;
    		clear: both;
    		border: 0;
    		height: 1px;
    		background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
    		background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    		background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    		background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
    	}
    	.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
    		height: 45px;
    		border: 1px solid #ddd;
    		font-size: 16px;
    		-webkit-transition: all 0.1s linear;
    		-moz-transition: all 0.1s linear;
    		transition: all 0.1s linear;
    	}
    	.panel-login input:hover,
    	.panel-login input:focus {
    		outline:none;
    		-webkit-box-shadow: none;
    		-moz-box-shadow: none;
    		box-shadow: none;
    		border-color: #ccc;
    	}
    	.btn-login {
    		background-color: #59B2E0;
    		outline: none;
    		color: #fff;
    		font-size: 14px;
    		height: auto;
    		font-weight: normal;
    		padding: 14px 0;
    		text-transform: uppercase;
    		border-color: #59B2E6;
    	}
    	.btn-login:hover,
    	.btn-login:focus {
    		color: #fff;
    		background-color: #53A3CD;
    		border-color: #53A3CD;
    	}
    	.forgot-password {
    		text-decoration: underline;
    		color: #888;
    	}
    	.forgot-password:hover,
    	.forgot-password:focus {
    		text-decoration: underline;
    		color: #666;
    	}

    	.btn-register {
    		background-color: #1CB94E;
    		outline: none;
    		color: #fff;
    		font-size: 14px;
    		height: auto;
    		font-weight: normal;
    		padding: 14px 0;
    		text-transform: uppercase;
    		border-color: #1CB94A;
    	}
    	.btn-register:hover,
    	.btn-register:focus {
    		color: #fff;
    		background-color: #1CA347;
    		border-color: #1CA347;
    	}
    	.center {
    		display: block;
    		margin-left: auto;
    		margin-right: auto;
    		padding-top: 40px;
    		padding-bottom: 50px;
    	}
    	.box{
    		height: 100vh;
    		width: 100%;
    		background-size: cover;
    		display: table;
    		background-attachment: fixed;
    		background-image: url("https://cdn.hipwallpaper.com/i/14/49/jJL0zF.jpg");
    	}	

    </style>
	<!------ Include the above in your HEAD tag ---------->
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body >
	

	<div class="container-fluid box" >
		<div class="row">
			<div>
				<img src="logo.png" alt="Vintage Store" class="center" />
			</div>
			<center><h2>FunCraft Store Ordering System</h2></center>
			
			<div class="col-xs-12 col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-12">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-lg-12">
								<form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Email Address" value="<?php echo $uname; ?>">
										<p style="color: #FF0000"><?php echo $uname_error; ?></p>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" value="<?php echo $pword; ?>" >
										<p style="color: #FF0000"><?php echo $pword_error; ?></p>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(function() {

			$('#login-form-link').click(function(e) {
				$("#login-form").delay(100).fadeIn(100);
				$("#register-form").fadeOut(100);
				$('#register-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});
			$('#register-form-link').click(function(e) {
				$("#register-form").delay(100).fadeIn(100);
				$("#login-form").fadeOut(100);
				$('#login-form-link').removeClass('active');
				$(this).addClass('active');
				e.preventDefault();
			});

		});
		function checkForm() {
			var username = document.getElementById('username');
			var password = document.getElementById('password');
			var patt = new RegExp(username.getAttribute('pattern'));
			var isValid = patt.test(username.value);	
			if (username.value == "" && password.value==""){
				alert("Please insert your email and username");
				username.focus();
				username.select();


			}else if(isValid== false){
				alert("Please insert your correct username");
			}else if(password.value == ""){
				alert("Please insert your Password");
				password.focus();
				password.select();
			}	
		}
	</script>
</body>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="js/bootstrap.min.js"></script>
</html>

