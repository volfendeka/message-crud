<?php

namespace app\tools;

use app\core\Config;

class Image
{

    public $error;
    public $file_name;
    public $target_file;
    public $image_file_type;
    public $form_name;


    public function getPath($image_name = '')
    {
        if(isset($image_name)){
            return Config::get('image/path').$image_name;
        }
        return Config::get('image/path');
    }

    public function uploadImage($image_form_name)
    {
        $this->form_name = $image_form_name;
        if(!empty($_FILES[$this->form_name]["name"])){
            $this->file_name = rand(100, 10000) . '.' . pathinfo($_FILES[$this->form_name]["name"], PATHINFO_EXTENSION);
        }else{
            $this->file_name = 'default.jpg';
            return true;
        }

        $this->target_file = $this->getPath() . $this->file_name;
        $this->image_file_type = pathinfo($this->target_file, PATHINFO_EXTENSION);

        if (empty($this->error)) {
            if ($this->converter($_FILES[$this->form_name]["tmp_name"])) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkFormat()
    {
        if(!empty($_FILES[$this->form_name]["tmp_name"])){
            if(getimagesize($_FILES[$this->form_name]["tmp_name"])) {
                if($this->image_file_type != "jpg" &&
                    $this->image_file_type != "gif" &&
                    $this->image_file_type != "png") {
                    $this->error = "Only JPG, GIF & PNG files allowed";
                } else{
                    $this->checkSize();
                }
            } else {
                $this->error = "File is not an image";
            }
        }
    }

    public function checkSize()
    {
        if ($_FILES[$this->form_name]["size"] > 500000) {
            $this->error = "Your file is too large";
        }
    }

    public function converter($file)
    {
        $size = getimagesize($file);
        $ratio = min(Config::get('image/width') / $size[0], Config::get('image/height') / $size[1]);
        $width = $ratio * $size[0];
        $height = $ratio * $size[1];
        $src = imagecreatefromstring(file_get_contents($file));
        $dst = imagecreatetruecolor($width,$height);
        imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
        $this->getImage($dst);
        imagedestroy($src);
        imagedestroy($dst);
        return true;
    }

    public function getImage($dst)
    {
        switch ($this->image_file_type){
            case 'jpg':
                imagepng($dst,$this->target_file);
                break;
            case 'gif':
                imagepng($dst,$this->target_file);
                break;
            case 'png':
                imagepng($dst,$this->target_file);
                break;
            default:
                $this->error = "Only JPG, GIF & PNG files allowed";
        }
    }

}