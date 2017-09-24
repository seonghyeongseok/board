<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: skadl
 * Date: 2017-09-14
 * Time: 오전 11:47
 */

session_start();
$list_id = $_GET['id'];
$login_id = $_SESSION['id'];

$connect = mysqli_connect("localhost", "root", "autoset", "new_board");
$sql = "select * from list where id='$list_id'";
$result = mysqli_query($connect, $sql);
//  글 출력 해야됨..
// 깔끔하게
$array = mysqli_fetch_array($result);
$title = $array['title'];
$contents = $array['contents'];
$writer = $array['writer'];
$date = $array['reg_date'];

echo $title . "<br>";
echo $contents . "<br>";
echo $writer . "<br>";
echo $date . "<br>";

$sql = "update list set hits = hits + 1 where id = $list_id";
$result = mysqli_query($connect, $sql);
//  조회수 증가

$sql = "select writer from list where id = $list_id";
$result = mysqli_query($connect, $sql);
//  글 작성자

$array = mysqli_fetch_array($result);
$writer = $array["writer"];

if ($writer == $login_id) {
    //  작성자와 현재 로그인 한 id가 같을 경우
    echo "<script>function idCheck(){return true;}</script>";
    $_SESSION['list_id'] = $list_id;
} else {
    echo "<script>function idCheck(){
    alert('권한이 없습니다');
    return false;}</script>";
}

session_start();

//  댓글 페이지 네이션
$_SESSION['page'] = 1;
$_SESSION['page'] = isset($_POST['page']) ? $_POST['page'] : $_SESSION['page'];

$connect = mysqli_connect("localhost", "root", "autoset", "new_board");
$login_id = $_SESSION['id'];

//  댓글이 어떤 게시글에 붙어있나..
$sql = "select * from comments where parent=$list_id";

$result = mysqli_query($connect, $sql);
$table_low = mysqli_num_rows($result);

//  댓글 페이지 개수, 페이지 당 첫 댓글
$lastPage = (int)(($table_low + 4) / 5);
$startList = ($_SESSION['page'] - 1) * 5;

$sql = "select * from comments where parent=$list_id order by reg_date desc limit $startList, 5";

$results = mysqli_query($connect, $sql);
$table_lows = mysqli_num_rows($results);

//  현재 게시글의 id값을 넘겨준다.
echo "<form action=\"comment.php\" method=\"post\" onsubmit=\"return check()\">
<input type=\"hidden\" name=\"parent\" value=\"$list_id\">
    <textarea name=\"contents\" id=\"contents\" cols=\"60\" rows=\"3\"></textarea>
    <input type=\"submit\" value=\"댓글작성\">
</form>";
?>

<script>
    function check() {
        if (document.getElementById('contents').value == '') {
            alert('댓글을 입력해 주세요!');
            return false;
        }
        return true;
    }
</script>
<table>
    <?php
    for ($i = 0; $i < $table_lows; $i++) {
        $array = mysqli_fetch_array($results);
        $id = $array['id'];
        $writer = $array['writer'];
        $contents = $array['contents'];
        $date = $array['reg_date'];

        echo "<tr>";
        echo "<td>$writer</td>";
        echo "<td>$contents</td>";
        echo "<td>$date</td>";
        echo "</tr>";
    }
    ?>
</table>
<form action="list.php" method='post'>
    <?php
    for ($i = $_SESSION['page'] - 2; $i < $_SESSION['page'] + 3; $i++) {
        if ($i > 0) {
            if ($i <= $lastPage) {
                if ($i == $_SESSION['page']) {
                    echo "<input type='submit' style='color:red' value=$i>";
                } else {
                    echo "<input type='submit' name='page' value=$i>";
                }
            }
        }
    }
    ?>
</form>
<form action="list.php" method="post">
    <input type="submit" value="목록으로">
</form>
<form action="update.php" method="post" onsubmit="return idCheck()">
    <input type="submit" value="글 수정">
</form>
<form action="delete.php" method="post" onsubmit="return idCheck()">
    <input type="submit" value="글 삭제">
</form>
</body>
</html>