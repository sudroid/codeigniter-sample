<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center bottom-space">
			<h1>Reservations - Payment</h1>
			<p><?= anchor('index.php?/reservations/printCtlr','controller source') ?> |
			<?= anchor('index.php?/reservations/printView/3','view source') ?> | <?= anchor('index.php?/reservations/printModel','view model') ?></p>
			<div class="all-60 push-center ">
				<h3>Your present choices are:</h3>
				<div class='ink-alert basic info'>
					<p><strong>Arrival Date:</strong> <span id="arrivalDate"><?= $arrivalDate ?></span></p>
					<p><strong>Departure Date:</strong> <span id="departureDate"><?= $departureDate ?></span></p>
					<p><strong>Rooms:</strong> 1 </p> <p><strong>Nights:</strong> <span id="duration"><?= $duration ?></p>
					<p><strong>Selected Room:</strong> <?= 'Room '.$selected_room[0]->number.' - '.$selected_room[0]->name ?></p>
					<p><strong>Total Charge:</strong> <?= '$'.$selected_room[0]->rate ?></p>
					<p><strong>Name:</strong> <?= $name ?></p>
					<p><strong>Email:</strong> <?= $email ?></p>
					<p><strong>Cardholder Name:</strong> <?= $card_name  ?></p>
					<p><strong>Cardholder Type:</strong> <?= $card_type  ?></p>
					<p><strong>Card Number:</strong> <?= $card_number ?></p>
					<p><strong>Expiry Date:</strong> <?= $expiry_month.'/'.$expiry_year ?></p>
					<p><strong>Security Code:</strong> <?= $sec_code ?></p>
				</div>
				<?= form_open('index.php?/reservations/thanks', 'class="ink-form"'); ?> 
				<?= form_submit('submitForm', 'Continue', 'class="ink-button push-right"'); ?> 
				<?= form_close(); ?> 
 			</div>
 		</div>
 	</div>
 </div>