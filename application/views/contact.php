<div id="content">
	<div class="ink-grid">
		<div class="column-group push-center">
			<h1>Contact</h1>
			<div class="all-50">
				<h4>Contact us by email and send us your comments!</h4>
				<h6>All fields must be filled in.</h6>
				<div class="all-90">
					<span style="color:red"><?= validation_errors(); ?></span>
					<?= form_open('index.php?/contact', array('class' => 'ink-form')); ?>
					<form >
						<div class="column-group gutters">
							<div class="control-group all-100">
								<label for="name">Name</label>
								<div class="control">
									<input type="text" id="name" name="name">
								</div>
							</div>
							<div class="control-group all-100">
								<label for="address">Address</label>
								<div class="control">
									<input type="text" id="address" name="address">
								</div>
							</div>
							<div class="control-group all-100">
								<label for="postalcode">Postal Code</label>
								<div class="control">
									<input type="text" id="postalcode" name="postalcode">
								</div>
							</div>
							<div class="control-group all-100">
								<label for="phone">Phone</label>
								<div class="control">
									<input type="text" id="phone" name="phone">
								</div>
							</div>
							<div class="control-group all-100">
								<label for="email">Email</label>
								<div class="control">
									<input type="text" id="email" name="email">
								</div>
							</div>
							<div class="control-group all-100">
								<label for="comments">Comments</label>
								<div class="control">
									<textarea name="comments" rows="9" cols="4"></textarea>
								</div>
							</div>
							<div class="control-group all-100">
								<div class="control">
									<input type="submit" value="Submit" class="ink-button"/>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="all-50">
				<div class="all-90">
					<h4>Contact Information</h4>
					<h6>Salt Kettle Guest House</h6>
					<address>
						10 Salt Kettle Road<br>
						Paget Parish, Bermuda<br>
						Tel: 555-2345 <br>
						Fax: 555-7653<br>
						Email: reservation@skh.com<br>
 					</address>
				</div>
				<div class="all-90">
					<h4>Map to Salt Kettle Guest House</h4>
					<div id="map-canvas"></div>
					<p><?= anchor('index.php?/contact/printCtlr','controller source') ?> |
		<?= anchor('index.php?/contact/printView','view source') ?></p>
				</div>
			</div>
		</div>	
	</div>
</div>
<script>
	function initialize() {
			var myLatLang =  new google.maps.LatLng(32.283808, -64.792701);
			var mapOptions = {
				zoom: 15,
				center: myLatLang
			};
			var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			
			var infowindow = new google.maps.InfoWindow({
			  content: '<div id="content">'+
					  '<div id="siteNotice">'+
					  '</div>'+
					  '<h1 id="firstHeading" class="firstHeading">Salt Kettle House</h1>'+
					  '<div id="bodyContent">'+
					  '<p>The best bed and breakfast around! A three minute walk from ' + 
					  'Salt Kettle Ferry and contains its own harbour.</p>'
		    });
		    var image = 'assets/img/home_icon.png';
			var marker = new google.maps.Marker({
			  position: myLatLang,
			  map: map,
			  title: 'Hello!', 
			  icon: image
			});
		    
		    google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});
		}
	google.maps.event.addDomListener(window, 'load', initialize);
	$(function() {

		//Hide all room descriptions on load
		$('.room_description').hide();
		//Toggle room description
		$('.room_title').click( function() {
			$(this).next('.room_description').slideToggle("slow");
		})
	});
</script>