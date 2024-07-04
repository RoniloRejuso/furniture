<?php

if (!isset($_SESSION['user_id']) || (trim($_SESSION['user_id']) == '')) { ?>
    <script>
        window.location = "user_index.php";
    </script>
<?php
}
$session_id = $_SESSION['user_id'];
?>