<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center bottom-space">
			<h1>Reservations - Rooms</h1>
			<p><?= anchor('index.php?/reservations/printCtlr','controller source') ?> |
			 <?= anchor('index.php?/reservations/printView/2','view source') ?> | <?= anchor('index.php?/reservations/printModel','view model') ?></p>
			<p>	<?= anchor('index.php?/reservations/selectDates/jumpTo','Select Dates') ?> | 
				Rooms & Rates | 
				Payment and Guest Info |
				Confirmation |
			</p>
			<div class="all-60 push-center ">
				<h3>Your present choices are:</h3>
				<div class='ink-alert basic info'>
					<p><strong>Arrival Date:</strong> <span id="arrivalDate"><?= $arrivalDate ?></span></p>
					<p><strong>Departure Date:</strong> <span id="departureDate"><?= $departureDate ?></span></p>
					<p><strong>Rooms:</strong> 1 </p> <p><strong>Nights:</strong> <span id="duration"><?= $duration ?></p>
					<p><strong>Selected Room:</strong> <span id="selectedRoom"></span> </p>
					<p><strong>Total Charge:</strong> <span id="selectedRoomPrice"></span></p>
				</div>
 			</div>
 			<div class="all-60 push-center ">
 				<div class="available-section">
 					<h3>Available Rooms</h3>
 					<div id="room_display" class="ink-alert block info">
 						<button class="ink-dismiss">&times;</button>
 						<h4 id="room_header"></h4>
 						<div id="room_description"></div>
 					</div>
 					<table class="ink-table">
 						<thead>
							<tr>
								<th class="align-left">Room</th>
								<th class="align-left">Rate</th>
								<th class="align-left"></th>
								<th class="align-left"></th>
							</tr>
						</thead>
						<? 	if ($available_rooms != ""):
							 foreach ($available_rooms as $room): ?>
 							<tr>
	 							<td>
	 								<?= 'Room '.$room->number.' - '. $room->name; ?>
			 					</td>
			 					<td>
			 						<?= '$ '.$room->rate; ?>
			 					</td>
			 					<td>
			 						<?= anchor ('','Info', array('id' => $room->number, 'class'=>'room_info')) ?>
			 					</td>
			 					<td>
			 						<?= anchor ('','Select', array('id' => $room->number, 'class'=>'select_room')) ?>
			 					</td>
			 				</tr>
			 			<? endforeach; endif; ?>
 					</table>
				</div>
				<div class="unavailable-section">
 					<h3>Rooms not availabe</h3> 
 					<table class="ink-table">
 						<thead>
							<tr>
								<th class="align-left">Room</th>
								<th class="align-left">Rate</th>
								<th class="align-left"></th>
							</tr>
						</thead>
						<? 	if ($unavailable_rooms != ""): 
							foreach ($unavailable_rooms as $room): ?>
 							<tr>
	 							<td>
	 								<?= 'Room '.$room->number.' - '. $room->name; ?>
			 					</td>
			 					<td>
			 						<?= '$ '.$room->rate; ?>
			 					</td>
			 					<td>
			 						<?= anchor ('','Info', array('id' => $room->number, 'class'=>'room_info')) ?>
			 					</td>
			 				</tr>
			 			<? endforeach;
			 			   endif; ?>
 					</table>
 				</div>
 			</div>
 			<div class="all-80">
 				<?= form_open('index.php?/reservations/confirmation/continue', 'id="continue"'); ?> 
 				<?= form_hidden('room_number', '', 'id="room_number"'); ?>
 				<?= form_submit('submitForm', 'Continue', 'class="ink-button push-right"'); ?> 
				<?= form_close(); ?> 
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function() { 

		$('div#room_display').hide();

		$('a.select_room').click(function(e) {
			$.ajax({
				type: "POST",
				url: "index.php?/reservations/roomsRates/pickRoom",
				data: { room_number : $(this).attr('id')},
				dataType: 'json',
				success: function(data){
					$('span#selectedRoom').html('Room '+data.selected_room[0]['number']+' - '+data.selected_room[0]['name']);
					$('span#selectedRoomPrice').html('$'+data.selected_room[0]['rate']);
					$('input:hidden').attr('value', data.selected_room[0]['number']);
				},
				error: function(){
					console.log('fail');
				}
			});
			return false;
		});

		$('a.room_info').click(function(e) {
			$('div#room_display').show();
			$.ajax({
				type: "POST",
				url: "index.php?/reservations/roomsRates/pickRoom",
				data: { room_number : $(this).attr('id')},
				dataType: 'json',
				success: function(data){
					$('h4#room_header').html('Room '+data.selected_room[0]['number']+' - '+data.selected_room[0]['name']+": $"+data.selected_room[0]['rate']);
					$('div#room_description').html(data.selected_room[0]['description']);
				},
				error: function(){
					console.log('fail');
				}
			});
			return false;
		});

		$('button.ink-dismiss').click(function(){
			$('div#room_display').hide();
		});
	}) 
</script>