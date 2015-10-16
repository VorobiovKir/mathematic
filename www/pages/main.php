<ul class="nav nav-tabs">
  <?php foreach ($this->Channels as $channel): ?>
      <li role="presentation" <?php if ($channel['id'] === '1') echo ' class="active"'; ?>>
        <a data-toggle="tab" onclick="getMess();" href="#tab1_<?php echo $channel['id']; ?>"><?php echo $channel['name']; ?></a>
      </li>
  <?php endforeach ?>
</ul>
<div class="tab-content">
  <?php foreach ($this->Channels as $channel): ?>
      <div id="tab1_<?php echo $channel['id']; ?>" class="tab-pabe fade <?php if ($channel['id'] === '1') echo ' active in'; ?>">
        <div id="mainChat_<?php echo $channel['id']; ?>" class="mainChat">
           <div class="logs" id="logs_<?php echo $channel['id']; ?>"></div>
            <textarea  
              maxlength='400'
              <?php if (!Author::Check()) echo " disabled placeholder='Войдите, чтобы оставить сообщение'"; ?>
              id="msg_<?php echo $channel['id']; ?>"></textarea>
            <div class="btn-group" role="group">
              <button type="button" <?php if (!Author::Check()) echo " disabled"; ?> id="click_<?php echo $channel['id']; ?>" onclick="return sendMess();" class="btn btn-default">Отправить</button>
            </div>
         </div>
      </div>
  <?php endforeach ?>
</div>

<?php require 'js/client_js.php'; ?>