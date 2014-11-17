<div id="content">	
	<div class="ink-grid">
		<h1>Rooms and Rates</h1>	
		<p><?= anchor('index.php?/roomrates/printCtlr','controller source') ?> |
		<?= anchor('index.php?/roomrates/printView','view source') ?> | <?= anchor('index.php?/roomrates/printModel','view model') ?></p>
		<p>click on the room to see more details</p>
		<? if(!isset($editRoom)): ?>
		<!-- User view -->
			<div class="column-group push-center all-90">
				<? foreach($roomrates as $roomrate): ?>
					<h3 class="room_title"><span class="ink-label black"><?= $roomrate->number ?> - <?= $roomrate->name ?>:</span> 
						<span class="ink-label green">$<?= $roomrate->rate ?></span></h3>
					<div class="room_description">
						<blockquote><p><?= $roomrate->description ?></p></blockquote>
						<a class="ink-button" href="<?= $link.'edit/'.$roomrate->id ?>"><span class="fa fa-edit"></span></a> 
						<a  class="ink-button" href="<?= $link.'delete/'.$roomrate->id ?>"><span class="fa fa-trash"></span></a>
						<div style="clear:both; padding-bottom:50px"></div>
						<div class="push-right column-group">
							<a class="ink-button" href="<?= $link.'add' ?>"><span class="fa fa-plus-square-o"></span></a> 
						</div>
					</div>
				<? endforeach ?>
			</div>
		<? else: ?>
		<!-- End user view -->
		<!-- Edit view -->
		<div class="column-group push-center all-90">
			<form action="<?= $link ?>" method="post"> 
				<? foreach($editRoom as $room): ?>
				<input id="id" name="id" value="<?= $room->id ?>" type="hidden" />
				<div class="control-group column-group gutters">
			        <label for="RoomNo" class="all-20 align-right">Room Number</label>
			        <div class="control all-80">
			            <input id="number" name="number" type="text" value="<?= $room->number ?>">
			        </div>
			    </div>
			    <div class="control-group column-group gutters">
			        <label for="RoomName" class="all-20 align-right">Room Name</label>
			        <div class="control all-80">
			            <input id="name" name="name" type="text" value="<?= $room->name ?>">
			        </div>
			    </div>
			    <div class="control-group column-group gutters">
			        <label for="RoomRate" class="all-20 align-right">Room Rate</label>
			        <div class="control all-80">
			            <input id="rate" name="rate" type="text" value="<?= $room->rate ?>">
			        </div>
			    </div>
				<textarea name="description" id="description" rows="10" cols="80">
					<?= $room->description ?>
				</textarea>
				<input class="ink-button push-right" type="submit" name="submit" value="SAVE" />
				<script>
					CKEDITOR.replace( 'description', {
		                filebrowserBrowseUrl: '<?=$_SERVER['PHP_SELF']?>?/roomrates/browse?type=Images',
		                filebrowserUploadUrl: '<?=$_SERVER['PHP_SELF']?>?/roomrates/upload?type=Files' 
            		});
				</script>
				<? endforeach ?>
			</form>
		</div>
		<!-- End edit view -->
		<? endif; ?>
	</div>
</div>
<div style="clear:both; padding-bottom:50px"></div>	
			
			
	