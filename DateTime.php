<?php
date_default_timezone_set("Europe/Dublin");
$CurrentTime=time();
$DateTime=strftime("%d-%B-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;

?>