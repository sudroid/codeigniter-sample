<div id="content">
  <div class="ink-grid">
    <div class="column-group push-center bottom-space">
        <div class="all-35 push-center">
          <h1><?= lang('login_heading');?></h1>
          <p class="ink-label orange"><?= lang('login_subheading');?></p>
          <div id="infoMessage" class="ink-label red"><?= $message; ?></div>
          <?= form_open("index.php?/auth/login", 'class="ink-form"');?>
            <div class="control-group">
              <label for="username" class="all-30 align-left">Username: </label>
              <div class="control all-70">
                <?= form_input($identity);?>
              </div>
            </div>
            <div class="control-group">
              <label for="password" class="all-30 align-left">Password</label>
              <div class="control all-70">
                <?= form_input($password);?>
              </div>
            </div>
            <div class="control-group">
              <div class="control all-30 align-right">
                <?= form_submit('submit', 'Submit', 'class="ink-button"');?>
              </div>
            </div>
          <?= form_close();?>
        </div>
    </div>
  </div>
</div>