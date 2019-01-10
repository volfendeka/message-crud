<div class="row">
	<h3>Do you want to delete message?</h3>

	<form method="POST" action="/message/delete/<?=$id?>">
		<input type="submit" class="btn btn-success" value="Yes!">
	</form>
	<a class="btn btn-primary" href="/message">No!</a>
</div>