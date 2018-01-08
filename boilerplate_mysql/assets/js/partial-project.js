//app.js

var defaultPageSize = 100,
	pagesizeoptions = ['1','2','5','25', '50', '100', '500'],
	formatString_yyyy_MM_dd = 'yyyy-MM-dd',
	formatString_yyyy_MM_dd_HH_mm = 'yyyy-MM-dd HH:mm',
	formatString_yyyy_MM_dd_HH_mm_ss = 'yyyy-MM-dd HH:mm:ss',
	date_pattern = /^(200[0-9]|20[12345678][0-9]|2090)[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[012])$/,
	phone_pattern = /^(([0-9]{2,3})?[\s-]+(\d{6,7}))*$/,
	mobile_pattern = /^((98|97|96)[0-9]{8,8})*$/,

	theme = 'bootstrap',

	gridHeight = (window.innerHeight - 175),

	array_hierarchy_names = new Array('','COUNTRY','DISTRICT','REGION','ZONE'),
	array_location_types = new Array('','C','D','M','R','V','Z'),
	array_prefered_communication = ['N/A','Home 1', 'Home 2', 'Work 1', 'Work 2', 'Mobile 1', 'Mobile 2'],
	array_followup_modes = ['Phone', 'Email', 'Visit', 'Others'],
	array_followup_status = ['Open','In Progress', 'Completed'],
	array_inquiry_type = ['Warm','Hot','Cold'],
	array_test_drive_location = ['Dealer Place', 'Customer Choice'],

	rownumberRenderer = function (row, column, value) {
		return '<div style="text-align: center; margin-top: 8px;">' + (1 + value) + '</div>';
	},
	gridColumnsRenderer = function (value) {
		return '<div style="text-align: center; margin-top: 8px;">' + value + '</div>';
	};
	
var masterDataSource = {
    url : base_url + 'admin/common/get_master_combo_json',
    datatype: 'json',
    datafields: [
        { name: 'id', type: 'number' },
        { name: 'name', type: 'string' },
    ],
    async: false,
    cache: true
}


// For todays date;
Date.prototype.now = function () { 
    return  this.getFullYear() +"-"+(((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"-"+ ((this.getDate() < 10)?"0":"") + this.getDate() + ' ' + ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ ((this.getSeconds() < 10)?"0":"") + this.getSeconds();;
}

 Date.prototype.formatDate = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy + (mm[1]?mm:"0"+mm[0]) + (dd[1]?dd:"0"+dd[0]); // padding
};

$(document).ready(function () 
{
	if ($(".jqxExpander")[0]){
		$(".jqxExpander").jqxExpander({ width: 'auto', theme: theme });
	}

	if ($(".jqxExpander-collasped")[0]){
		$(".jqxExpander-collasped").jqxExpander({ width: 'auto', expanded: false , theme: theme });
	}

	if ($(".text_input")[0]){
		$(".text_input").jqxInput({ width: 195,height: 25, theme: theme });
	}

	if ($(".text_area")[0]){
		$(".text_area").jqxInput({ width: 325,height: 85, theme: theme });
	}

	if ($(".date_box")[0]){
		$(".date_box").jqxDateTimeInput({ width: 195, height: 25, formatString: formatString_yyyy_MM_dd, theme: theme });
	}

	if ($(".number_general")[0]){
		$(".number_general").jqxNumberInput({ width: 195,height: 25, inputMode: 'simple', spinButtons: false, min: 0, digits:10, max: 9999999999, decimalDigits: 0, spinButtonsStep: 1, theme: theme });
	}

	if ($(".number_percentage")[0]){
		$(".number_percentage").jqxNumberInput({ width: 195,height: 25, inputMode: 'simple', spinButtons: false, min: 0, digits:2, decimalDigits: 1, spinButtonsStep: 1, theme: theme });
	}

	if ($(".number_currency")[0]){
		$(".number_currency").jqxNumberInput({ width: 195,height: 25, inputMode: 'simple', spinButtons: false, min: -9999999999, decimalDigits: 2, theme: theme });
	}

	if ($(".jqxTabs")[0]){
		$('.jqxTabs').jqxTabs({ width: '100%', height: gridHeight+50, position: 'top', theme: theme});
	}

	$.ajaxSetup({
		data: {'csrf_token_cgdms': $.cookie('csrf_cookie_cgdms')}
	});

	$(document)
	.ajaxComplete(function(event,xhr,options){
		switch(xhr.status) {
			case 403:
				alert("TIMEOUT. Please try again");
				//location.reload();
				break;
			case 500:
				alert("500 Error");
				//location.reload();
				break;
			case 999:
				alert("SESSION TIMOUT. Reloading the Page");
				//location.reload();
				break;
		}
	});
});

function openPopupWindow() {
    jqxPopupWindowId = arguments[0];
    title = arguments[1];
    var x = ($(window).width() - $("#"+jqxPopupWindowId).jqxWindow('width')) / 2 + $(window).scrollLeft(),
        y = ($(window).height() - $("#"+jqxPopupWindowId).jqxWindow('height')) / 2 + $(window).scrollTop();
    
    if (title != 'N/A') {
    	$('#window_poptup_title').html(title);
	}

    $("#"+jqxPopupWindowId).jqxWindow({ position: { x: x, y: y} });
    $("#"+jqxPopupWindowId).jqxWindow('open');

}

function bs_to_ad() {

	module = arguments[0];
    jqxWindow = arguments[1];
    source = arguments[2];
    target = arguments[3];

	//check inputted nepali date is within range and is in valid format or not
	var nepali_date = $('#' + source).val();

	if (nepali_date == '') {
		alert('Please input nepali date');
		return;
	}

	res = (nepali_date.match(date_pattern)) ? true : false;

	if (!res) {
		alert('Invalid Date Format or out of range.\r\nValid Range: 2000-01-01 to 2090-12-30');
		return;
	}

	var url = base_url + 'admin/' + module + '/get_english_date';

	$('#'+jqxWindow).block({ 
        message: '<span>Processing your request. Please be patient.</span>',
        css: { 
            width                   : '75%',
            border                  : 'none', 
            padding                 : '50px', 
            backgroundColor         : '#000', 
            '-webkit-border-radius' : '10px', 
            '-moz-border-radius'    : '10px', 
            opacity                 : .7, 
            color                   : '#fff',
            cursor                  : 'wait' 
        }, 
    });

	$.ajax({
        type: "POST",
        url: url,
        data: {nepali_date: nepali_date},
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
            	$('#' + target).jqxDateTimeInput('setDate', result.date);
            	
            }
            $('#'+jqxWindow).unblock();
        }
    });		
}

