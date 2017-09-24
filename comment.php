<?php
/**
 * Created by PhpStorm.
 * User: skadl
 * Date: 2017-09-21
 * Time: 오후 12:35
 */

session_start();
$login_id = $_SESSION['id'];    //  현재 로그인 id
$contents = $_POST['contents']; //  댓글 내용
$parent = $_POST['parent'];     //  현재 게시글 id
$parent = (int)$parent;

$connect = mysqli_connect("localhost", "root", "autoset", "new_board");
$sql = "insert into comments (writer, parent, contents) values('$login_id', $parent, '$contents')";
$result = mysqli_query($connect, $sql);

//  댓글 추가 후 다시 게시글 보는 페이지로..
Header("Location:http://localhost/newBoard/view.php?id=$parent");