<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php 
if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    $ConnectingDB;
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute) {
        $_SESSION["SuccessMessage"]="Comment Deleted Successfully!";
        Redirect_to("Comments.php");
    }else{
        $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
        Redirect_to("Comments.php");
    }
}

?>