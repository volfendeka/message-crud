<?php
use app\core\Session;
use app\core\Config;
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
	        <title><?=$title?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" type="text/css" href="/webroot/css/style.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            </head>
        <body>
            <header class="page-header row">
                <div class="col-sm-offset-1 col-sm-6">
                    <form method="POST" action="/user/logout">
                        <a class="btn btn-primary col-lg-1" href="/message">Main</a>
                        <?php if(Session::exists('id')) : ?>
                            <input class="btn btn-default" formaction="/user/logout" type="submit" value="Log Out">
                        <?php else: ?>
                            <input class="btn btn-default" formaction="/user/login" type="submit" value="Log In">
                        <?php endif ?>
                        <a class="btn btn-primary" href="/message/create">New message</a>
                    </form>
                </div>
            </header>
            <div class="container">
                <?php echo $output; ?>
            </div>
            <footer class="navbar-fixed-bottom text-center">
                &copy;<?=date('Y')?>
            </footer>
        </body>

    <script src="/webroot/js/pageWidget.js"></script>
    <script src="/webroot/js/eventHandler.js"></script>
    <script src="/webroot/js/init.js"></script>
</html>