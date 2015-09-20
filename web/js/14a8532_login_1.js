	
	$("#loginDialog").dialog({
				
			 autoOpen: false,
			 draggable: false,
			 resizable: false,
			 width: 500,
			 
			 show: {
				 effect: "clip",
				 duration: 500,
			 },
			 
			 hide: {
				 effect: "clip",
				 duration: 500
			 }
		 });
		 
		 $("#loginButton").click(function() {
		 	$('#loginDialog').dialog('open');
		 }):