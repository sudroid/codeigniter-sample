<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center bottom-space">
			<h1>Thank you!</h1>
			<p><?= anchor('index.php?/reservations/printCtlr','controller source') ?> |
			<?= anchor('index.php?/reservations/printView/success','view source') ?> | <?= anchor('index.php?/reservations/printModel','view model') ?></p>
			<div class="all-60 push-center ">
				<?= $success_message ?>
				<a href="index.php?/reservations/bookingPdf">View & Download PDF</a>
 			</div>
 		</div>
 	</div>
 </div>