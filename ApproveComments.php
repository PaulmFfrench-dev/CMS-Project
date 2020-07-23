<!-- Requred Files STARTS -->
<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<!-- Requred Files ENDS -->
<?php 
if(isset($_GET["id"])){ 
    $SearchQueryParameter = $_GET["id"]; //Check if id is set from comments.php
    $ConnectingDB;
    $Admin = $_SESSION["AdminName"]; //Pulled from login.php
    $sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";   //id is equal to id gotten from the above super global _GET
    $Execute = $ConnectingDB->query($sql);
    if($Execute) {
        $_SESSION["SuccessMessage"]="Comment Approved Successfully!";
        Redirect_to("Comments.php");
    }else{
        $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
        Redirect_to("Comments.php");
    }
}

?>