<?php

namespace app\controllers;

use app\core\Controller;
use app\models\User;
use app\core\Input;
use app\core\Helper;
use app\core\Session;
use app\core\Config;

class UserController extends Controller
{
    public $user;

    public function __construct($controller, array $params = [])
    {
        parent::__construct($controller, $params);
        $this->user = new User();

    }

    public function actionRegister()
    {
        $this->set('title', 'Register');
        $this->user->validation_rules = $this->user->scenario['register'];
        if (Input::isPost()) {
            $this->user->validate(Input::getPost());
            if ($this->user->validation){
                $this->set('errors', $this->user->getErrors());
            } else {
                if($this->user->toRegister()) {
                    Session::flashMessage('message', 'Congratulations! You have been registered!');
                    Helper::redirect('/user/login');
                } else {
                    Session::flashMessage('message', 'Oops! Something went wrong!');
                }

            }
        }
    }

    public function actionLogin()
    {
        $this->set('title', 'Login');
        $this->user->validation_rules = $this->user->scenario['login'];
        if(Input::isPost()) {
            $this->user->validate(Input::getPost());
            if ($this->user->validation){
                $this->set('errors', $this->user->getErrors());
            } else {
                $this->user->toLogin(Input::input('login'), Input::input('password'));
                if ($this->user->is_logged) {
                    Session::put('id', $this->user->id);
                    Helper::redirect('/message/');
                } else {
                    Session::flashMessage('message', 'Incorrect values');
                }
            }
        }
    }

    public function actionLogout()
    {
        Session::delete(Config::get('session/userId'));
        Session::destroy();
        Session::flashMessage('message', 'Thanks for visiting!');
        Helper::redirect('/user/login');
    }

    public function actionIndex()
    {

    }

}