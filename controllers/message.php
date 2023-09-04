<?php

if(isset($_SESSION['message'])){
    echo "<div class='alert alert-fill alert-icon alert-secondary alert-dismissible' role='alert'>
    <em class='icon ni ni-alert-circle'>
    </em>"
    .$_SESSION['message'].
    "</em>
    </div>";
    unset($_SESSION['message']);
}

?>