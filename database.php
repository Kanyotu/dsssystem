<?php
$conn=new mysqli("localhost","root","","dsssmartcampus");
if(!$conn){
    die("Connection failed: ".$conn->connect_error());
}   