/**
*	checked id user
*/
var id = null;

$(document).ready(function () {
	setInterval(update, 2000);
});

function 	setId(id) {
	window.id = id;
	return false;
}

function 	update() {
	getUsers();
	getMess();
}

function 	getUsers() {
	$.ajax({
       	url: 'ajax_ad.php',
       	type: 'POST',
       	data: ({
          	act: 'select_us'
       	}),
       	cache: false,
       	dataType: 'html',
       	success: funcSucc
    })
}

function 	getMess() {

	if (id === null) return;

	$.ajax({
		url: 'ajax_ad.php',
       	type: 'POST',
       	data: ({
           	act: 'select_mess',
           	id : id
       	}),
       	cache: false,
       	dataType: 'html',
       	success: funcSuccMess	
	});
}

function 	edit_chan(name, id) {
	$('#cr_chann').val(name);
	$('#chan_id').val(id);
	$('#chan_lbl').html('Старое название: <span class="old_n">' + name + '</span>');
	$('#chan_btn').html('Редактировать');
	$('#chan_btn').attr('name','edt_chann');
	$('#crt_btn').css('display', 'inline');
	$('#cr_chann').focus();
}

function 	crt_chan() {
	$('#cr_chann').val('');
	$('#chan_lbl').html('Название');
	$('#chan_btn').html('Создать канал');
	$('#chan_btn').attr('name', 'crt_chann');
	$('#crt_btn').css('display', 'none');
	$('#cr_chann').focus();

	return false;
}

function 	funcSuccMess(data) {
	$('#mess').html(data);
}


function 	funcSucc(data) {
	$('#users').html(data);
}

function  del_mess(mes_id) {
    
    var mes_id = mes_id;

    $.ajax({
     	url: 'ajax_ad.php',
      	type: 'POST',
      	data: ({
        	mes_id: mes_id,
        	act: 'delete'
      	}),
      	cache: false,
    	dataType: 'html'
    })

	return false;
}

function 	checkVal() {
	if ($('#cr_chann').val() == '') {
		alert('Заполните название канала')
		return false;
	}
}
	
