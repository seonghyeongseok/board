<?php
/**
 * Created by PhpStorm.
 * User: 형석
 * Date: 2017-09-12
 * Time: 오후 3:17
 */

session_start();

$id = $_POST['userID'];
$passwd = $_POST['userPASSWD'];

$connect = mysqli_connect("localhost", "root", "autoset", "new_board");

$sql = "select * from user_info where userID='$id' and passwd='$passwd'";

$result = mysqli_query($connect, $sql);
$array = mysqli_fetch_array($result);

session_destroy();  // 제거가 안됨....
if($array) {
    Header("Location:http://localhost/newBoard/list.php");
    $_SESSION['id'] = $id;
    $_SESSION['passwd'] = $passwd;
}
else
    echo "<script>alert('아이디 또는 패스워드가 틀렸습니다');
            location.href='http://localhost/newBoard/loginTemplete.html';
</script>";