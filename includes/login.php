<!DOCTYPE html>
<html lang="en">
<head>
  <title>Kiddocare Test</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="css/login.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-6">
                <div class="card1 pb-5">
                    <div class="row"> <img src="https://i.imgur.com/CXQmsmF.png" class="logo"> </div>
                    <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="https://i.imgur.com/uNGdWHi.png" class="image"> </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card2 card border-0 px-4 py-5">
                    <div class="row mb-4 px-3">
                        <h1 class="mb-0 mr-4 mt-2">Admin Dashboard</h1>
                    </div>
                    <?php if (isset($_COOKIE['loginError'])){ setcookie("loginError", "", time() - 3600, "/"); ?>
                    <div class="row px-3">
                        <p class="text-danger mb-4">WRONG USERNAME OR PASSWORD</p>
                    </div>
                    <?php } ?>
                    <form class="user" id="admLogin_Form" action="includes/controller.php" method="post">
                        <input type="hidden" name="formtype" value="aSBTRwc3ty83bnn0">
                        <div class="row px-3"> 
                            <label class="mb-1"><h6 class="mb-0 text-sm">Email Address</h6></label> 
                            <input class="mb-4" type="text" name="txt_email" id="txt_email" placeholder="Enter a valid email address" value="<?php if(isset($_COOKIE['rememberUsername'])){ echo $_COOKIE['rememberUsername'];} ?>"> 
                        </div>
                        <div class="row px-3"> 
                            <label class="mb-1"><h6 class="mb-0 text-sm">Password</h6></label> 
                            <input type="password" name="txt_pword" id="txt_pword" placeholder="Enter password" value="<?php if(isset($_COOKIE['rememberPassword'])){ echo $_COOKIE['rememberPassword'];} ?>"> 
                        </div>
                        <div class="row px-3 mb-4">
                            <div class="custom-control custom-checkbox custom-control-inline"> <input type="checkbox" id="customCheck" name="customCheck" class="custom-control-input" <?php if(isset($_COOKIE['rememberUsername']) && isset($_COOKIE['rememberPassword'])){ echo 'checked'; }?>> <label for="customCheck" class="custom-control-label text-sm">Remember me</label> </div> 
                        </div>
                        <div class="row mb-3 px-3"> <span class="btn btn-blue text-center" onclick="signIn()">Login</span> </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-blue py-4">
            <div class="row px-3"> <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2019. All rights reserved.</small>
                <div class="social-contact ml-4 ml-sm-auto"> <span class="fa fa-facebook mr-4 text-sm"></span> <span class="fa fa-google-plus mr-4 text-sm"></span> <span class="fa fa-linkedin mr-4 text-sm"></span> <span class="fa fa-twitter mr-4 mr-sm-5 text-sm"></span> </div>
            </div>
        </div>
    </div>
</div>

<script>
		function signIn(){
			if($('#txt_email').val() != "" && $('#txt_pword').val() != ""){
				$('#admLogin_Form').submit();
			}else{
                alert('ENTER EMAIL AND PASSWORD');
            }
		}
		
		function submitEnter(event){
			var x = event.which || event.keyCode;
			if(x == 13){
				signIn();
			}
		}
</script>

</body>
</html>