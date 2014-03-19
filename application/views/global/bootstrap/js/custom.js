window.addEventListener("DOMContentLoaded", function(evt){
	//progress bar filtering
	jQuery(".progress-bar a").click(function(evt){
		evt.preventDefault();

		var _class = this.parentElement.classList.item(2),
			_devices = document.querySelectorAll(".list-devices tbody tr");
		
		for(var i = 0; i < _devices.length; i++){
			_devices[i].classList.remove("hidden");
			//console.log(_devices[i].querySelector("span.status-circle").classList.contains("alert-"+ _class));
			if(! _devices[i].querySelector("span.status-circle").classList.contains("alert-"+ _class)){
				_devices[i].classList.add("hidden");

				jQuery(".reset-filters").removeClass("hidden");
			}
		}
	});

	//devices list reset button
	jQuery(".reset-filters").click(function(evt){
		evt.preventDefault();

		jQuery("tr").removeClass("hidden");
		jQuery(this).addClass("hidden");
	});
});

//functions