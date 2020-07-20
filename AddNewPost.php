<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php 
if(isset($_POST["Submit"])){
    $Category = $_POST["CategoryTitle"];
    $Admin = "Paul";
    date_default_timezone_set("Europe/Dublin");
    $CurrentTime=time();
    $DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurrentTime);

    if(empty($Category)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("Categories.php");
    }elseif(strlen($Category)<3){
        $_SESSION["ErrorMessage"]= "Category title should be greater than 2 characters";
        Redirect_to("Categories.php");
    }elseif(strlen($Category)>49){
        $_SESSION["ErrorMessage"]= "Category title should be less than 50 characters";
        Redirect_to("Categories.php");
    }else{
        //Query to Insert category in DB when all validation passes
        $ConnectingDB;
        $sql = "INSERT INTO category(title,author,datetime)";
        $sql .= "VALUES(:categoryName,:adminName,:dateTime)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':dateTime',$DateTime);
        $Execute=$stmt->execute();
        
        if($Execute){
            $_SESSION["SuccessMessage"]="Catergory with id: ".$ConnectingDB->lastInsertId() . "Added Successfully";
            Redirect_to("Categories.php");
        }else{
            $_SESSION["ErrorMessage"]="Something went wrong. Try Again!";
            Redirect_to("Categories.php");
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
    <title>Categories</title>
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
                    <a href="MyProfile.php" class="nav-link"><i class="fas fa-user text-success"></i> My Profile</a>
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
                <h1><i class="fas fa-edit" style="color:#27aae1;"></i>Add Post</h1>
            </div>
        </div>
    </div>
</header>
<!-- HEADER END-->

<!-- MAIN AREA -->
<section class="container py-2 mb-4">
    <div class="row" >
        <div class="offset-lg-1 col-lg-10" style="min-height:400px;">
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form class="" action="Categories.php" method="post">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title"><span class="FieldInfo">Post Title:</span></label>
                            <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type Title Here"value="">
                        </div>
                        <div class="form-group">
                            <label for="CategoryTitle"><span class="FieldInfo">Choose Category</span></label>
                            <select class="form-control" id="CategoryTitle" name="Category">
                                <?php 
                                //Fetching all the categories from category table
                                $ConnectingDB;
                                $sql = "SELECT * FROM category";
                                $stmt = $ConnectingDB->query($sql);
                                while($DataRows = $stmt->fetch()) { // DataRows variable creates stmt variable as an object
                                    $Id = $DataRows["id"];
                                    $CategoryName = $DataRows["title"];
                                ?>
                                <option><?php echo $CategoryName; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input class="custom-file-input" type="File" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Post"><span class="FieldInfo"> Post: </span></label>
                            <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80"></textarea>
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