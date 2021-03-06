<?php defined('KOOWA') or die; ?>

<h3><?= @text('COM-ACTORS-PROFILE-EDIT-PERMISSIONS') ?></h3>
<form action="<?=@route($item->getURL())?>" method="post">

<div class="control-group">
	<label class="control-label"  for="actor-privacy">
		<?= @text('COM-ACTORS-PRIVACY') ?>
	</label>
	
	<div class="controls">
		<?= @helper('ui.privacy',array('auto_submit'=>false, 'entity'=>$item))?>
        <?php if($item->isFollowable()) : ?>
        <label class="checkbox">
            <input type="checkbox" name="allowFollowRequest" value="1" <?= $item->allowFollowRequest ? 'checked' : ''?> >
            <?= @text('COM-ACTORS-PERMISSION-CAN-SEND-FOLLOW-REQUEST') ?>
        </label>
        <script data-inline>
            (function(){
                var toggle = function() {
                    var select = document.getElement('select[name="access"]');
                    var allowRequest = document.getElement('input[name="allowFollowRequest"] !label');
                    if ( select.value == 'followers' ) {
                        allowRequest.show();
                    } else {
                        allowRequest.hide();
                    }
                };
                'select[name="access"]'.addEvent('change', toggle);
                toggle();
            })();
        </script>
        <?php endif; ?>
	</div>
</div>

<?php if($item->isAdministrable()): ?>
<div class="control-group">
	<label class="control-label"  for="leadables">
		<?= @text('COM-ACTORS-PERMISSION-CAN-ADD-LEADABLES') ?>
	</label>
	
	<div class="controls">
		<?= @helper('ui.privacy',array('entity'=>$item, 'name'=>'leadable:add', 'auto_submit'=>false))?>
	</div>
</div>
<?php endif; ?>

<?php foreach($components as $component) : ?>
	<input type="hidden" name="action"  value="setprivacy" />
	<fieldset>		
		<legend><?= $component->name ?></legend>
		<?php foreach($component->permissions as $permission) : ?>
			<div class="control-group">
				<label class="control-label" ><?= $permission->label ?></label>
				<div class="controls">
					<?= @helper('ui.privacy',array('entity'=>$item, 'name'=>$permission->name,'auto_submit'=>false))?>
				</div>
			</div>
		<?php endforeach;?>
	</fieldset>
<?php endforeach;?>

    <div class="form-actions">
        <button type="submit" class="btn" data-loading-text="<?= @text('LIB-AN-ACTION-SAVING') ?>">
            <?= @text('LIB-AN-ACTION-SAVE'); ?>
        </button>
    </div>
</form>