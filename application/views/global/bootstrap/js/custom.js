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

	//keep username highlighted when they clicked in some lists
	//also registration list filtering
	jQuery(".user-list a.list-group-item").click(function(){
		var _others = document.querySelectorAll(".user-list a.list-group-item"),
			_reslist = document.querySelectorAll(".list-devices tbody tr");

		for(var i = 0; i < _others.length; i++){
			_others[i].classList.remove("active");
		}

		for(var i = 0; i < _reslist.length; i++){
			_reslist[i].classList.add("hidden");

			if(_reslist[i].dataset.location == this.dataset.user){
				_reslist[i].classList.remove("hidden");
			}
		}

		jQuery(".reset-filters").removeClass("hidden");
		this.classList.add("active");
	});
});

//functions
function resetFilterButtons(){
	var _els = [".filters button", "a.list-group-item"],
		_filters = document.querySelectorAll(_els.join(","));

	for(var i = 0; i < _filters.length; i++){
		_filters[i].classList.remove("active");
	}

	return true;
}