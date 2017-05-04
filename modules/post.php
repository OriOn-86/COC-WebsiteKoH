<?php
session_start();
if(isset($_SESSION['name'])){
    $text = $_POST['text'];
     
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln'>".date("G:i")." <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<hr></div>");
    fclose($fp);
}
?>