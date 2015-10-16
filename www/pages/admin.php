<?php if (!empty($this->Channels)): ?>
	<h1>Каналы:</h1>
	<table class="table table-hover">
		<?php foreach ($this->Channels as $channel): ?>
			<?php if ($channel['isAvail'] === '1'): ?>
				<tr>
					<td><?php echo $channel['name']; ?></td>
					<td>
						<span onclick="edit_chan(<?php echo "'".$channel['name']."','".$channel['id']."'"; ?>);" class="glyphicon glyphicon-pencil"></span>
						<a href="index.php?page=admin&act=del&id=<?php echo $channel['id']; ?>"><span class="glyphicon glyphicon-trash"></span></a>
					</td>
				</tr>
			<?php endif ?>
		<?php endforeach ?>
	</table>
<?php endif ?>

<form class="form-inline" action="index.php?page=admin" method="POST">
	<div class="form-group">
    	<label id="chan_lbl" for="exampleInputName2">Название</label>
    	<input type="text" class="form-control" name="chann_name" id="cr_chann" value="">
  	</div>
  	<input type="hidden" name="chan_id" id="chan_id" value="">
  	<button type="submit" onclick="return checkVal();" id="chan_btn" name="crt_chann" class="btn btn-default">Создать канал</button>
  	<button type="submit" id="crt_btn" name="crt_chann" onclick="return crt_chan();" class="btn btn-default">Создать канал</button>
</form>
<div class="adm_left">
	<h4 class="text-center">Приватные сообщения:</h4>
	<div class="mess_box" id="mess"></div>
</div>
<div class="users">
	<h4 class="text-center">Пользователи:</h4>
	<div class="user_box" id="users"></div>
</div>

<script src="js/admin.js"></script>


