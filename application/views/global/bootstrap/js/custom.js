window.addEventListener("DOMContentLoaded", function(evt){
	//progress bar filtering
	jQuery(".filters button").click(function(evt){
		//return false; //testing custom sort functionality
		evt.preventDefault();

		var _class = this.classList.item(2),
			_devices = document.querySelectorAll(".list-devices tbody tr");			

		resetFilterButtons();

		this.classList.add("active");
			
		for(var i = 0; i < _devices.length; i++){
			_devices[i].classList.remove("hidden");
			
			if(! _devices[i].querySelector("span.status-circle").classList.contains("alert-"+ _class)){
				_devices[i].classList.add("hidden");

				jQuery(".reset-filters").removeClass("hidden");
			}
		}
	});

	//TESTING
	jQuery(".filters button").click(function(evt){
		return false;
		var _class = this.classList.item(2),
			_devices = document.querySelectorAll(".list-devices tbody tr");

		return ProductInstance.Array.sort(_class, _devices);
	});

	//devices list reset button
	jQuery(".reset-filters").click(function(evt){
		evt.preventDefault();

		jQuery("tr").removeClass("hidden");
		jQuery(this).addClass("hidden");
		resetFilterButtons();
	});
});

//functions
function resetFilterButtons(){
	var _filters = document.querySelectorAll(".filters button");

	for(var i = 0; i < _filters.length; i++){
		_filters[i].classList.remove("active");
	}

	return true;
}