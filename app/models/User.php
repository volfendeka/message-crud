<?php

namespace app\models;

use app\core\Config;
use app\core\Model;
use app\core\Input;
use app\core\Helper;
use app\core\Session;
use app\core\Validation;


class User extends Model
{
    protected $use_table = 'user';

    public $is_logged = false;
    public $id;

    public $scenario = [
        'login' => [
            'username' => [
                'required' => true
            ],
            'password' => [
                'required' => true,
            ]
        ],

        'register' => [
            'username' => [
                'required' => true,
                'max' => 16,
                'min' => 4,
                'unique' => true,
            ],
            'email' => [
                'required' => true,
                'email' => true,
                'unique' => true,
            ],
            'password' => [
                'required' => true,
                'max' => 16,
                'min' => 3,
                'matches' => 'repeat_password',
            ]
        ]

    ];

    public function toLogin($login, $password)
    {
        $user = $this->find('*', ['username', '=', $login]);
        if($user[0]['password'] == Helper::hash($password)){
            $this->id = $user[0]['id'];
            $this->is_logged = true;
            return true;
        }
    }

    public function toRegister()
    {
        return $this->insert([
            'username' => Input::input('username'),
            'email' => Input::input('email'),
            'password' => Helper::hash(Input::input('password'))
        ]);
    }

}