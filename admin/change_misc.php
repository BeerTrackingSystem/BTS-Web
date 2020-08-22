<?php
        include '../db.inc.php';
?>

<?php
        $title = $_POST['title'];
        $heading = $_POST['heading'];
        $admintitle = $_POST['admintitle'];
        $adminheading = $_POST['adminheading'];

        if (!empty($title))
        {
        $querychangetitle = "INSERT INTO misc (id, title) VALUES ('1', '$title') ON DUPLICATE KEY UPDATE title = '$title';";
        $changetitle = mysqli_query($db, $querychangetitle);
        }

        if (!empty($heading))
        {
        $querychangeheading = "INSERT INTO misc (id, heading) VALUES ('1', '$heading') ON DUPLICATE KEY UPDATE heading = '$heading';";
        $changeheading = mysqli_query($db, $querychangeheading);
        }

        if (!empty($admintitle))
        {
        $querychangetitle = "INSERT INTO misc (id, title) VALUES ('2', '$admintitle') ON DUPLICATE KEY UPDATE title = '$admintitle';";
        $changetitle = mysqli_query($db, $querychangetitle);
        }

        if (!empty($adminheading))
        {
        $querychangeheading = "INSERT INTO misc (id, heading) VALUES ('2', '$adminheading') ON DUPLICATE KEY UPDATE heading = '$adminheading';";
        $changeheading = mysqli_query($db, $querychangeheading);
        }

        header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>