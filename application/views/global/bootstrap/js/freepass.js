/*
 * FP
 *
 * Object prototype
 */
 	FP.prototype = {
 		init: function(){
 			this.Store.init();
 		},

 		Store: {
 			init: function(){
	 			this.engine = window.localStorage;
	 			this.prefix = "FPStore.";
	 			
	 			return this;
	 		},

	 		changeEngine: function(new_engine){
				if(typeof new_engine === "object"){
					this.engine = new_engine;
				}

				return this.engine;
	 		},

	 		get: function(key){
	 			this.engine.getItem(this.prefix + key);

	 			return this;
	 		},

	 		set: function(key, value){
	 			this.engine.setItem(this.prefix + key, JSON.stringify(value));

	 			return this;
	 		},

	 		delete: function(key){
	 			this.engine.removeItem(this.prefix + key);

	 			return this;
	 		},
	 	},

	 	HTML: {
	 		init: function(){
	 			return this;
	 		},

	 		//TODO: make more generic
	 		ajaxRow: function(raw, domain){
	 			var _el = document.createElement("tr"),
	 				_col1 = document.createElement("td"),
	 				_col2 = document.createElement("td"),
	 				_col3 = document.createElement("td"),
	 				_col4 = document.createElement("td"),
	 				_statusEl = document.createElement("span"),
	 				_domainEl = document.createElement("a"),
	 				_actionEl = document.createElement("div"),
	 				_action_showHeadersEl = document.createElement("a"),
	 				_action_iconEl = document.createElement("span");

	 			_actionEl.className = "btn-group actions";
	 			_action_showHeadersEl.className = "btn btn-primary btn-xs show-headers";
	 			_action_iconEl.className = "glyphicon glyphicon-info-sign";

	 			_action_showHeadersEl.appendChild(_action_iconEl);
	 			_actionEl.appendChild(_action_showHeadersEl);

	 			_domainEl.href = domain;
	 			_domainEl.innerText = domain;
	 			_domainEl.target = "_blank";
	 			_domainEl.classList.add("domain");

	 			_statusEl.classList.add("label");
	 			_statusEl.innerText = "Good";

	 			switch(raw[domain].status){
	 				case "success": 
	 					_statusEl.classList.add("label-success");
	 				break;

	 				case "warning": 
	 					_statusEl.classList.add("label-warning");
	 					_statusEl.innerText = "Warning";
	 				break;

	 				case "error": 
	 					_statusEl.classList.add("label-danger");
	 					_statusEl.innerText = "Bad";
	 				break;

	 				case "authblocked": 
	 					_statusEl.classList.add("label-info");
	 					_statusEl.innerText = "Protected";
	 				break;
	 			}

	 			if(raw[domain].headers){
	 				_domainEl.setAttribute("data-headers", JSON.stringify(raw[domain].headers));
	 			}

	 			_col1.innerText = "";
	 			//_col2.innerText = domain;
	 			_col2.appendChild(_domainEl);
	 			_col2.appendChild(_actionEl);
	 			_col3.appendChild(_statusEl);
	 			_col3.align = "right";
	 			_col4.innerText = raw[domain].message;

	 			_el.appendChild(_col1);
	 			_el.appendChild(_col2);
	 			_el.appendChild(_col3);
	 			_el.appendChild(_col4);

	 			return _el;
	 		},

	 		p: function(data){
	 			var _el = document.createElement("p");

	 			if(data.innerText){
	 				_el.innerText = data.innerText;
	 			}

	 			return _el;
	 		},
	 	}
 	};

	var FPInstance = new FP();