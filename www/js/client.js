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