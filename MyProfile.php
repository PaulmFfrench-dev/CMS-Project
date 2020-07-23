<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php 
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>
<?php 
//fetching existing admin data start
$AdminId = $_SESSION["UserId"];
$ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while($DataRows = $stmt->fetch()){
    $ExistingUsername   = $DataRows['username'];
    $ExistingName       = $DataRows['aname'];
    $ExistingHeadline   = $DataRows['aheadline'];
    $ExistingBio        = $DataRows['abio'];
    $ExistingImage      = $DataRows['aimage'];
}
//fetching existing admin data end
if(isset($_POST["Submit"])){
    $AName      = $_POST["Name"];
    $AHeadline  = $_POST["Headline"];
    $ABio       = $_POST["Bio"];
    $Image      = $_FILES["Image"]["name"]; //The super global _FILES needs to be used with an image because _POST won't. THe image name will be saved in the db but the image will be saved in the directory(Uploads)
    $Target     = "Images/".basename($_FILES["Image"]["name"]); //Will use basename and take everything within it as an arguement.

    if(strlen($AHeadline)>12){
        $_SESSION["ErrorMessage"]= "Headline should be less than 12 characters";
        Redirect_to("MyProfile.php");
    }elseif(strlen($ABio)>500){
        $_SESSION["ErrorMessage"]= "Post Description should be less than 500 characters";
        Redirect_to("MyProfile.php");
    }else{
         //Query to UPDATE Post in DB when all validation passes
         $ConnectingDB;
         if( !empty($_FILES["Image"]["name"])){
         $sql = "UPDATE admins 
                 SET aname='$AName', aheadline='$AHeadline', abio='$ABio', aimage='$Image'
                 WHERE id='$AdminId'";
         }else{
         $sql = "UPDATE admins 
                 SET aname='$AName', aheadline='$AHeadline', abio='$ABio'
                 WHERE id='$AdminId'";
         }
         $Execute = $ConnectingDB->query($sql);

        move_uploaded_file($_FILES["Image"]["tmp_name"],$Target);
        if($Execute){
            $_SESSION["SuccessMessage"]="Details Updated Successfully";
            Redirect_to("MyProfile.php");
        }else{
            $_SESSION["ErrorMessage"]="Something went wrong. Try Again!";
            Redirect_to("MyProfile.php");
        }

    }
}//Ending of Submit Button If-Condition
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MyProfile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/772f078b99.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div style="height:10px; background:#27aae1;"></div>
    <!--Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">Paul Ffrench</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarcollapseCMS" >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarcollapseCMS">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i>My Profile</a>
                </li>
                <li class="nav-item">
                    <a href="Dashboard.php" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="Posts.php" class="nav-link">Posts</a>
                </li>
                <li class="nav-item">
                    <a href="Categories.php" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="Admins.php" class="nav-link">Manage Admins</a>
                </li>
                <li class="nav-item">
                    <a href="Comments.php" class="nav-link">Comments</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Live Blog</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="Logout.php" class="nav-link"><i class="fas fa-user-times text-danger"></i> Logout </a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
<!-- NAVBAR END-->  
 
<!-- HEADER -->
<header class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h1><i class="fas fa-user text-success mr-2"></i>@<?php echo $ExistingUsername; ?></h1>
            <small><?php echo $ExistingHeadline; ?></small>
            </div>
        </div>
    </div>
</header>
<!-- HEADER END-->

<!-- MAIN AREA -->
<section class="container py-2 mb-4">
    <div class="row" >
        <!-- Left Area -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3><?php echo $ExistingName; ?></h3>
                </div>
                <div class="card-body">
                    <img src="images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3" alt="">
                    <div class="">
                    <?php echo $ExistingBio; ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- Right Area -->
        <div class="col-md-9" style="min-height:400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body ">
                        <div class="form-group">
                            <input class="form-control" type="text" id="title" placeholder="Your Name" name="Name" value="">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" id="title" placeholder="Headline" name="Headline" value="">
                            <small class="text-muted">Add a professional headline like, 'Engineer'' at XYZ or 'Architect'</small>
                            <span class="text-danger">Not more than 12 characters</span>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Bio" class="form-control" id="Post" name="Bio" rows="8" cols="80"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                        </div>

                        <div class="row" >
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block">
                                <i class="fas fa-check"></i> Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- MAIN AREA END -->

<!-- FOOTER -->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
            <p class="lead text-center">Theme by | Jazeb Akram | <span id="year"></span> &copy; ----All rights Reserved.</p>
            <p class="text-center small"><a style="color: white; text-decoration: none; cursor: pointer;" href="#">
                This site is only used for studying purposes, jazebakram.com have all rights. No one is allowed to distribute copiers other than <br>
                &trade; jazebakram.com &trade; Udemy &trade; Skillshare; &trade; StackSkills
            </a></p>
            </div>
        </div>
    </div>
</footer>
<div style="height:10px; background:#27aae1;"></div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
$('#year').text(new Date().getFullYear());

</script>
</body>
</html>