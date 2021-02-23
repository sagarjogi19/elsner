<?php

use Carbon\Carbon;
use App\Category;

function be64($id) {
    return base64_encode($id);
}

function bd64($id) {
    return base64_decode($id);
}

?>