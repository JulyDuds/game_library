<?php
function isAdmin() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}
?>
