<?php
    include("partials/header.php");
?>

    <div class="main">
        <br>
        <br>
        User Id:
        <br>
        <?php
            echo $_SESSION["user_id"];
        ?>
        <br><br>
        User Name:
        <br>
        <?php
            echo $_SESSION['username'];
        ?>
        <br><br>
        Email:
        <br>
        <?php
            echo $_SESSION['email'];
        ?>
        <br>
        <br>
    </div>

<?php
    include("partials/footer.php");
?>