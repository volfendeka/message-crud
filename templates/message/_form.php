<?php
use app\core\Helper;
use app\core\Input;
use app\core\Session;
?>

<div id="message"></div>
<div class="row">

	<form id="form" enctype="multipart/form-data" method="POST" class="form-horizontal" action="<?php echo (isset($data)) ? '/message/update/' . $data['id'] : '/message/create';?>">

		<input type="hidden" id="messageId" value="<?php echo (isset($data)) ? $data['id'] : ''; ?>">

		<div class="form-group name">
			<?php if (isset($errors)) :
				echo Helper::showErrors($errors, 'name');
			endif; ?>
			<label for="name">Name:</label>
			<input type="text" class="form-control" id="name" name="name" value="<?php echo (isset($data)) ? $data['name'] : Input::input('name');?>">
		</div>

        <div class="form-group email">
            <?php if (isset($errors)) :
                echo Helper::showErrors($errors, 'email');
            endif; ?>
            <div class="lat-error error"></div>
            <label for="lat">E-mail:</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo (isset($data)) ? $data['email'] : Input::input('email');?>">
        </div>

		<div class="form-group body">
			<?php if (isset($errors)) :
				echo Helper::showErrors($errors, 'body');
			endif; ?>
			<label for="body">Message:</label>
			<input type="text" class="form-control" id="body" name="body" value="<?php echo (isset($data)) ? $data['body'] : Input::input('body');?>">
		</div>

        <div class="form-group image">
            <label for="image">Image:</label>
            <input class="btn btn-success" type="file" id="image" name="image" accept="image/*">
        </div>

		<div class="form-group">
			<input class="btn btn-success col-lg-2" type="submit" id="save" value="Save">
		</div>

	</form>

    <button class="btn btn-primary col-lg-1" id="preview" data-toggle="modal" data-target="#modal">Preview</button>
</div>



<div class="modal fade" id="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Message preview</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Name</th>
                        <th>Message</th>
                        <th>E-mail</th>
                        <th>Image</th>
                    </tr>
                    <tr>
                        <td id="preview_name"></td>
                        <td id="preview_body"></td>
                        <td id="preview_email"></td>
                        <td><img id="preview_img"/></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
