<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>{PHP_START}echo lang('{BREADCRUMB}'); {PHP_END}</h1>
		<ol class="breadcrumb">
	        <li><a href="#">Home</a></li>
	        <li class="active">{PHP_START}echo lang('{BREADCRUMB}'); {PHP_END}</li>
      </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- row -->
		<div class="row">
			<div class="col-xs-12 connectedSortable">
				{PHP_START}echo displayStatus(); {PHP_END}
				<div id='jqxGrid{MODULE_TITLE}Toolbar' class='grid-toolbar'>
					<button type="button" class="btn btn-primary btn-flat btn-xs" id="jqxGrid{MODULE_TITLE}Insert">{PHP_START}echo lang('general_create'); {PHP_END}</button>
					<button type="button" class="btn btn-danger btn-flat btn-xs" id="jqxGrid{MODULE_TITLE}FilterClear">{PHP_START}echo lang('general_clear'); {PHP_END}</button>
				</div>
				<div id="jqxGrid{MODULE_TITLE}"></div>
			</div><!-- /.col -->
		</div>
		<!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="jqxPopupWindow{MODULE_TITLE}">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title"></span>
    </div>
    <div class="form_fields_area">
        {PHP_START}echo form_open('', array('id' =>'form-{MODULE}', 'onsubmit' => 'return false')); {PHP_END}
        	<input type = "hidden" name = "id" id = "{MODULE}_id"/>
            <table class="form-table">{FORMFIELDS}
                <tr>
                    <th colspan="2">
                        <button type="button" class="btn btn-success btn-xs btn-flat" id="jqx{MODULE_TITLE}SubmitButton">{PHP_START}echo lang('general_save'); {PHP_END}</button>
                        <button type="button" class="btn btn-default btn-xs btn-flat" id="jqx{MODULE_TITLE}CancelButton">{PHP_START}echo lang('general_cancel'); {PHP_END}</button>
                    </th>
                </tr>
               
          </table>
        {PHP_START}echo form_close(); {PHP_END}
    </div>
</div>

<script language="javascript" type="text/javascript">

