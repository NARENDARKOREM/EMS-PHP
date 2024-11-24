<?php
session_start();
session_destroy();
header("Location:index.php?signup=success");
exit();
