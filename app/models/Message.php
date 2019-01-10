<?php

namespace app\models;

use app\core\Model;
use app\core\Config;
use app\tools\Image;
use app\core\Helper;
use app\core\Input;

class Message extends Model
{

    protected $use_table = 'message';

    public $scenario = [
        'message' => [
            'name' => [
                'required' => true,
                'max' => 20
            ],
            'email' => [
                'required' => true,
                'email' => true,
            ],
            'body' => [
                'required' => true,
                'max' => 255,
            ],
            'image' => [
                'required' => true,
            ]
        ]
    ];

    public function getMessages($column, $order, $start_page, $amount)
    {
        return $this->getAll('*', [$start_page, $amount, 'order' => $order, 'column' => $column]);
    }

    public function getSortingOrder($current){
        switch ($current){
            case 'ASC':
                $order = 'DESC';
                break;
            case 'DESC':
                $order = 'ASC';
                break;
            default:
                $order = 'ASC';
        }
        return $order;

    }
    public function getPaginationParams($page = 1){
        $start_item = ($page == "" || $page == "1")? 0 : ($page*Config::get('pagination/per_page'))- Config::get('pagination/per_page') ;
        $counter = count($this->getAll());
        $all_pages = ceil($counter/Config::get('pagination/per_page'));
        $prev = $page <=1 ? 1 : $page-1;
        $next = $page >= $all_pages ? $page : $page+1;
        $pagination_params = array(
            "current_page" => $page,
            "prev_page" => $prev,
            "next_page" => $next,
            "start_item" => $start_item,
            "all_pages" => $all_pages
        );
        return $pagination_params;
    }

    public function saveMessageImage($message, $image, $id = []){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $img = $_POST['imgBase64'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $file_data = base64_decode($img);
            unset($_POST['imgBase64']);
            $save_data = Input::getPost();
            if($message->saveMessage($save_data)) {
                file_put_contents(Config::get('image/path').$_POST['image'], $file_data);
                Helper::redirect('/message');
            }
        }else{
            $save_data = Input::getPost();
            if($image->uploadImage('image')){
                $save_data['image'] = $image->file_name;
                if($message->saveMessage($save_data, $id)) {
                    Helper::redirect('/message');
                }
            }
        }
    }


    public function saveMessage($message, $id = null)
    {
        $where = [];
        if($id) {
            $where = ['id', '=', $id];
        }
        return $this->save($message, $where);
    }

    public function findMessageById($id)
    {
        return $this->findById($id);
    }

}