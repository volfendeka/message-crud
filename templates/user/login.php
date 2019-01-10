<?php
use app\core\Helper;
use app\core\Input;
?>

<div class="row">
    <form class="form-horizontal" method="POST" action="/user/login">
        <div class="form-group">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'login');
            endif; ?>
            <label for="login">Username or E-mail:</label>
            <input class="form-control" id="login" type="text" name="login" value="<?=Input::input('login')?>">
        </div>

        <div class="form-group">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'password');
            endif; ?>
            <label for="password">Password:</label>
            <input class="form-control" id="password" type="password" name="password">
        </div>

        <div class="form-group">
            <input class="btn btn-success" type="submit" value="Log In">
            <a class="btn btn-primary" href="/user/register">Register!</a>
        </div>
    </form>
</div>

