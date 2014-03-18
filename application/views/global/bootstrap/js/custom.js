window.addEventListener("DOMContentLoaded", function(evt){
	//show/hide password functionality
	jQuery("a.view").each(function(){
		jQuery(this).click(function(evt){
			evt.preventDefault();

			var el = jQuery(this).parent().parent().find(".password")[0];

			el.removeAttribute("disabled");

			if(!el.classList.contains("active")){
				el.value = atob(el.value);
				el.classList.add("active");
				el.select();
			}else {
				el.setAttribute("disabled", "disabled");
				el.value = btoa(el.value);
				el.classList.remove("active");
			}
		});
	});

	//build the column name list and append it after the filter field
	var opts_raw = document.querySelectorAll("table.output th");

	if(opts_raw.length > 0){
		jQuery("ul.filter-cols").empty();
	}

	for(var j = 0; j < opts_raw.length; j++){
		var _el = document.createElement("li"),
			_a = document.createElement("a");
			
			if(opts_raw[j].id){
				_a.href = "#";
				_a.innerText = opts_raw[j].id;
				_el.appendChild(_a);
			}

		jQuery(_el).appendTo("ul.filter-cols");
		jQuery(_el).appendTo("ul.default-filter");
	}

	jQuery("ul.filter-cols li a").each(function(){
		jQuery(this).click(function(evt){
			evt.preventDefault();

			var filterColName = jQuery(this).text();

			jQuery("th").removeClass("success");
			jQuery(this).parents(".input-group-btn").find(".filter-var").text(filterColName);

			jQuery("th#"+ filterColName).each(function(){
				jQuery(this).addClass("success");
			});

			jQuery("input.search").focus();
		});
	});

	//search functionality
	jQuery(".search").keyup(function(evt){
		var searchVal = this.value,
			searchColumn = document.querySelector("button span.filter-var").innerText.toLowerCase(),
			searchObj = jQuery("body"); //default to body so it is a valid DOM target

		//multi-column search
		switch(searchColumn){
			case "uri":
				searchObj = jQuery("table.output tr td:nth-child(2)");
			break;

			case "username":
				searchObj = jQuery("table.output tr td:nth-child(3)");
			break;

			case "report":
				searchObj = jQuery("table.output tr td:nth-child(3) span");
			break;

			case "domain":
				searchObj = jQuery("table.output tr td:nth-child(5)");
			break;

			case "host":
				searchObj = jQuery("table.output tr td:nth-child(6)");
			break;

			case "valid":
			case "status":
				searchObj = jQuery("table.output tr td:nth-child(4) span");
			break;

			case "client":
			default:
				searchObj = jQuery("a.name");
		}

		if(evt.which === 8 || evt.which === 46){
			jQuery("tr.nomatch").removeClass("nomatch");
		}

		searchObj.each(function(){
			var regex = new RegExp(searchVal, "gi"),
				test = this.innerText;

			if(test.match(regex)){
				jQuery(this).parents("tr").addClass("match");
			}else {
				jQuery(this).parents("tr").addClass("nomatch");
			}
		});

		//experiment: dynamic number of search results 
		var _nomatch = jQuery("tr.nomatch").length,
			_all = jQuery("tr").length - 1,
			num_rows = _all - _nomatch;

		jQuery("th")[0].innerText = num_rows;
	});
	
	if(jQuery("th")[0]){
		//setup a default for number of row counter
		jQuery("th")[0].innerText = (jQuery("tr").length - 1);
	}

	//delete button functionality
	jQuery("button.delete").click(function(evt){
		evt.preventDefault();

		var action = jQuery(this).parents("form").attr("action");

		if(confirm("Are you sure you want to delete this item?")){
			jQuery(this).parents("form").attr("action", action.replace("modify", "delete"));
			jQuery(this).parents("form").submit();
		}
	});

	//add to clipboard functionality
	jQuery("a.clipboard").click(function(){	
		alert("Feature does not exist yet.");
		return false;

		/*var ref = jQuery(this),
			text = ref.parents("td").find("span.password").text(),
			clip = new ZeroClipboard(ref, {
				moviePath: "/freepass/application/views/global/zeroclipboard/ZeroClipboard.swf"
			});

		clip.on("load", function(client){
		  client.on("complete", function(client, args){
			jQuery(".copied-password").text(atob(text));
		  });
		});

			var _pwd = atob(this.parentElement.previousSibling.previousSibling.innerText);

			jQuery(".copied-password").text(_pwd).select();
		
			//FPInstance.Store.set("clipboard", _pwd);
			// /copy(_pwd);*/

	});

	//dynamic jquery version indicator on help page
	jQuery("span.jq-version").text(jQuery.fn.jquery);

	//disable filter field if there are no elements 
	if(jQuery("td").length < 1){
		jQuery(".search").attr("disabled", true);
	}

	//switch client name field type toggle
	jQuery(".edit-client-name").click(function(evt){
		evt.preventDefault();

		if(jQuery(this).parents(".form-group").hasClass("text")){
			jQuery(this).parents(".form-group").removeClass("text");
			jQuery(this).parents(".form-group").addClass("select");
			jQuery(this).parents(".form-group").find("input").hide();
			jQuery(this).parents(".form-group").find("input")[0].removeAttribute("name");
			jQuery(this).parents(".form-group").find("select")[0].setAttribute("name", "name");
			jQuery(this).parents(".form-group").find("select").show();
		}else {
			jQuery(this).parents(".form-group").removeClass("select");
			jQuery(this).parents(".form-group").addClass("text");
			jQuery(this).parents(".form-group").find("input").show();
			jQuery(this).parents(".form-group").find("input")[0].setAttribute("name", "name");
			jQuery(this).parents(".form-group").find("select")[0].removeAttribute("name");
			jQuery(this).parents(".form-group").find("select").hide();
		}
	});

	//TH click actions
	jQuery("th#username, th#client, th#domain, th#host, th#user, th#valid, th#email, th#description, th#status, th#uri, th#report").each(function(){
		jQuery(this).click(function(evt){
			evt.preventDefault();
			jQuery("th.success").removeClass("success");
			jQuery(".filter-var").text(this.id);
			jQuery("input.search").focus();

			jQuery(this).addClass("success");
		});
	})

	//initialize tooltips for user instructions
	jQuery("[data-toggle='tooltip']").tooltip();

	//generate random password - integration with Passwordr
	jQuery("a.generatepw").click(function(evt){
		evt.preventDefault();

		var host = "http://labs.ryanpriebe.com/passwordr/",
			url = host +'api/?l=20&s=freeadpass' + Math.random() + '&k=SAMPLE_KEY',
			ref = jQuery(this);

		jQuery.getJSON(url, function(resp){
			ref.parents(".form-wrapper").find("input[type='password']").each(function(){
				this.value = resp.StringResult;
			});
		}).error(function(){
			jQuery(".generatepw-error").modal();
		});
	});

	//reset password button functionality
	jQuery(".reset-pw").click(function(evt){
		evt.preventDefault();

		var host = "http://labs.ryanpriebe.com/passwordr/",
			url = host +'api/?l=20&s=freeadpass' + Math.random() + '&k=SAMPLE_KEY',
			ref = jQuery(this);

		jQuery.getJSON(url, function(resp){
			console.log(resp);
			ref.text("Password Reset");
			ref.addClass("btn-success");
		}).error(function(){
			ref.text("Error");
			ref.addClass("btn-danger");
		});
	});


	//reset secret question action
	jQuery(".reset-secret-question").click(function(evt){
		evt.preventDefault();

		var _id = (this.parentElement.parentElement.dataset.id ? this.parentElement.parentElement.dataset.id : 0),
			url = FPInstance.ajax_url +'index.php/user/reset_secret_question/'+ _id,
			ref = jQuery(this);

		if(ref.parent().next()[0].dataset.col == "valid"){
			jQuery.getJSON(url, function(resp){
				ref.text("Secret Question Reset");
				ref.addClass("btn-success");

				var validated_col = ref.parent().next();
					validated_col[0].dataset.col = "invalid";
					validated_col.find(".label").removeClass("label-success").addClass("label-warning").text("Warning");
			}).error(function(resp){
				console.error(resp.responseText);
				ref.text("Error");
				ref.addClass("btn-danger");
			});
		}else {
			return alert("User has not yet chosen an answer to their secret question");
		}
	});

	jQuery(".get-status").click(function(evt){
		evt.preventDefault();

		//modify action button's text to show that something is happening while the user waits
		var ref = this;

		ref.innerText = "Loading...";
		ref.classList.remove("btn-primary");
		ref.classList.add("btn-default");
		ref.setAttribute("disabled", "disabled");

		//initiate the AJAX request to the /status/get endpoint
		var url = window.location.href + "/get";

		jQuery.getJSON(url, function(data){
			//hide this button, enable the UI elements which are hidden by default
			ref.parentElement.querySelector("h2").classList.add("hidden");
			ref.parentElement.querySelector(".alert-warning").classList.add("hidden");
			ref.parentElement.querySelector("p").classList.add("hidden");
			ref.classList.add("hidden");
			ref.nextSibling.nextSibling.classList.remove("hidden");

			var table = document.querySelector(".panel-free table.output tbody");

			for(var domain in data){
				table.appendChild(FPInstance.HTML.ajaxRow(data, domain));
			}

			document.querySelector(".panel-free .input-group").classList.remove("hidden");
			document.querySelector(".panel-free table.output").classList.remove("hidden");
			document.querySelector("tr.hidden").parentElement.removeChild(document.querySelector("tr.hidden"));

			showHeadersAction();
		}).error(function(resp){
			ref.innerText = "Error";
			ref.classList.add("btn-danger");
			ref.classList.remove("btn-default");
			
			var infobox = ref.previousSibling.previousSibling;
				infobox.innerText = "There was an issue retreiving the list of domains from the database.";
				infobox.classList.remove("alert-info");
				infobox.classList.add("alert-danger");
		});
	});

	//reload status page
	jQuery(".regenerate-status").click(function(evt){
		evt.preventDefault();

		//modify action button's text to show that something is happening while the user waits
		var ref = this;

		ref.innerText = "Loading...";
		ref.classList.remove("btn-primary");
		ref.classList.add("btn-default");
		ref.setAttribute("disabled", "disabled");

		//initiate the AJAX request to the /status/get endpoint
		var url = window.location.href + "/get";

		jQuery.getJSON(url, function(data){
			var table = document.querySelector(".panel-free table.output tbody");

			ref.removeAttribute("disabled");
			ref.innerText = "Reload Data";
			ref.classList.add("btn-primary");
			ref.classList.remove("btn-default");

			//remove all existing table rows
			jQuery(".panel-free table.output tr:gt(0)").remove();

			for(var domain in data){
				table.appendChild(FPInstance.HTML.ajaxRow(data, domain));
			}

			showHeadersAction();
		}).error(function(resp){

		});
	});

	//star/unstar category
	jQuery(".star-status").click(function(evt){
		evt.preventDefault();

		var ref = this;

		jQuery.getJSON(ref.firstChild.href, function(data){
			if(data.type == "success"){
				if(ref.firstChild.classList.contains("glyphicon-star-empty")){
					ref.firstChild.classList.remove("glyphicon-star-empty");
					ref.firstChild.classList.add("glyphicon-star");
				}else {
					ref.firstChild.classList.remove("glyphicon-star");
					ref.firstChild.classList.add("glyphicon-star-empty");
				}

				ref.firstChild.href.replace("star", "unstar");

				//this defeats the purpose of an AJAX request entirely but the
				//page needs to be reloaded for items to show up in the list of
				//starred categories drop down
				window.location.reload();
			}
		});
	});

	//initialize colour picker
	jQuery("#colour").colorpicker();

	//give items within categories their chosen colour
	jQuery("tr.has-colour").each(function(){
		var colour = (this.dataset.colour || "#ffffff"),
			textColor = ColorLuminance(colour, 0.6);
		
		this.firstElementChild.style.borderLeft = "3px solid "+ colour; 
		this.lastElementChild.style.borderRight = "3px solid "+ colour; 
	});
});

