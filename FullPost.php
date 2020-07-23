<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php $SearchQueryParameter = $_GET["id"]?>
<?php 
if(isset($_POST["Submit"])){
    $Name = $_POST["CommenterName"];
    $Email = $_POST["CommenterEmail"];
    $Comment = $_POST["CommenterThoughts"];
    date_default_timezone_set("Europe/Dublin");
    $CurrentTime=time();
    $DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurrentTime);

    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION["ErrorMessage"]= "All fields must be filled out";
        Redirect_to("FullPost.php?id=$SearchQueryParameter"); //So the user stays on the same page
    }elseif(strlen($Comment)>500){
        $_SESSION["ErrorMessage"]= "Category title should be less than 500 characters";
        Redirect_to("FullPost.php?id=$SearchQueryParameter");
    }else{
        //Query to Insert comment in DB when all validation passes
        $ConnectingDB;
        $sql = "INSERT INTO comments(datetime,name,email,comment,approvedby,status,post_id)";
        $sql .= "VALUES(:dateTime,:name,:email,:comment,'Pending','OFF',:postIdFromURL)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':dateTime',$DateTime);
        $stmt->bindValue(':name',$Name);
        $stmt->bindValue(':email',$Email);
        $stmt->bindValue(':comment',$Comment);
        $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
        $Execute=$stmt->execute();
        
        if($Execute){
            $_SESSION["SuccessMessage"]="Comment Submitted Successfully";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
        }else{
            $_SESSION["ErrorMessage"]="Something went wrong. Try Again!";
            Redirect_to("FullPost.php?id=$SearchQueryParameter");
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
                $PostIdFromURL = $_GET["id"];
                if(!isset($PostIdFromURL)){ //If Url id is not set
                    $_SESSION["ErrorMessage"]="Bad Request!";
                    Redirect_to("Blog.php");
                }
                $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL'";
                $stmt = $ConnectingDB->query($sql);
                $Result =$stmt->rowcount();
                if ($Result!=1){
                    $_SESSION["ErrorMessage"]="Bad Request";
                    Redirect_to("Blog.php?page=1");
                }
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
                    <small class="text-muted"><a href="Blog.php?category=<?php echo htmlentities($Category); ?>"><?php echo htmlentities($Category); ?></a> & Written by <span class="text-dark"><?php echo htmlentities($Admin); ?></span> On <span class="text-dark"><?php echo htmlentities($DateTime); ?></span></small>
                    <hr>
                    <p class="card-text"> <?php echo $PostDescritpion; ?></p>
                    <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float:right;">
                        <span class="btn btn-info">Read More>></span>
                    </a>
                </div>
            </div>
            <?php } ?>
            <!-- COMMENT PART START -->

            <!-- Fetching exisiting comment START-->
            <span class="FieldInfo">Comments</span>
            <br><br>
            <?php 
            $ConnectingDB;
            $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
            $stmt = $ConnectingDB->query($sql);
            while($DataRows = $stmt->fetch()){
                $CommentDate = $DataRows['datetime'];
                $CommenterName = $DataRows['name'];
                $CommentContent = $DataRows['comment'];
            ?>
            <div>
                <div class="media CommentColor">
                    <img class="d-block img-fluid align" src="images/comment.png" alt="">
                    <div class="media-body ml-2">
                        <h6 class="lead"><?php echo $CommenterName; ?></h6>
                        <p class="small"><?php echo $CommentDate; ?></p>
                        <p><?php echo $CommentContent; ?></p>
                    </div>
                </div>
            </div>
            <hr>
            <?php } ?>
            <!-- Fetching exisiting comment END-->
            <div class="">
                <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter ?>" method="post">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h5 class="FieldInfo">Share your thoughts about this post</h5>

                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                <input class="form-control" type="text" name="CommenterName" placeholder="Name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                <input class="form-control" type="email" name="CommenterEmail" placeholder="Name" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="CommenterThoughts" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <button type="submit" name="Submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- COMMENT PART END -->
        </div>
        <!--MAIN AREA END -->

        <!--SIDE AREA START -->
        <div class="col-sm-4" >
            <div class="card mt-4">
                <div class="card-body">
                    <img src="images/startblog.png" class="d-block img-fluid mb-3" alt="">
                    <div class="text-center">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </div>
                </div>                
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h2 class="lead">Sign Up!</h2>
                </div>                
                <div class="card-body">
                    <button type="button" class="btn btn-success btn-block text-center text-white" name="button">Join the Forum</button>
                    <button type="button" class="btn btn-danger btn-block text-center text-white mb-4" name="button">Login</button>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="" placeholder="Enter your email" value="">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary btn-sm text-center text-white" name="button">Subscribe now</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header bg-primary text-light">
                    <h2 class="lead">Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php 
                        $ConnectingDB;
                        $sql = "SELECT * FROM category ORDER BY id desc";
                        $stmt = $ConnectingDB->query($sql);
                        while($DataRows=$stmt->fetch()){
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>
                        <a href="Blog.php?category=<?php echo $CategoryName; ?>"><span class="heading"><?php echo $CategoryName; ?><br></span></a>
                        <?php }?>
                    </div>
                 </div>
                 <br>
                 <div class="card">
                     <div class="card-header bg-info text-white"> 
                        <h2 class="lead">Recent Posts</h2>
                     </div>
                     <div class="card-body">
                         <?php 
                         $ConnectingDB;
                         $sql = "SELECT * FROM posts ORDER BY id desc LIMIT 0,5";
                         $stmt = $ConnectingDB->query($sql);
                         while ($DataRows=$stmt->fetch()){
                             $Id        =$DataRows['id'];
                             $Title     =$DataRows['title'];
                             $DateTime  =$DataRows['datetime'];
                             $Image     =$DataRows['image'];
                         ?>
                         <div class="media">
                            <img src="Uploads/<?php echo htmlentities($Image); ?>" class="d-block ing-fluid align-self-start" width="90" height="94" alt="" >
                            <div class="media-body m1-2">
                                <a href="FullPost.php?id=<?php echo htmlentities($Id); ?>" target="_blank"><h6 class="lead ml-1"><?php echo $Title; ?></h6></a>
                                <p class="small ml-1"><?php echo htmlentities($DateTime); ?></p>
                            </div>
                         </div>
                         <hr>
                         <?php } ?>
                     </div>

                 </div>
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