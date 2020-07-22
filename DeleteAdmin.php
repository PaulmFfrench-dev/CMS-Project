<?php require_once("Include/DB.php"); ?>
<?php require_once("Include/Functions.php"); ?>
<?php require_once("Include/Sessions.php"); ?>
<?php 
if(isset($_GET["id"])){
    $SearchQueryParameter = $_GET["id"];
    $ConnectingDB;
    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute) {
        $_SESSION["SuccessMessage"]="Admin Deleted Successfully!";
        Redirect_to("Admins.php");
    }else{
        $_SESSION["ErrorMessage"]="Something Went Wrong. Try Again!";
        Redirect_to("Admins.php");
    }
}

?>