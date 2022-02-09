<?php
$pdo = new PDO('sqlite:../data/dataBlog.db', null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
]);
$pdo->beginTransaction();
$pdo->exec('UPDATE posts SET name = "demo" WHERE id = 7');
$pdo->exec('UPDATE posts SET content = "demo" WHERE id = 7');
$post = $pdo->query('SELECT * FROM posts WHERE id = 7')->fetch();
var_dump($post);
$pdo->rollback();
?>