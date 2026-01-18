$(document).ready(function(){

	/* Set Canvas Width & Height */

	function setCanvasWidth(){
		// Statistics - Line Graph
		var salesCustomerChartWidth = $(".statistic .dashboard-content #report").width();

		$("#sales-customer-graph").css("width", salesCustomerChartWidth + "px");

		// Overview - Pie Chart
		var salesValueChartWidth = $(".overview .sales-value-graph").width();

		var salesValueChartHeight = $(".overview .dashboard-overview-top").height();

		if(salesValueChartWidth > 0){
			if(salesValueChartWidth >= salesValueChartHeight){
				// set canvas height and width of canvas to salesValueChartHeight
				$("#sales-value-graph").css("height", salesValueChartHeight - 10 + "px").css("width", salesValueChartHeight - 10 + "px");
			}else{
				// set canvas height and width of canvas to salesValueChartWidth
				$("#sales-value-graph").css("height", salesValueChartWidth - 10 + "px").css("width", salesValueChartWidth - 10 + "px");
			}
		}
	}

	var waitForFinalEvent = (function () {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) {
				uniqueId = "Don't call this twice without a uniqueId";
			}
			if (timers[uniqueId]) {
				clearTimeout (timers[uniqueId]);
			}
			timers[uniqueId] = setTimeout(callback, ms);
		};
	})();

	function generateUniqueString(){
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		for( var i=0; i < 5; i++ )
			text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}


	/* Set Canvas Width & Height - Continued */


	var graphExists = $("#sales-customer-graph").height();

	if(graphExists > 0){
		setCanvasWidth();
	}


	/* Plot Sales/Customer Graph */

	// Get Graph Data
	(function(fn){
		if (!fn.map) fn.map=function(f){var r=[];for(var i=0;i<this.length;i++)r.push(f(this[i]));return r}
		if (!fn.filter) fn.filter=function(f){var r=[];for(var i=0;i<this.length;i++)if(f(this[i]))r.push(this[i]);return r}
	})(Array.prototype);


	function getSalesChart(range) {

		// Get the token Var from URL
		var split = location.search.replace('?','').split('&').map(function(val){
			return val.split('=');
		});

		$.ajax({
			type: 'GET',
			url: 'index.php?route=common/home/chart&token=' + split[1][1] + '&range=' + range,
			dataType: 'json',
			async: false,
			success: function(json) {

				var option = {	
					series: {
						lines: { 
							show: true,
							fill: true,
							lineWidth: 1
						},
						points: {
							show: true
						}	
					},
					shadowSize: 0,
					grid: {
						backgroundColor: '#FFFFFF',
						borderColor: '#F2F2F2',
						hoverable: true
					},
					legend: {
						show: false
					},
					xaxis: {
						ticks: json.xaxis
					},
					tooltip: true,
					tooltipOpts: {
						content: "'%s': <b>%y</b>",
						shifts: {
							x: -60,
							y: 25
						}
					}
				}

				option.colors = ['#939BCB','#82D14D'];

				$.plot($('#sales-customer-graph'), [json.order, json.customer], option);
			}
		});
	}

	
	if(graphExists > 0){

		getSalesChart($('#range').val());
	}


	// Get New Data Range

	$("#range").change(function(){

		var graphRange = $('#range').val();

		getSalesChart(graphRange);

	});


	/* Plot Sales/Amount/Value Graph (Pie Chart) */


	function getSalesValueChart(){

		var salesTotal = parseFloat($("#total_sale_raw").val());

		var salesTotal = parseFloat($("#total_sale_raw").val());
		var salesTotalText = $("#total_sale_raw").data("text_label");
		var salesTotalCurrency = $("#total_sale_raw").data("currency_value");
		
		var salesThisYear = parseFloat($("#total_sale_year_raw").val());
		var salesThisYearText = $("#total_sale_year_raw").data("text_label");
		var salesThisYearCurrency = $("#total_sale_year_raw").data("currency_value");

		var salesPreviousYears = parseFloat($("#total_sales_previous_years_raw").val());
		var salesPreviousYearsText = $("#total_sales_previous_years_raw").data("text_label");
		var salesPreviousYearsCurrency = $("#total_sales_previous_years_raw").data("currency_value");

		$("#title").text("Default pie chart");
		$("#description").text("The default pie chart with no options set.");

		var placeholder = $("#sales-value-graph");

		var data = [
		{ label: salesTotalText + " <b>" + salesTotalCurrency + "</b>",  data: salesTotal, color: '#69D2E7'},
		{ label: salesThisYearText + " <b>" + salesThisYearCurrency + "</b>",  data: salesThisYear, color: '#008000'},
		{ label: salesPreviousYearsText + " <b>" + salesPreviousYearsCurrency + "</b>",  data: salesPreviousYears, color: '#FF0000'}
		];

		$.plot(placeholder, data, {
			series: {
				pie: { 
					show: true
				}
			},
			legend: {
				show: true,
				container: '#hiddenLegend'
			},
			grid: {
				hoverable: true,
				clickable: true
			},
			tooltip: true,
			tooltipOpts: {
				content: "%s",
				shifts: {
					x: -60,
					y: 25
				}
			}
		});
	}

	if(graphExists > 0){

		getSalesValueChart();
	}


	/* Horizontal Scrolling For Tables For Small Screens - Start */
	var boxWidth = $(".box").width();
	var tableListWidth = $("table.list").width();
	var formTableWidth = $("form#form").height();

	if(tableListWidth > boxWidth){
		if(formTableWidth > 0){
			$("form#form").css("overflow-x", "scroll").css("overflow-y", "hidden");
		}else{
			$("table.list").parent().css("overflow-x", "scroll").css("overflow-y", "hidden");
		}
	}else{
		if(formTableWidth > 0){
			$("form#form").css("overflow-x", "auto").css("overflow-y", "hidden");
		}else{
			$("table.list").parent().css("overflow-x", "auto").css("overflow-y", "hidden");
		}
	}
	/* Horizontal Scrolling For Tables For Small Screens - End */

	
	/* On Window Resize */
	var currentWindowWidth = $(window).width();

	$(window).resize(function () {
		waitForFinalEvent(function(){

			if($(this).width() != currentWindowWidth){

				currentWindowWidth = $(window).width();

				// Close Menu
				menuClose("73");

				// Resize Homepage Graph
				if(graphExists > 0){
					setCanvasWidth();
					getSalesChart($('#range').val());
					getSalesValueChart();
				}

				var boxWidth = $(".box").width();
				var tableListWidth = $("table.list").width();
				var formTableWidth = $("form#form").height();

				if(tableListWidth > boxWidth){
					if(formTableWidth > 0){
						$("form#form").css("overflow-x", "scroll").css("overflow-y", "hidden");
					}else{
						$("table.list").parent().css("overflow-x", "scroll").css("overflow-y", "hidden");
					}
				}else{
					if(formTableWidth > 0){
						$("form#form").css("overflow-x", "auto").css("overflow-y", "hidden");
					}else{
						$("table.list").parent().css("overflow-x", "auto").css("overflow-y", "hidden");
					}
				}

				// Close Menu On Mobile Device
				$("#left-column").removeAttr("style");
			}

		}, 500, generateUniqueString());
	});


	/* Main Nav Accordion */

	$(".mainnav").accordion({
		accordion:false,
		speed: 500,
		closedSign: '<img src="view/image/admin_theme/base5builder_impulsepro/dropdown-arrow.png">',
		openedSign: '<img src="view/image/admin_theme/base5builder_impulsepro/dropdown-arrow.png">'
	});


	/*  Main Nav - Close Other Open Menus. Augment to Accordion Script */


	function menuOpen(width, rightColumnWidth){

		$("#left-column").animate({"width": width + "px"},300);

		$("#content").css("width", rightColumnWidth + "px").animate({"margin-left": width + "px"},300);

		if($(window).width() <= 480){

			$(".right-header-content").css("width", rightColumnWidth + "px");
			$("ul.mainnav li").css("display", "block");
			$("ul.mainnav li#menu-control").css("padding-bottom", "45px");
		}else{
			//$("#content").css("width", rightColumnWidth + "px").animate({"margin-left": width + "px"},300);
		}

		$(".right-header-content").animate({"margin-left": width + "px"},300);

		$("ul.mainnav > li > a").css("font-size","14px");
		$("ul.mainnav li a > span").css("display","inline");

		$(".sidebar.copyright").css("display","block");

		$("ul.mainnav li#menu-control .menu-control-outer").addClass("opened");

		$('.logo_head_class').css("font-size", "34px");
		$('.logo_sub_class').css("font-size", "18px");

		$('.sidebar-logo').css("margin-left", "auto");
	}

	function menuClose(width){

		$("ul.mainnav li a.parent,ul.mainnav li a.top").parent().siblings().find("ul").slideUp();

		$("#left-column").animate({"width": width + "px"},300, function(){$(this).removeAttr('style');});

		if($(window).width() <= 480){

			$(".right-header-content").removeAttr("style");
			$("#content").animate({"margin-left": "0px"},300, function(){$(this).removeAttr('style');});
			$("ul.mainnav li#menu-control").removeAttr("style");

			$("ul.mainnav li#menu-control").removeAttr("style");
		}else{
			$("#content").animate({"margin-left": width + "px"},300, function(){$(this).removeAttr('style');});
		}
		
		$("ul.mainnav li").removeAttr("style");

		$(".right-header-content").animate({"margin-left": width + "px"},300, function(){$(this).removeAttr('style');});
		

		$("ul.mainnav > li > a").removeAttr("style");
		$("ul.mainnav li a > span").removeAttr("style");

		$(".sidebar.copyright").removeAttr("style");

		$("ul.mainnav li#menu-control .menu-control-outer").removeClass("opened");

		$('.logo_head_class').css("font-size", "10px");
		$('.logo_sub_class').css("font-size", "8px");

		$('.sidebar-logo').css("margin-left", "-39px");

	}

	$("ul.mainnav li a.parent,ul.mainnav li a.top").click(function(){

		// Get current with of right column
		var rightColumnWidth = $("#content").width();

		menuOpen("223", rightColumnWidth);
		$(this).parent().siblings().find("ul").slideUp();
	});

	$("li#menu-control").click(function(){

		var leftColumnWidth = $("#left-column").width();
		var browserWidth = $(window).width();

		if(leftColumnWidth == 73){
			// Get current with of right column
			var rightColumnWidth = $("#content").width();

			menuOpen("223");
		}else{
			menuClose("73");
		}

	});

	menuOpen("223");

	/* Main Nav - Highlight Active Menu Item */

	function getURLVar(urlVarName) {
		var urlHalves = String(document.location).toLowerCase().split('?');
		var urlVarValue = '';

		if (urlHalves[1]) {
			var urlVars = urlHalves[1].split('&');

			for (var i = 0; i <= (urlVars.length); i++) {
				if (urlVars[i]) {
					var urlVarPair = urlVars[i].split('=');

					if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
						urlVarValue = urlVarPair[1];
					}
				}
			}
		}

		return urlVarValue;
	} 

	route = getURLVar('route');
	
	if (!route) {
		$('#dashboard').addClass('selected');
	} else {
		part = route.split('/');
		
		url = part[0];
		
		if (part[1]) {
			url += '/' + part[1];
		}
		
		$('a[href*=\'' + url + '\']').parents('li[id]').addClass('selected');
	}


	/*  Main Nav - Change Arrow Image */

	$("ul.mainnav li:not(.selected) a").hover(function(){
		$(this).find("span img").attr("src","view/image/admin_theme/base5builder_impulsepro/dropdown-arrow-white.png");
	},function(){
		$(this).find("span img").attr("src","view/image/admin_theme/base5builder_impulsepro/dropdown-arrow.png");
	});



	/* Add Class To Save/Insert/Delete... etc */

	var buttonExists = $(".buttons .button").height();

	if(buttonExists > 0){

		function getURLVars(urlVarName, getActionURL) {
			
			if(getActionURL == undefined){
				var getActionURL = '?';
			}
			var urlHalves = getActionURL.toLowerCase().split('?');
			var urlVarValue = '';

			if (urlHalves[1]) {
				var urlVars = urlHalves[1].split('&');

				for (var i = 0; i <= (urlVars.length); i++) {
					if (urlVars[i]) {
						var urlVarPair = urlVars[i].split('=');

						if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
							urlVarValue = urlVarPair[1].split("/");
						}
					}
				}
			}

			return urlVarValue;
		}
		
		$(".buttons .button").each(function(){

			// first get the "href", then break it up to find the "key" term, like "insert", "delete", etc

			var getHrefFull = $(this).attr("href");

			var getAttrFull = $(this).attr("onclick");

			var getCancelButton = getURLVars("route",getHrefFull);

			if(getHrefFull != undefined){

				if(getHrefFull.indexOf("/insert&") > 0){

					$(this).addClass("insert");

				}else if(getHrefFull.indexOf("/copy&") > 0){

					$(this).addClass("copy");

				}else if((getCancelButton[0] && !getCancelButton[2]) || (getHrefFull.indexOf("/cancel&") > 0)){

					$(this).addClass("cancel");

				}else if(getHrefFull.indexOf("/delete&") > 0){

					$(this).addClass("delete");

				}else if(getHrefFull.indexOf("/repair&") > 0){

					$(this).addClass("repair");

				}

			}else{

				var getFormAction = $("#form").attr("action");
				var formAction = getURLVars("route",getFormAction);

				// Strip jargon from "onclick" data
				var toRemove = "location = '";
				var cleanAttr = getAttrFull.replace(toRemove,'');

				var toRemove = "';";
				var getAttr = cleanAttr.replace(toRemove,'');

				var getCancelButton = getURLVars("route",getHrefFull);

				// check if attr contains certain keywords
				if(getAttr.indexOf("/insert&") > 0){

					$(this).addClass("insert");

				}else if(((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'delete')) || ((getAttr.indexOf("('form').submit()") > 0) && (formAction[2] == 'delete'))){

					if(getAttr.indexOf("/copy&") > 0){
						$(this).addClass("copy");
					}else{

						$(this).addClass("delete");
					}

				}else if(((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'insert')) || ((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'update')) || ((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'save')) || ((getAttr.indexOf("('#form').submit()") > 0) && (!formAction[2])) || (getAttr.indexOf("/approve&") > 0) ){

					if(getAttr.indexOf("/delete&") > 0){

						$(this).addClass("delete");
					}else if(getAttr.indexOf("/invoice&") > 0){

						$(this).addClass("invoice");
					}else{

						$(this).addClass("save");
					}

				}else if((getCancelButton[0] && !getCancelButton[2]) || (getAttr.indexOf("/cancel&") > 0)){

					$(this).addClass("cancel");
				}else if(getAttr.indexOf("/copy&") > 0){

					$(this).removeClass("cancel");
					$(this).addClass("copy");

				}else if(getAttr.indexOf("/delete&") > 0){

					$(this).addClass("delete");
				}else if(getAttr.indexOf("('#restore').submit()") > 0){

					$(this).addClass("restore");
				}else if(getAttr.indexOf("('#backup').submit()") > 0){

					$(this).addClass("backup");
				}
			}

		});
	}


	/* Add Tab Arrows - Horizontal */

	$("<img src='view/image/admin_theme/base5builder_impulsepro/tab-arrow-green.png' class='arrow'>").prependTo("#tabs.htabs a.selected,#htabs.htabs a.selected");
	$("<img src='view/image/admin_theme/base5builder_impulsepro/tab-arrow-dark-grey.png' class='arrow'>").prependTo("#tabs.htabs a:not(.selected),#htabs.htabs a:not(.selected)");

	$("#tabs.htabs a,#htabs.htabs a").on("click",function(){
		$("#tabs.htabs a,#htabs.htabs a").find("img.arrow").remove();
		$("<img src='view/image/admin_theme/base5builder_impulsepro/tab-arrow-green.png' class='arrow'>").prependTo(this);
		$("<img src='view/image/admin_theme/base5builder_impulsepro/tab-arrow-dark-grey.png' class='arrow'>").prependTo("#tabs.htabs a:not(.selected),#htabs.htabs a:not(.selected)");
	});


	/* Add Tab Arrows - Vertical */

	$("<img src='view/image/admin_theme/base5builder_impulsepro/vtab-arrow-green.png' class='arrow'>").appendTo(".vtabs a.selected");
	$("<img src='view/image/admin_theme/base5builder_impulsepro/vtab-arrow-dark-grey.png' class='arrow'>").appendTo(".vtabs a:not(.selected)");

	$(".vtabs a").on("click",function(){
		$(".vtabs a").find("img.arrow").remove();
		$("<img src='view/image/admin_theme/base5builder_impulsepro/vtab-arrow-green.png' class='arrow'>").appendTo(this);
		$("<img src='view/image/admin_theme/base5builder_impulsepro/vtab-arrow-dark-grey.png' class='arrow'>").appendTo(".vtabs a:not(.selected)");
	});


	/* Top Menu Effects */

	$(".secondary-menu > ul > li").hover(function(e){
		$(this).find("ul").slideDown('fast');
		e.stopPropagation();
	}, function(e){
		$(this).find("ul").slideUp('fast');
		e.stopPropagation();
	});

});
