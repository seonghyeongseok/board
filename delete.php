<?php
/**
 * Created by PhpStorm.
 * User: skadl
 * Date: 2017-09-14
 * Time: 오후 12:35
 */

session_start();

$login_id = $_SESSION['id'];
$list_id = $_SESSION['list_id'];

$connect = mysqli_connect("localhost",  "root", "autoset", "new_board");

$sql = "delete from list where id='$list_id'";
$result = mysqli_query($connect, $sql);

Header("Location:http://localhost/newBoard/list.php");
