<?php
/* session_start(); */
if (!isset($_SESSION['id']) || (trim($_SESSION['id']) == '')) { ?>
    <script>
        window.location = "login.php";
    </script>
<?php
}
$session_id = $_SESSION['id'];
?>