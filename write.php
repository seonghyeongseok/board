<?php
/**
 * Created by PhpStorm.
 * User: 형석
 * Date: 2017-09-12
 * Time: 오후 2:58
 */

session_start();
$login_id = $_SESSION['id'];
$title = $_POST['title'];
$contents = $_POST['contents'];
$c = $_POST['c'];   //  수정, 삽입 여부

$connect = mysqli_connect("localhost", "root", "autoset", "new_board");
if(!$c) {
    $sql = "insert into list (writer, title, contents) values('$login_id', '$title', '$contents')";
}else{
    $sql = "update list set title='$title', contents='$contents' where id=$c";
}

$result = mysqli_query($connect, $sql);
Header("Location:http://localhost/newBoard/list.php");
?>
