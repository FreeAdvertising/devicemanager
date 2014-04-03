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
	jQuery(".user-list a.list-group-item").click(function(evt){
		evt.preventDefault();

		ProductInstance.Helpers.clearSidebarFilters();

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

		if(this.dataset.user)
			jQuery(".user-filter-header .reset-filters").removeClass("hidden");

		this.classList.add("active");
	});

	//filter by status/type (available, checked out, etc)
	jQuery(".type-list a.list-group-item").click(function(evt){
		evt.preventDefault();

		ProductInstance.Helpers.clearSidebarFilters();

		var _others = document.querySelectorAll(".type-list a.list-group-item"),
			_reslist = document.querySelectorAll(".list-devices tbody tr");

		for(var i = 0; i < _others.length; i++){
			_others[i].classList.remove("active");
		}

		for(var i = 0; i < _reslist.length; i++){
			_reslist[i].classList.add("hidden");

			if(_reslist[i].dataset.status == this.dataset.type){
				_reslist[i].classList.remove("hidden");

			}
		}

		if(this.dataset.type)
			jQuery(".type-filter-header .reset-filters").removeClass("hidden");
		
		this.classList.add("active");
	});

	//history page tab functionality
	jQuery(".faux-tabs li a").click(function(evt){
		evt.preventDefault();

		//activate new tab, deactivate old one
		jQuery(".faux-tabs li").removeClass("active");
		this.parentElement.classList.add("active");

		//hide old content, show new stuff
		jQuery(".tab_content").hide();
		jQuery(".tab_"+ this.id).show();
	});

	if(hash = window.location.hash){
		jQuery(".faux-tabs li").removeClass("active");
		jQuery(hash).parent().addClass("active");

		jQuery(".tab_content").hide();
		jQuery(hash.replace("#", ".tab_")).show();
	}
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