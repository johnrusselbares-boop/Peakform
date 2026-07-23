<?php

include 'db.php';

session_unset();

session_destroy();

header("Location: peakform.php");

exit();
