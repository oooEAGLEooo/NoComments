<?php
require "connection_db.php";
?>
<!DOCTYPE HTML>
<html lang="ru">
<head>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $config['title']?> - cтраница с контентом</title>
    <meta name="description" content="Описание"> 

    <!-- Bootstrap CSS (jsDelivr CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Bootstrap Bundle JS (jsDelivr CDN) -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
 
<?php include "header.php"?>

<div class="container" id="add">
 <main role="main" class="pb-3">
  <section>
   <div class="">
    <div class="">
        <h1>Контент</h1>
        <img src="img/Картинка.png" alt="Контент не загрузился">
        <hr>
    </div>

    <div >
        <form id="sendForm" method="POST" action="/index.php#add">
            <?php
            $errors = array();
            if (($_POST['username'] == '') || ($_POST['comment'] == '')){
                $errors = 'Ошибка заполнения формы!';
            } else {
                mysqli_query($connection, "INSERT INTO `comments` (`username`, `date`, `comment`) VALUES ('".$_POST['username']."', NOW(),'".$_POST['comment']."')");
            }
            ?>
            <h2>Оставить комментарий</h2>
            <table>
             <tr>
                 <td>Имя:</td>
                 <td><input name="username" placeholder="Введите ваше имя..." value='<?php echo $_POST['username']?>'></td>
             </tr>
             <tr>
                 <td>Текст комментария:</td>
                 <td><textarea name="comment" placeholder="Введите текст комментария..." value='<?php echo $_POST['comment']?>' ></textarea></td>
             </tr>
             <tr>
                <td><div class="g-recaptcha" data-sitekey="6LfOzlQiAAAAAKdt4j0PYWqyfTdsEK2w_L9kF5pA" style="margin-bottom:1em";></div></td>
                <td><input type="submit" class="btn btn-sm btn-primary" value="Добавить комментарий"/></td>
                <td>                            
                    <?php
                    if (empty($errors)){
                        ?>
                        <script language="JavaScript">
                            alert("<?php echo $_POST['username']?>, ваш коментарий успешно добавлен!");
                        </script>
                        <?php
                    } else {
                        ?>
                        <script language="JavaScript">
                            document.getElementById('sendForm').onsubmit = function () {
                                if (!grecaptcha.getResponse()) {
                                   alert('Вы не заполнили поле Я не робот!');
         return false;
     }
 }
</script>
<?php
echo "<p style='color:#FF0000'>Для добавления комментария заполните поля!</p>";
}
?></td>
</tr>
</table>
</form>
<hr>
</div>

<div id="delete">
    <?php
    $comments = mysqli_query($connection, "SELECT * FROM comments GROUP BY `date` DESC");
    if ($comments->num_rows) {
        echo "<h2>Все комментарии</h2>";
        echo "<table class='table'><tr><th>Дата</th><th>Имя</th><th>Коментарий</th><th></th></tr>";
        echo "<tr>";
        while ($comment = mysqli_fetch_assoc($comments)) {
            echo "<td>" . date("H:i:s d M Y", strtotime($comment['date'])) . "</td>";
            echo "<td>" . $comment["username"] . "</td>";
            echo "<td>" . $comment["comment"] . "</td>";
            echo "<td><form action='delete.php#delete' method='post'>
            <input type='hidden' name='id' value='" . $comment["id"] . "' />
            <input class='btn btn-sm btn-danger' type='submit' value='Удалить комментарий'>
            </form></td>";
            echo "</tr>";
        } 
        echo "</table>";
    } else {
        echo "<h2>Комментариев нет</h2>";
    }

    ?>
</div>
</div>
</section>
</main>
</div>

<?php include "footer.php"?>
</body>
</html>
<?php
mysqli_close($connection);
?>