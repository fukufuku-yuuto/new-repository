<?php

$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

/*$sql = "DROP TABLE tbtest";
$stmt = $pdo->query($sql);*/


/*$sql = "CREATE TABLE IF NOT EXISTS 掲示板。"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
  . "comment TEXT,"
  . "pass TEXT,"
  . "dt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
	.");";
    $stmt = $pdo->query($sql);*/


    $sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
    echo "<hr>";

    if(!empty($_POST['name'])&&!empty($_POST["blank"])==false){
      $name=$_POST['name'];
      $comment=$_POST['comment'];
      $pass=$_POST['pass'];
      $dt=date('Y-m-d H:i:s');
      $stmt = $pdo -> prepare("INSERT INTO 掲示板。(name, comment, pass, dt) VALUES (:name, :comment, :pass, :dt)");
      $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
      $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
      $stmt -> bindParam(':pass', $pass, PDO::PARAM_STR);
      $stmt -> bindParam(':dt', $dt, PDO::PARAM_STR);
      $stmt->execute();
    }
  
    if(!empty($_POST["delete"]) &&!empty($_POST["delpass"])){
      $delete = $_POST["delete"];
      $delpass = $_POST["delpass"];
      $sql = 'SELECT * FROM 掲示板。';
      $stmt = $pdo->query($sql);
      $results = $stmt->fetchAll();
       foreach ($results as $row){
         if($row['id'] == $delete && $row['pass'] == $delpass){
           $id=$_POST["delete"];
           $sql = 'delete from 掲示板。 where id=:id';
           $stmt = $pdo->prepare($sql);
           $stmt->bindParam(':id', $id, PDO::PARAM_INT);
           $stmt->execute();
         }
        }
      }
  
    
    if(!empty($_POST["edit"]) &&!empty($_POST["editpass"])){
      $edit=$_POST["edit"];
      $edipass=$_POST["editpass"];
      $sql = 'SELECT * FROM 掲示板。';
      $stmt = $pdo->query($sql);
      $results = $stmt->fetchAll();
       foreach ($results as $row){
         if($row['id'] == $edit && $row['pass'] == $edipass){
           $namae = $row["name"];
           $message = $row["comment"];
         }
       }
    }
    
    if(empty($_POST["blank"])==false&&empty($_POST["name"])==false&&empty($_POST["comment"])==false){
      $sql = 'SELECT * FROM 掲示板。';
      $stmt = $pdo->query($sql);
      $results = $stmt->fetchAll();
       foreach ($results as $row){
         if($_POST["blank"]==$row['id']){
          $id = $_POST["blank"];
          $name = $_POST["name"];
          $comment = $_POST["comment"]; 
          $sql = 'update 掲示板。 set name=:name,comment=:comment where id=:id';
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':name', $name, PDO::PARAM_STR);
          $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
      }   
    }    

?>    

<html>

<meta charset="UTF-8">

<form action="mission_5-1.php" method="POST">

 名前: <input type="text" name="name" value="<?php
          if(!empty($namae)){
          echo $namae ;
        } ?>" /><br/>

 コメント: <input type="text" name="comment" value="<?php
        if(!empty($message)){
          echo $message ;
        } ?>" /><br/>

パスワード: <input type="text" name="pass" /><br/>

  <input type="hidden" value="<?php
   if(!empty($namae)&& !empty($message)){
 echo $_POST["edit"];
  } ?>" name="blank"/>

 <input type="submit" /><br/>

<br/>

削除対象番号: <input type="text" name="delete" value="" /><br/>

パスワード: <input type="text" name="delpass" /><br/>

<input type="submit" value="削除" /><br/>

<br/>

編集対象番号: <input type="text" name="edit" value="" /><br/>

パスワード: <input type="text" name="editpass" /><br/>

<input type="submit" value="編集" />

</form>

</html>


<?php
  
    $sql = 'SELECT * FROM 掲示板。';
	  $stmt = $pdo->query($sql);
	  $results = $stmt->fetchAll();
	   foreach ($results as $row){
      echo $row['id'].',';
      echo $row['name'].',';
      echo $row['comment'].',';
      echo $row['dt'].'<br>';
    echo "<hr>";
      }

?>