function ad_to_bs() {

	module = arguments[0];
    jqxWindow = arguments[1];
    source = arguments[2];
    target = arguments[3];

	//check inputted nepali date is within range and is in valid format or not
	var english_date = $('#' + source).val();

	if (english_date == '') {
		alert('Please input english date');
		return;
	}

	var url = base_url + 'admin/' + module + '/get_nepali_date';

	$('#'+jqxWindow).block({ 
        message: '<span>Processing your request. Please be patient.</span>',
        css: { 
            width                   : '75%',
            border                  : 'none', 
            padding                 : '50px', 
            backgroundColor         : '#000', 
            '-webkit-border-radius' : '10px', 
            '-moz-border-radius'    : '10px', 
            opacity                 : .7, 
            color                   : '#fff',
            cursor                  : 'wait' 
        }, 
    });

	$.ajax({
        type: "POST",
        url: url,
        data: {english_date: english_date},
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
            	$('#' + target).val(result.date);
            	$('#'+jqxWindow).unblock();
            }
        }
    });		
}

// Builds the HTML Table out of records json data from Ivy restful service.
// 
function buildHtmlTable(records,tableid) {

    var columns = [];
    var headerTr$ = $('<tr/>');

    for (var i = 0 ; i < records.length ; i++) {
        var rowHash = records[i];
        for (var key in rowHash) {
            if ($.inArray(key, columns) == -1){
                columns.push(key);
                headerTr$.append($('<th/>').html(key));
            }
        }
    }

    $("#"+tableid).append(headerTr$);

    for (var i = 0 ; i < (records.length-1) ; i++) {
        var row$ = $('<tr/>');
        for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
            var cellValue = records[i][columns[colIndex]];

            if (cellValue == null) { cellValue = "-"; }

            row$.append($('<td/>').html(cellValue));
        }
        $("#"+tableid).append(row$);
    }

    for (var i = (records.length-1) ; i < records.length ; i++) {
        var row$ = $('<tr/>');
        for (var colIndex = 0 ; colIndex < columns.length ; colIndex++) {
            var cellValue = records[i][columns[colIndex]];

            if (cellValue == null) { cellValue = "-"; }

            row$.append($('<th/>').html(cellValue));
        }

        $("#"+tableid).append(row$);
    }
}
