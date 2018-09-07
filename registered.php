<?php

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
}
else {
    if (version_compare(PHP_VERSION, '5.5.0', '<')) {
        // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
        // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
        require_once("libraries/password_compatibility_library.php");
    }
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();


if ($login->isUserLoggedIn() == true) {

    $config = include('inc/config.php');
    global $config;

    $conn = pg_connect($config['conn_str']);
    if ($conn === false) {
        die("Connection failed: " . pg_last_error($conn));
    }

    $html = '<div class="">';

    $rs = pg_query($conn, 'select * from fosdem_alive');

    if ($rs === false) {
        // TODO
    }
    else {
        //printf("Error: %s.\n", $stmt->error);
        while ($row = pg_fetch_assoc($rs))
            $html .= '<div class="bindline">'
                . '<span class="bindip"><span class="nobold">IP:</span>' . $row['ip'] . '</span>'
                . '<span class="posid"><span class="nobold">ID:</span>' . $row['posid'] . '</span>'
                . '<span class="bindtime"><span class="nobold">Last registered time:</span>' . $row['timepos'] . '</span>'
                . '<span class="bindid"><span class="nobold">Bound to :</span>' . $row['boundid'] . '</span>'
                . '<span class="bindselect" data-id="' . $row['posid'] . '"><span class="nobold">Select bind:</span>'
                . '<select></select></span>'
                . '</div>';
    }

    $html .= "</div>";

    pg_free_result($rs);
    pg_close($conn);

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title></title>

        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <div class="container">
        <div id="fosdemPosTitle">Fosdem Bindtool</div>
    </div>
    <div class="container bind">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title ">Current registered PoS</h3>
            </div>
            <div class="panel-body ">
                <?php echo $html; ?>
            </div>
        </div>
    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.6/handlebars.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/config.js"></script>
    <script src="js/mainadmin.js"></script>
    </body>
    </html>
    <?php
}
else {
    echo "Access denied.";
}
