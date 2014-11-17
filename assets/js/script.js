$(function() {
	$('#availCalendar').datepicker({
	    inline: true,
	    firstDay: 1,
	    showOtherMonths: true
	});
	$( "#arrivalDate" ).datepicker({ 
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		onClose: function( selectedDate ) {
			$( "#departureDate" ).datepicker( "option", "minDate", selectedDate );
		},
		minDate: -10, 
		maxDate: "+1M +10D" 

	});
	$( "#departureDate" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		numberOfMonths: 2,
		onClose: function( selectedDate ) {
			$( "#arrivalDate" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	//Hide all room descriptions on load
	$('.room_description').hide();
	//Toggle room description
	$('.room_title').click( function() {
		$(this).next('.room_description').slideToggle("slow");
	})
});