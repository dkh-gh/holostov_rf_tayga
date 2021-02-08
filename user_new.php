
<?php
    
    include 'funcs.php';
    
    html("start", 0);
    
    if(!get("user")) {
        html("loginForm", 0);
    }
    else {
        html("hello", 0);
        html("menu", 0);
    }
    
    html("end", 0);
    
?>
