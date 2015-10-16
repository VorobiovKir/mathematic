<script>

  	var curChannel = '<?php echo $this->Channels[0]['id']; ?>';

  	function  getMesAjax() {
		$.ajax({
		  	url: 'ajax.php',
		  	type: 'POST',
		  	data: ({
				channel: curChannel,
				<?php if (Author::check()) echo "us_id: {$_SESSION['us_id']},"; ?>
				act: 'select'
		  	}),
		  	cache: false,
		  	dataType: 'html',
		  	success: funcSucc
			});
  	}
  
  	function  getPrivName(evt) {
	
		<?php if (!Author::check()) echo 'return false;'; ?>

		evt = event || window.event;
		var tar = evt.target || evt.srcElement;

		var name = tar.innerHTML.slice(0, -1);
		var text = "Private: " + name + ", ";
		$('#msg_' + curChannel).val(text);
		$('#msg_' + curChannel).focus();
  	}

  	function  sendMess(evt) {
	
		<?php if (!Author::check()) echo 'return true;'; ?>
	
		evt = event || window.event;
		var tar = evt.target || evt.srcElement;

		var channel_num = getChanNum(tar.id, 'click_');

		var msg = document.getElementById('msg_' + channel_num).value;
	
		if (msg === '') {
	  		alert('please write the message');
	  		return false;
		}

		$.ajax({
	  		url: 'ajax.php',
	  		type: 'POST',
	  		data: ({
				channel: channel_num,
				act: 'insert',
				<?php if (Author::check()) echo "us_id: {$_SESSION['us_id']},"; ?>
				msg: msg
	  		}),
	  		cache: false,
	  		dataType: 'html',
	  		success: funcSuccIn
		});

		return false;
  	}

  	$(document).ready(function() {
		setInterval(update, 1000);
	});

	function  getMess(evt) {

		evt = event || window.event;
		var tar = evt.target || evt.srcElement;

		var num = getChanNum(tar.href, 'tab1_');
		window.curChannel = num;    
	}


	function  del_mess(id) {
	
		var id = id;
	
		$.ajax({
			url: 'ajax.php',
			type: 'POST',
			data: ({
		  		mes_id: id,
		  		channel: curChannel,
		  		act: 'delete'
			}),
			cache: false,
			dataType: 'html'
		})

		return false;
	}

	function  update() {
		getMesAjax();
		$('#logs_' + curChannel).scrollTop(1000000);
	}

	function getChanNum(id, str) {
		var fullId = id;
		var mainWord = str;
		var str = fullId.indexOf(mainWord) + mainWord.length;
	
		if (str < mainWord.length) return true;

		return fullId.substring(str);
	}

	function  funcSucc(data) {
		$('#logs_' + curChannel).html(data);
	}

	function  funcSuccIn(data) {
		$('#msg_' + curChannel).val('');
	}

</script>