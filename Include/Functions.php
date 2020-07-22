<?php require_once("Include/DB.php"); ?>
<?php
function Redirect_to($New_Location){
    header("Location:".$New_Location);
    exit;
}
function CheckUserNameExistsOrNot($UserName){
 global $ConnectingDB;
 $sql = "SELECT username FROM admins WHERE username=:userName";
 $stmt = $ConnectingDB->prepare($sql);
 $stmt->bindValue(':userName',$UserName);
 $stmt ->execute();
 $Result = $stmt->rowcount();
if ($Result==1) {
    return true;
}else {
    return false;
}
}
function Login_Attempt($UserName,$Password){
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
?>