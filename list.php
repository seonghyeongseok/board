<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>

    </style>
</head>
<body>
<div align="center">
<h1>목록</h1><br>
<table>
    <tr>
        <th>글 번호</th>
        <th>작성자</th>
        <th>제목</th>
        <th>작성일자</th>
        <th>조회수</th>
    </tr>
    <?php
    session_start();

    //페이지
    $_SESSION['page'] = 1;
    $_SESSION['page'] = isset($_POST['page']) ? $_POST['page'] : $_SESSION['page'];

    $text = $_POST['findWord'];
    $option = $_POST['search'];

    $connect = mysqli_connect("localhost", "root", "autoset", "new_board");
    $login_id = $_SESSION['id'];

    if(isset($text)){
        switch ($option){
            case 'title':
                $sql = "select * from list where title='$text'";
                break;
            case 'writer':
                $sql = "select * from list where writer='$text'";
                break;
            case 'all':
                $sql = "select * from list where writer='$text' or title='$text'";
                break;
        }
    }else{
        $sql = "select * from list";
    }

    $result = mysqli_query($connect, $sql);
    $table_low = mysqli_num_rows($result);

    //  페이지 개수, 페이지 당 첫 출력 보드
    $lastPage = (int)(($table_low + 4) / 5);
    $startList = ($_SESSION['page'] - 1) * 5;

    if(isset($text)){
        switch ($option){
            case 'title':
                $sql = "select * from list where title like '%$text%' order by reg_date desc limit $startList, 5";
                break;
            case 'writer':
                $sql = "select * from list where writer like '%$text%' order by reg_date desc limit $startList, 5";
                break;
            case 'all':
                $sql = "select * from list where writer like '%$text%' or title like '%$text%' order by reg_date desc limit $startList, 5";
                break;
        }
    }else{
        $sql = "select * from list order by reg_date desc limit $startList, 5 ";
    }

    $results = mysqli_query($connect, $sql);
    $table_lows = mysqli_num_rows($results);

    for ($i = 0; $i < $table_lows; $i++) {
        $array = mysqli_fetch_array($results);
        $id = $array['id'];
        $writer = $array['writer'];
        $title = $array['title'];
        $date = $array['reg_date'];
        $hits = $array['hits'];

        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$writer</td>";
        echo "<td onclick='view($id)'>$title</td>"; // id를 view로 넘겨 수정, 삭제 가능여부
        echo "<td>$date</td>";
        echo "<td>$hits</td>";
        echo "</tr>";
    }
    ?>
</table>
    <form action="list.php" method="post" onsubmit="return check()">
        <select name="search">
            <option value="title">제목</option>
            <option value="writer">작성자</option>
            <option value="all">제목+작성자</option>
        </select>
        <input type="text" name="findWord" id="text">
        <input type="submit" value="검색">
    </form>
    <br>
    <form action="list.php" method='post'>
        <?php
        //  페이지 버튼
        for ($i = $_SESSION['page'] - 2; $i < $_SESSION['page'] + 3; $i++) {
            //  해당 페이지에서 +2, -2 까지만
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
<br>
<form action="loginTemplete.html" method="post">
    <?php
    //  로그인, 비회원 차이.. 수정해야됨
    if (isset($_SESSION['id'])) {
        echo "<input type=\"submit\" value=\"로그아웃\"></form>";
        echo "<form action=\"writeTemplete.html\" method=\"post\">
                <input type=\"submit\" value=\"글 쓰기\">";
    } else {
        echo "<input type=\"submit\" value=\"로그인\">";
    }
    ?>
</form>
</div>
</body>
<script>
    function view(id) {
        location.href = 'http://localhost/newBoard/view.php?id=' + id;
    }

    function check() {
        if (document.getElementById('text').value == '') {
            alert('검색어를 입력해 주세요!');
            return false;
        }
        return true;
    }

    function mouseover() {

    }

    function mouseout() {

    }
</script>
</html>