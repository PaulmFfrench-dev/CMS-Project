<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php 
if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    $ConnectingDB;
    $sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
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