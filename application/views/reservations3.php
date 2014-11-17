<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center bottom-space">
			<h1>Reservations - Confirmation</h1>
			<p><?= anchor('index.php?/reservations/printCtlr','controller source') ?> |
			<?= anchor('index.php?/reservations/printView/3','view source') ?> | <?= anchor('index.php?/reservations/printModel','view model') ?></p>
			<p>	<?= anchor('index.php?/reservations/selectDates/jumpTo','Select Dates') ?> | 
				<?= anchor('index.php?/reservations/roomsRates/jumpTo','Rooms & Rates') ?> | 
				Payment and Guest Info |
				Confirmation |
			</p>
			<div class="all-60 push-center ">

				<?= ( isset($error_msg) ) ? $error_msg : "" ?>
				<h3>Your present choices are:</h3>
				<div class='ink-alert basic info'>
					<p><strong>Arrival Date:</strong> <span id="arrivalDate"><?= $arrivalDate ?></span></p>
					<p><strong>Departure Date:</strong> <span id="departureDate"><?= $departureDate ?></span></p>
					<p><strong>Rooms:</strong> 1 </p> <p><strong>Nights:</strong> <span id="duration"><?= $duration ?></p>
					<p><strong>Selected Room:</strong> <?= 'Room '.$selected_room[0]->number.' - '.$selected_room[0]->name ?></p>
					<p><strong>Total Charge:</strong> <?= '$'.$selected_room[0]->rate ?></p>
				</div>
 			</div>
 			<div class="all-60 push-center ">
 				<?= validation_errors(); ?>
 				<?= form_open('index.php?/reservations/finalPayment/continue', 'class="ink-form"'); ?> 
 				<div class="all-50">
 					<div class="all-90">
	 					<h4>Personal Information</h4>
	 					<div class="control-group">
	 						<label for="first_name">First Name</label>
				 			<div class="control">
								<?= form_input('first_name', set_value('first_name')) ?>
							</div>
	 					</div>
	 					<div class="control-group">
	 						<label for="last_name">Last Name</label>
				 			<div class="control">
								<?= form_input('last_name', set_value('last_name')) ?>
							</div>
	 					</div>
	 					<div class="control-group">
	 						<label for="email">Email</label>
				 			<div class="control">
								<?= form_input('email', set_value('email')) ?>
							</div>
	 					</div>
 					</div>
 				</div>
 				<div class="all-50">
 					<div class="all-90">
 						<h4>Payment Type</h4>
	 					<div class="control-group">
	 						<label for="card_name">Cardholder Name</label>
				 			<div class="control">
								<?= form_input('card_name', set_value('card_name')) ?>
							</div>
	 					</div>
	 					<div class="control-group">
	 						<label for="card_type">Card Type:</label>
				 			<div class="control">
								<?= form_input('card_type', set_value('card_type')) ?>
							</div>
	 					</div>
	 					<div class="control-group">
	 						<label for="card_number">Card Number:</label>
				 			<div class="control">
								<?= form_input('card_number', set_value('card_number')) ?>
							</div>
	 					</div>
	 					<div class="control-group">
	 						<label for="expiration_date">Expiration Date:</label>
				 			<div class="control">
								<?= form_dropdown('expiry_month', $month_options, set_value('expiry_month'), 'style="width: 50px"'); ?> / <?= form_dropdown('expiry_year', $year_options, set_value('expiry_year'),'style="width: 70px"'); ?>
							</div>
	 					</div>
	 					<div class="control-group">
	 						<label for="sec_code">Security Code:</label>
				 			<div class="control">
								<?= form_input('sec_code', set_value('sec_code')) ?>
							</div>
	 					</div>
 					</div>
 				</div>
 				<div class="all-95">
	 				<?= form_submit('submitForm', 'Continue', 'class="ink-button push-right"'); ?> 
					<?= form_close(); ?> 
				</div>
			</div>
		</div>
	</div>
</div>