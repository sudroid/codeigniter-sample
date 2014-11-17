<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center bottom-space">
			<h1>Reservation/Room Rental Activity Panel</h1>
			<p><?= anchor('index.php?/adminReservations/printCtlr','controller source') ?> |
			<?= anchor('index.php?/reservations/printView/1','view source') ?> | <?= anchor('index.php?/reservations/printModel','view model') ?></p>
			<div class="all-50 left-space">
				<h3>Availability Calendar</h3>
				<div id="availCalendar">
					<?= $calendar ?>
				</div>
			</div>
			<div class="all-40 left-space" id="rooms">
				<h3>Room List</h3>
				<div class="all-100">
					<ul id="room-list">
						<li><a href="#" id="room-info-link"></a></li>
					</ul>
				</div>
				<div class="all-100 ink-alert basic info" id="room-info">
				</div>
			</div>
		</div>
	</div>
</div>	

<script type="text/javascript"> 
	var selected_date;
	$(function(){
		$('div#rooms').hide();
		$('div#room-info').hide();
		$('div#availCalendar tr td a').click( function() {
			selected_date = '2014-11-' + $(this).attr('id');
			$('div#rooms').show();
			$.ajax({
				type: "POST",
				url: "index.php?/areservations/roomlist",
				data: { selected_date: selected_date },
				dataType: "json",
				success: function (data) {
					$('ul#room-list').html("");
					for(var counter = 0; counter < data.rooms_list.length; counter++) {
						$('ul#room-list').append('<li>Room '+data.rooms_list[counter].number+' - '+data.rooms_list[counter].name+' : <a href="#" class="room-info-link">'+data.rooms_list[counter].last_name+', '+data.rooms_list[counter].first_name+'</a></li>')
					};	
				},
				error: function() {
					console.log("fail: "+ selected_date );
				}
			});
			return false;
		});
	});

	$(document).on('click', '.room-info-link', function(){
		$('div#room-info').show();
		var names = $(this).text().split(',');
		var first_name = names[1].trim();
		var last_name = names[0].trim();
		console.log(first_name);
		console.log(last_name);
		$.ajax({
			type: "POST",
			url: "index.php?/areservations/roominfo",
			data: { selected_date : selected_date, 
					first_name : first_name,
					last_name : last_name
			},
			dataType: "json",
			success: function(data){
				console.log(data);
				$('#room-info').html("<h3>Room Info</h3>");
				var info = "<p>Date: " + data.rooms_info[0].date + "</p>" +
						   "<p>Guest: " + data.rooms_info[0].first_name + " " + data.rooms_info[0].last_name + "</p>" + 
						   "<p>Contact (email): " + data.rooms_info[0].email + "</p>" + 
						   "<p>Room: " + data.rooms_info[0].number + " - " +data.rooms_info[0].name + "</p>" + 
						   "<p>Rate: " + data.rooms_info[0].rate + "</p>";

				$('#room-info').append(info);
			},
			error: function() {
				console.log("fail");
			}
		});
		return false;
	})
</script>