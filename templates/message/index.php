<?php
use app\core\Session;
use \app\core\Config;
?>
<?php if (count($messages) > 0) : ?>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>
                <a href="/message/index/name/<?=$this->data['params']['order']?>">Name</a>
            </th>
            <th>
                <a href="/message/index/body/<?=$this->data['params']['order']?>">Message</a>
            </th>
            <th>
                <a href="/message/index/email/<?=$this->data['params']['order']?>">E-mail</a>
            </th>
            <th>Image</th>
            <?php if (Session::exists('id')) : ?>
                <th colspan="2" class="text-center">Actions</th>
            <?php endif; ?>
        </tr>
        </thead>

        <tbody>

        <?php
        foreach($messages as $key => $message) : ?>
            <tr>
                <td><?=$key+1?></td>
                <td><?=$message['name']?></td>
                <td><?=$message['body']?></td>
                <td><?=$message['email']?></td>
                <td><img src="<?=Config::get('base_path').Config::get('image/path').$message['image']?>" alt="Smiley face" width="32" height="24" ></td>
                <?php if (Session::exists('id')) : ?>
                    <td><a class="btn btn-primary" href="/message/update/<?=$message['id']?>">Update</a></td>
                    <td><a class="btn btn-primary" href="/message/delete/<?=$message['id']?>">Delete</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>

        </tbody>

    </table>
<?php endif; ?>

<div class="text-center">
    <a class="btn btn-primary" href="/message/index/<?=$this->data['params']['column']."/".$this->data['params']['current_order']."/".(int)$this->data['params']['pagination']['prev_page']?>">< prev</a>

    <?php
        for ($i=1; $i<=$this->data['params']['pagination']['all_pages'] ; $i++) { ?>
            <a class="btn btn-primary" href="/message/index/<?=$this->data['params']['column']."/".$this->data['params']['current_order']."/".$i?>"><?=$i?></a>
    <?php } ?>

    <a class="btn btn-primary" href="/message/index/<?=$this->data['params']['column']."/".$this->data['params']['current_order']."/".(int)$this->data['params']['pagination']['next_page']?>">next ></a>
</div>

<div>
    <a class="btn btn-primary" href="/message/create">Create Message</a>
</div>
