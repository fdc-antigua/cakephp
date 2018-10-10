$(document).ready(function(){
	jQuery('body').on('focus', '[class*=date-to]', function(){
		
		jQuery(this).datepicker({

			dateFormat		: 'd M',

			numberOfMonths : 2,

			minDate	: 1	

			//startDate	: '+3d'		

		});
	});
});