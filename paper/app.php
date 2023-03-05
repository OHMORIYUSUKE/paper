<?php
$dsn = 'mysql:dbname=webapp;host=localhost';
$user = 'webapp';
$password = 'webappのパスワード';
try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    print('Error:' . $e->getMessage());
    die();
}
// POST
if ($_POST['method'] == 'post') {
    $stmt = $dbh->prepare("INSERT INTO product (name, price) VALUES (:name, :price)");
    $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindParam(':price', $_POST['price'], PDO::PARAM_INT);
    $res = $stmt->execute();

    header('Location: index.php');
}
// DELETE
if ($_POST['method'] == 'delete') {
    $stmt = $dbh->prepare("DELETE FROM product WHERE name = :name AND price=:price");
    $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
    $stmt->bindParam(':price', $_POST['price'], PDO::PARAM_INT);
    $res = $stmt->execute();

    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>売店 | 管理画面</title>
</head>
<body>
    <form method="post" action="index.php">
        <input name="method" type="hidden" value="post">
        商品名
        <input type="text" name="name" size="15">
        価格(円)
        <input type="number" name="price">
        <input type="submit" value="送信">
    </form>
    <?php
    // GET
    $sql = 'select * from product';
    print('<p>商品名  価格(円)</p>');
    foreach ($dbh->query($sql) as $row) {
    ?>
        <form method="post" action="index.php">
            <?php print($row['name'] . ' ' . $row['price'] . '円   '); ?>
            <input name="method" type="hidden" value="delete">
            <input name="name" type="hidden" value="<?php print($row['name']); ?>">
            <input name="price" type="hidden" value="<?php print($row['price']); ?>">
            <input type="submit" value="削除">
        </form>
    <?php
    }
    ?>
</body>
</html>