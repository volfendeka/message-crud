<?php
use app\core\Helper;
use app\core\Input;
?>

<div class="row">
    <form class="form-horizontal" method="POST" action="/user/register">
        <div class="form-group">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'username');
            endif; ?>
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?=Input::input('username')?>">
        </div>

        <div class="form-group">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'email');
            endif; ?>
            <label for="email">E-mail:</label>
            <input type="text" class="form-control" id="email" name="email" value="<?=Input::input('email')?>">
        </div>

        <div class="form-group">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'password');
            endif; ?>
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'repeat_password');
            endif; ?>
            <label for="repeat_password">Confirm password:</label>
            <input type="password" class="form-control" id="repeat_password" name="repeat_password">
        </div>

        <div class="form-group">
            <input class="btn btn-success" type="submit" value="Register">
        </div>
    </form>
</div>