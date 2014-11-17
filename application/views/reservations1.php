<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center bottom-space">
			<h1>Reservations - Dates</h1>
			<p><?= anchor('index.php?/reservations/printCtlr','controller source') ?> |
			<?= anchor('index.php?/reservations/printView/1','view source') ?> | <?= anchor('index.php?/reservations/printModel','view model') ?></p>
			<p>	Select Dates | 
				Rooms & Rates | 
				Payment and Guest Info |
				Confirmation 
			</p>
			<div class="all-40 push-right left-space">
				<h3>Availability Calendar</h3>
				<div id="availCalendar">
					<?= $calendar ?>
				</div>
				<a href="index.php?/reservations/refresh" class="ink-button">Refresh Reservation Database</a>
			</div>
			<div class="all-30 push-left">
				<?= form_open('index.php?/reservations/selectDates/continue'); ?> 
				<?=  (isset($error_msg))? $error_msg:'' ?>
				<h3>Reservation Dates</h3>
				<h4>Arrival Date</h4>
				<input type="text" id="arrivalDate" name="arrivalDate" value="<?= (isset($arrivalDate)) ? $arrivalDate : "" ?>" >
				<p class="ink-label red arrival-msg"></p>
				<h4>Departure Date</h4>
				<input type="text" id="departureDate" name="departureDate" value="<?= (isset($departureDate)) ? $departureDate : "" ?>" >
				<p class="ink-label red departure-msg"></p>
				<?= form_submit('submitForm', 'Continue', 'class="ink-button push-right"'); ?> 
				<?= form_close(); ?> 
 			</div>
		</div>
	</div>
</div>		
	
<script type="text/javascript">
	var start;
	var end;
	function range(start, end)
	{   
		var array = new Array();
	    var start_day = start.split('-');
	    var end_day = end.split('-')
	    var start_date = start_day[2];
	    var end_date = end_day[2];
	    for(var i = start_date; i < end_date; i++)
	    {
	        array.push(start_day[0]+'-'+start_day[1]+'-'+i);
	    }
	    return array;
	};
	$(function() {
		$( "#arrivalDate" ).datepicker({ 
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				start = selectedDate;
				$( "#departureDate" ).datepicker( "option", "minDate", selectedDate );
				<? foreach( $unavailable_dates as $date): 
					$d = strtotime($date->date); ?>
					if (selectedDate== '<?= date("Y-m-j", $d) ?>') {
						$('p.arrival-msg').html("We're sorry, no rooms available for the dates selected <br> The dates selected are impossible!");
						return false;
					}
					else {
						$('p.arrival-msg').html("");
					}
			  	<? endforeach ?>
			},
			minDate: 0, 
			maxDate: "+1M +10D",
			dateFormat: "yy-m-d",
		});

		//Departure Date datepicker 
		$( "#departureDate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			numberOfMonths: 1,
			onClose: function( selectedDate ) {
				end = selectedDate;
				var dates_arr = range(start,end);
				$( "#arrivalDate" ).datepicker( "option", "maxDate", selectedDate );
				<? foreach( $unavailable_dates as $date): 
					$d = strtotime($date->date); ?>
					if (selectedDate== '<?= date("Y-m-j", $d) ?>') {
						$('p.departure-msg').html("We're sorry, no rooms available for the dates selected <br> The dates selected are impossible!")
						return false;
					}
					else {
						$('p.departure-msg').html("");
					}
					if ($.inArray("<?= $date->date ?>", dates_arr) > 0){
						$('p.departure-msg').html("We're sorry, but there are no rooms available for the dates selected <br> The dates selected are impossible!")
						return false;
					}
					else {
						$('p.departure-msg').html("");
					}
			  	<? endforeach ?>
			},
			dateFormat: "yy-m-d"
		});
	});
</script>