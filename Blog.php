<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog Page</title>
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
                    <a href="Blog.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="Blog.php" class="nav-link">Blog</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Features</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <form class="form-inline d-none d-sm-block" action="Blog.php">
                    <div class="form-group">
                        <input class="form-control mr-2" type="text" name="Search" placeholder="Search here"value="">
                        <button class="btn btn-primary" name="SearchButton1">Go</button>
                    </div>
                </form>
            </ul>
            </div>
        </div>
    </nav>
    <div style="height:10px; background:#27aae1;"></div>
<!-- NAVBAR END-->  
 
<!-- HEADER -->
<div class="container">
    <div class="row mt-4">
        <!--MAIN AREA START -->
        <div class="col-sm-8">
            <h1>The Complete Responsive CMS Blog</h1>
            <h1 class="lead">The Complete Blog by using PHP by Paul Ffrench</h1>
            <?php 
            echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <?php 
            $ConnectingDB;
            // SQL query when search button is active /* Only select results if the search matches title OR post OR category*/
            if(isset($_GET["SearchButton1"])){ 
                $Search = $_GET["Search"];
                $sql = "SELECT * FROM posts 
                WHERE datetime LIKE :search 
                OR title LIKE :search
                OR category LIKE :search 
                OR post LIKE :search"; 
                $stmt = $ConnectingDB->prepare($sql); //Uses DB connection and prepares sql data
                $stmt->bindValue(':search','%'.$Search.'%'); //Look for search input field
                $stmt->execute();
            }
            else{
                $sql = "SELECT * FROM posts ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
            }
            while ($DataRows = $stmt->fetch()){
                $PostId            = $DataRows["id"];
                $DateTime          = $DataRows["datetime"];
                $PostTitle         = $DataRows["title"];
                $Category          = $DataRows["category"];
                $Admin             = $DataRows["author"];
                $Image             = $DataRows["image"];
                $PostDescritpion   = $DataRows["post"];
            
            ?>
             <div class="card">
                 <img src="Uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;"class="img-fluid card-img-top" />
                <div class="card-body">
                    <h4 class="card-title"><?php echo htmlentities($PostTitle); ?></h4>
                    <small class="text-muted">Category: <span class="text-dark"><?php echo $Category; ?></span> & Written by <span class="text-dark"><?php echo htmlentities($Admin); ?></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
                    <span style="float:right;" class="badge badge-dark text-light">Comments <?php echo ApproveCommentsAccordingToPost($PostId); ?></span>
                    <hr>
                    <p class="card-text"> <?php if(strlen($PostDescritpion)>150) { $PostDescritpion = substr($PostDescritpion,0,150)."...";} echo $PostDescritpion; ?></p>
                    <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                        <span class="btn btn-info">Read More>></span>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>
        <!--MAIN AREA END -->

        <!--SIDE AREA START -->
        <div class="col-sm-4" style="min-height:40px; background:green;">
        </div>
        <!--SIDE AREA END -->
    </div>
</div>
<!-- HEADER END-->
<br>
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