$(function(){

	var {MODULE}DataSource =
	{
		datatype: "json",
		datafields: [
			{DATAFIELDS}
        ],
		url: '{PHP_START}echo site_url("admin/{MODULE}/json"); {PHP_END}',
		pagesize: defaultPageSize,
		root: 'rows',
		id : 'id',
		cache: true,
		pager: function (pagenum, pagesize, oldpagenum) {
        	//callback called when a page or page size is changed.
        },
        beforeprocessing: function (data) {
        	{MODULE}DataSource.totalrecords = data.total;
        },
	    // update the grid and send a request to the server.
	    filter: function () {
	    	$("#jqxGrid{MODULE_TITLE}").jqxGrid('updatebounddata', 'filter');
	    },
	    // update the grid and send a request to the server.
	    sort: function () {
	    	$("#jqxGrid{MODULE_TITLE}").jqxGrid('updatebounddata', 'sort');
	    },
	    processdata: function(data) {
	    }
	};
	
	$("#jqxGrid{MODULE_TITLE}").jqxGrid({
		theme: theme,
		width: '100%',
		height: gridHeight,
		source: {MODULE}DataSource,
		altrows: true,
		pageable: true,
		sortable: true,
		rowsheight: 30,
		columnsheight:30,
		showfilterrow: true,
		filterable: true,
		columnsresize: true,
		autoshowfiltericon: true,
		columnsreorder: true,
		selectionmode: 'none',
		virtualmode: true,
		enableanimations: false,
		pagesizeoptions: pagesizeoptions,
		showtoolbar: true,
		rendertoolbar: function (toolbar) {
			var container = $("<div style='margin: 5px; height:50px'></div>");
			container.append($('#jqxGrid{MODULE_TITLE}Toolbar').html());
			toolbar.append(container);
		},
		columns: [
			{ text: 'SN', width: 50, pinned: true, exportable: false,  columntype: 'number', cellclassname: 'jqx-widget-header', renderer: gridColumnsRenderer, cellsrenderer: rownumberRenderer , filterable: false},
			{
				text: 'Action', datafield: 'action', width:75, sortable:false,filterable:false, pinned:true, align: 'center' , cellsalign: 'center', cellclassname: 'grid-column-center', 
				cellsrenderer: function (index) {
					var e = '<a href="javascript:void(0)" onclick="edit{MODULE_TITLE}Record(' + index + '); return false;" title="<?php echo lang("general_edit"); ?>"><i class="fa fa-edit"></i></a>';
					return '<div style="text-align: center; margin-top: 8px;">' + e + '</div>';
				}
			},
			{COLUMN_FIELDS}
		],
		rendergridrows: function (result) {
			return result.data;
		}
	});

	$("[data-toggle='offcanvas']").click(function(e) {
	    e.preventDefault();
	    setTimeout(function() {$("#jqxGrid{MODULE_TITLE}").jqxGrid('refresh');}, 500);
	});

	$(document).on('click','#jqxGrid{MODULE_TITLE}FilterClear', function () { 
		$('#jqxGrid{MODULE_TITLE}').jqxGrid('clearfilters');
	});

	$(document).on('click','#jqxGrid{MODULE_TITLE}Insert', function () { 
		openPopupWindow('jqxPopupWindow{MODULE_TITLE}', '{PHP_START}echo lang("general_add")  . "&nbsp;" .  $header; {PHP_END}');
    });

	// initialize the popup window
    $("#jqxPopupWindow{MODULE_TITLE}").jqxWindow({ 
        theme: theme,
        width: '75%',
        maxWidth: '75%',
        height: '75%',  
        maxHeight: '75%',  
        isModal: true, 
        autoOpen: false,
        modalOpacity: 0.7,
        showCollapseButton: false 
    });

    $("#jqxPopupWindow{MODULE_TITLE}").on('close', function () {
        reset_form_{MODULE}();
    });

    $("#jqx{MODULE_TITLE}CancelButton").on('click', function () {
        reset_form_{MODULE}();
        $('#jqxPopupWindow{MODULE_TITLE}').jqxWindow('close');
    });

    /*$('#form-{MODULE}').jqxValidator({
        hintType: 'label',
        animationDuration: 500,
        rules: [{VALIDATION_RULES}
        ]
    });*/

    $("#jqx{MODULE_TITLE}SubmitButton").on('click', function () {
        save{MODULE_TITLE}Record();
        /*
        var validationResult = function (isValid) {
                if (isValid) {
                   save{MODULE_TITLE}Record();
                }
            };
        $('#form-{MODULE}').jqxValidator('validate', validationResult);
        */
    });
});

function edit{MODULE_TITLE}Record(index){
    var row =  $("#jqxGrid{MODULE_TITLE}").jqxGrid('getrowdata', index);
  	if (row) {
  		$('#{MODULE}_id').val(row.id);
        {EDITFIELDS}
        openPopupWindow('jqxPopupWindow{MODULE_TITLE}', '{PHP_START}echo lang("general_edit")  . "&nbsp;" .  $header; {PHP_END}');
    }
}

function save{MODULE_TITLE}Record(){
    var data = $("#form-{MODULE}").serialize();
	
	$('#jqxPopupWindow{MODULE_TITLE}').block({ 
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
        url: '{PHP_START}echo site_url("admin/{MODULE}/save"); {PHP_END}',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                reset_form_{MODULE}();
                $('#jqxGrid{MODULE_TITLE}').jqxGrid('updatebounddata');
                $('#jqxPopupWindow{MODULE_TITLE}').jqxWindow('close');
            }
            $('#jqxPopupWindow{MODULE_TITLE}').unblock();
        }
    });
}

function reset_form_{MODULE}(){
	$('#{MODULE}_id').val('');
    $('#form-{MODULE}')[0].reset();
}
</script>