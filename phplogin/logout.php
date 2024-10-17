<?php 
session_start();
session_destroy();
// Send til loginside
header('Location: index.html');
?>