<?php
if(isset($_SESSION['usr'])) {
    header("Location: /home");die;
} else {
    header("Location: /explore/");die;
}