function showHeadersAction(){
	//show headers click action (status page)
	jQuery(".show-headers").click(function(evt){
		evt.preventDefault();
		
		jQuery("#show-headers-modal .modal-body").empty();

		var modal = jQuery("#show-headers-modal").modal(),
			data = JSON.parse(this.parentElement.parentElement.querySelector(".domain").getAttribute("data-headers"));
		
		for(var i = 0; i < data.length; i++){
			modal[0].querySelector(".modal-body").appendChild(FPInstance.HTML.p({innerText: (i+1) +". "+ data[i]}));
		}

		modal[0].querySelector(".modal-title em").innerText = this.parentElement.parentElement.querySelector(".domain").getAttribute("href");
	});
}

function ColorLuminance(hex, lum) {

	// validate hex string
	hex = String(hex).replace(/[^0-9a-f]/gi, '');
	if (hex.length < 6) {
		hex = hex[0]+hex[0]+hex[1]+hex[1]+hex[2]+hex[2];
	}
	lum = lum || 0;

	// convert to decimal and change luminosity
	var rgb = "#", c, i;
	for (i = 0; i < 3; i++) {
		c = parseInt(hex.substr(i*2,2), 16);
		c = Math.round(Math.min(Math.max(0, c + (c * lum)), 255)).toString(16);
		rgb += ("00"+c).substr(c.length);
	}

	return rgb;
}