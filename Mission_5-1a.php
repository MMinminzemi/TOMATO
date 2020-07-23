<html>
<head>
    <meta charset="utf-8">
    <title>mission5-1a</title>
</head> 
<body>
    <form action="Mission_5-1a.php" method="POST">
    <p>■　投稿フォーム<br>
    <input type="text" name="name" placeholder="名前">
    <input type="text" name="comment" placeholder="コメント">
    <input type="text" name="pass" placeholder="パスワード">
    <input type="submit" value="送信"></p>
    </form>

    <form action="Mission_5-1a.php" method="post">
    <p>■　削除フォーム<br>
    <input type="text" name="delete" placeholder="削除番号">
    <input type="text" name="dePass" placeholder="パスワード">
    <input type="submit" value="削除"></p>
    </form>
    <form action="Mission_5-1a.php" method="post">
    <p>■　編集フォーム<br>
    <input type="text" name="editNum" placeholder="編集対象番号">
    <input type="text" name="editName" placeholder="名前">
    <input type="text" name="editText" placeholder="コメント">
    <input type="text" name="editPass" placeholder="パスワード">
    <input type="submit" value="編集"><br></p>
    <p>■　過去の投稿</p>
    </form>
    

<?php 
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
       
//テーブルを作成   
    $sql = "CREATE TABLE IF NOT EXISTS tetest"
    . " ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "pass TEXT"
    . ");";
    $stmt = $pdo->query($sql);

//入力
    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])){
        $sql = $pdo -> prepare("INSERT INTO tetest (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        $name = $_POST["name"];
        $comment =$_POST["comment"];
        $date = date("Y/m/d H:i:s");
        $pass = $_POST["pass"];
        $sql -> execute();
    }

//編集
    if(!empty($_POST["editNum"]) && !empty($_POST["editName"]) && !empty($_POST["editText"]) && !empty($_POST["editPass"])){
        $id =  $_POST["editNum"]; 
        $name =  $_POST["editName"];
        $comment = $_POST["editText"];
        $date = date("Y/m/d H:i:s");
        $pass = $_POST["editPass"];
        $sql = 'update tetest set name=:name,comment=:comment, date=:date where id=:id AND pass=:pass';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->execute();
    }

//削除
    if(!empty($_POST["delete"]) && !empty($_POST["dePass"])){
        $id = $_POST["delete"];
        $pass = $_POST["dePass"];
        $sql = 'delete from tetest where id=:id AND pass=:pass';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->execute();
    }

// 出力    
    $sql = 'SELECT * FROM tetest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
        echo "<hr>";
    }

?>
</body>
</html>