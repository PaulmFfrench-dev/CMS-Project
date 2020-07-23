<?php require_once("Include/DB.php"); ?> <!-- Using DB connection in these functions, therefore DB connection file is required -->
<?php

//Used in AddNewPost, Admins, AprroveComments, Categories, Delete-Admin/Category/Comments/Post, DisAprroveComments, EditPost, FullPost, Login, Logout, MyProfile, Profile.
function Redirect_to($New_Location){ 
    header("Location:".$New_Location); //Will be used to set New Location, which will be given as a parameter in the files listed above, written here to make it dynamic.
    exit;
}

//Used in Admins.php
function CheckUserNameExistsOrNot($UserName){  //Is Checking if admin name already exists in database
 global $ConnectingDB; //Connects to DB
 $sql = "SELECT username FROM admins WHERE username=:userName"; 
 $stmt = $ConnectingDB->prepare($sql);
 $stmt->bindValue(':userName',$UserName);
 $stmt ->execute();
 $Result = $stmt->rowcount(); //Counts rows for admin name above that has been specificed
if ($Result==1) { //If admin name exists, return true.
    return true;
}else {
    return false;
}
}

//Used in Login.php
function Login_Attempt($UserName,$Password){  //Checking if account exists
    global $ConnectingDB;
    $sql = "SELECT * FROM admins WHERE username=:username AND password=:passWord LIMIT 1"; //Select all columns where the username is equal to the username parameter and password too
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':username',$UserName);
    $stmt->bindValue(':passWord',$Password);
    $stmt->execute();
    $Result = $stmt->rowcount(); //counts the amount of rows holding the specified sql parameters
    if($Result==1){
        return $Found_Account=$stmt->fetch(); //Returning the fetched data out of login attempt function, fetch is saved inside array of found_account
    }else{
        return null;
    }
}

//Used in AddNewPost, Admins, ApproveComments, Categories, Comments, Dashboard, DeletePost, EditPost, MyProfile, Posts
function Confirm_Login(){   //Prevents users accessing pages that should not be viewable unless logged in. Will redirect them to login.php
    if(isset($_SESSION["UserId"])){ //This parameter checking if the UserId is set from being logged, if so, than return true
        return true;
    }else{
        $_SESSION["ErrorMessage"]="Login Required!"; //If the user is not logged in, then there is no UserId stored in session, therefore, they will be redirected to login.php
        Redirect_to("Login.php");
    }
}

//Used in Blog & Dashboard
function TotalPosts(){  //Counts total of current posts in table posts in the db, and outputs total
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM posts";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch(); 
    $TotalPosts =array_shift($TotalRows); //Array to string conversion b
    echo $TotalPosts; //Will echo total where this function has been called
}

//Used in Dashboard
function TotalCategories(){  //Counts total of current categories stored in the category table and outputs total
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM category";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $Totalcategories =array_shift($TotalRows); //Array to string conversion
    echo $Totalcategories;
}

//Used in Dashboard
function TotalAdmins(){ //Counts total of current admins stored in the admins table and outputs total
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM admins";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch(); 
    $Totaladmins =array_shift($TotalRows); //Array to string conversion
    echo $Totaladmins;
}

//Used in Dashboard
function TotalComments(){ //Counts total of current comments stored in the comments table and outputs total
    global $ConnectingDB; 
    $sql = "SELECT COUNT(*) FROM comments";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $Totalcomments =array_shift($TotalRows); //Array to string conversion
    echo $Totalcomments;
}

//Following two functions used in Dashboard.php 
//These functions count and display the comments that are approved and disaproved on dashboard beside there respective posts
function ApproveCommentsAccordingToPost($PostId) {  //PostID is linked the id of the posts table
    global $ConnectingDB;
    $sqlApproved = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='ON'"; //post_id is the foreign key in comments table linking comments to posts
    $stmtApproved = $ConnectingDB->query($sqlApproved);
    $RowsTotal = $stmtApproved->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
function DisApproveCommentsAccordingToPost($PostId) { //PostID is linked the id of the posts table
    global $ConnectingDB;
    $sqlDisApproved = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='OFF'"; //post_id is the foreign key in comments table linking comments to posts
    $stmtDisApproved = $ConnectingDB->query($sqlDisApproved);
    $RowsTotal = $stmtDisApproved->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
?>