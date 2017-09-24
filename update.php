<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action="write.php" method="post" onsubmit="return check()">
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

    $connect = mysqli_connect("localhost", "root", "autoset", "new_board");
    $sql = "select title, contents from list where id = $list_id";

    $result = mysqli_query($connect, $sql);
    $array = mysqli_fetch_array($result);

    $title = $array['title'];
    $contents = $array['contents'];

    //  수정 시 간편하게 해당 글의 내용과 제목을 출력..
    echo "제목 <br><input type=\"text\" size=\"40\" id=\"title\" name=\"title\" value=\"$title\"><br>";
    echo "내용 <br><textarea name=\"contents\" id=\"contents\" cols=\"60\" rows=\"20\">$contents</textarea><br>";
    echo "<input type=\"hidden\" value=\"$list_id\" name=\"c\">";
    ?>

    <input type="submit" value="확인">
    <input type="button" value="취소" onclick="cancel()">
</form>
</body>
<script>
    function check() {
        if (document.getElementById("title").value == '' ||
            document.getElementById("contents").value == '') {
            alert('입력해 주세요!');
            return false;
        }
        return true;
    }

    function cancel() {
        location.href = 'http://localhost/newBoard/list.php';
    }
</script>
</html>
