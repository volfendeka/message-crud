<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Input;
use app\core\Helper;
use app\core\Config;
use app\models\Message;
use app\tools\Image;

class MessageController extends Controller
{

    public $image;
    public $message;

    public function __construct($controller, array $params = [])
    {
        parent::__construct($controller, $params);
        $this->image = new Image();
        $this->message = new Message();

    }

    public function actionIndex($column = 'created_time', $order = 'DESC', $start = 1)
    {
        $this->set('title', 'Messages');
        $pagination_params = $this->message->getPaginationParams($start);
        $this->set('params',[
            'order' => $this->message->getSortingOrder(strtoupper($order)),
            'current_order' => strtoupper($order),
            'pagination' => $pagination_params,
            'column' => $column,
        ]);
        $this->set('messages', $this->message->getMessages($column, $order, $pagination_params['start_item'], Config::get('pagination/per_page')));
    }

    public function actionCreate()
    {
        $this->set('title', 'Create Message');
        $this->message->validation_rules = $this->message->scenario['message'];
        if (Input::isPost()) {
            $this->message->validate(Input::getPost());
            if ($this->message->validation) {
                $this->set('errors', $this->message->getErrors());
            } else {
                $this->message->saveMessageImage($this->message, $this->image);
            }
        }
    }

    public function actionUpdate($id)
    {
        $this->set('title', 'Update Message');
        $this->message->validation_rules = $this->message->scenario['message'];
        if (Input::isPost()) {
            $this->message->validate(Input::getPost());
            if ($this->message->validation) {
                $this->set('errors', $this->message->getErrors());
            } else {
                $data = $this->message->findMessageById($id);
                $this->image->file_name = $data['image'];
                $this->message->saveMessageImage($this->message, $this->image, $id);
            }
        }
        $this->set('data', $this->message->findMessageById($id));
    }

    public function actionDelete($id)
    {
        $this->set('title', 'Delete Message');

        if (Input::isPost()) {
            $item = $this->message->findMessageById($id);
            if($this->message->deleteRecord(['id', '=', $id])){
                if(is_file(Config::get('image/path').$item['image'])){
                    //unlink(Config::get('image/path').$item['image']);
                }
                Helper::redirect('/message');
            }
        }
        $this->set('id', $id);
    }

    public function actionError()
    {
        $this->set('title', 'Error');
    }
}
