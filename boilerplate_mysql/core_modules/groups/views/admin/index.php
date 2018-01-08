<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo lang('groups'); ?></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- row -->
		<div class="row">
			<div class="col-xs-12 connectedSortable">
				<?php echo displayStatus(); ?>
				<div id='jqxGridGroupToolbar' class='grid-toolbar'>
                    <?php if($this->session->userdata('id') == 1):?>
					<button type="button" class="btn btn-primary btn-flat btn-xs" id="jqxGridGroupInsert"><?php echo lang('general_create'); ?></button>
                    <?php endif;?>
					<button type="button" class="btn btn-danger btn-flat btn-xs" id="jqxGridGroupFilterClear"><?php echo lang('general_clear'); ?></button>
				</div>
				<div id="jqxGridGroup"></div>
			</div><!-- /.col -->
		</div>
		<!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="jqxPopupWindowGroup">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-groups', 'onsubmit' => 'return false')); ?>
            <table class="form-table">
                <input type="hidden" name="mode" id="mode" />
                <tr>
                    <td><label for='name'>ID</label></td>
                    <td><input id='id' class='text_input' name='id'></td>
                </tr>
				<tr>
					<td><label for='name'><?php echo lang('name')?></label></td>
					<td><input id='name' class='text_input' name='name'></td>
				</tr>
				<tr>
					<td><label for='definition'><?php echo lang('definition')?></label></td>
					<td><textarea id='definition' class='text_area' name='definition'></textarea></td>
				</tr>
                <tr>
                    <th colspan="2">
                        <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxGroupSubmitButton"><?php echo lang('general_save'); ?></button>
                        <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxGroupCancelButton"><?php echo lang('general_cancel'); ?></button>
                    </th>
                </tr>
          </table>
        <?php echo form_close(); ?>
    </div>
</div>

<div id="jqxPopupWindowGroupUsers">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title_group"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-groups-users', 'onsubmit' => 'return false')); ?>
        	<input type = "hidden" name = "group_id" id = "group_id_users"/>
            <input type = "hidden" name = "involved_users_ids" id = "involved_users_ids"/>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxGroupUsersSubmitButton"><?php echo lang('general_save'); ?></button>
                    <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxGroupUsersCancelButton"><?php echo lang('general_close'); ?></button>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label>NOT INVOLVED</label>
                    <ul class="not_involved_users" id="not_involved_users"></ul>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label>INVOLVED</label>
                    <ul class="involved_users" id="involved_users"></ul>
                    </select>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script language="javascript" type="text/javascript">

$(function(){

	var groupsDataSource =
	{
		datatype: "json",
		datafields: [
			{ name: 'id', type: 'number' },
			{ name: 'name', type: 'string' },
			{ name: 'definition', type: 'string' },
			
        ],
		url: '<?php echo site_url("admin/groups/json"); ?>',
		pagesize: defaultPageSize,
		root: 'rows',
		id : 'id',
		cache: true,
		pager: function (pagenum, pagesize, oldpagenum) {
        	//callback called when a page or page size is changed.
        },
        beforeprocessing: function (data) {
        	groupsDataSource.totalrecords = data.total;
        },
	    // update the grid and send a request to the server.
	    filter: function () {
	    	$("#jqxGridGroup").jqxGrid('updatebounddata', 'filter');
	    },
	    // update the grid and send a request to the server.
	    sort: function () {
	    	$("#jqxGridGroup").jqxGrid('updatebounddata', 'sort');
	    },
	    processdata: function(data) {
	    }
	};
	
	$("#jqxGridGroup").jqxGrid({
		theme: theme,
		width: '100%',
		height: gridHeight,
		source: groupsDataSource,
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
			container.append($('#jqxGridGroupToolbar').html());
			toolbar.append(container);
		},
		columns: [
			{ text: 'SN', width: 50, pinned: true, exportable: false,  columntype: 'number', cellclassname: 'jqx-widget-header', renderer: gridColumnsRenderer, cellsrenderer: rownumberRenderer , filterable: false},
			{
				text: 'Action', datafield: 'action', width:75, sortable:false,filterable:false, pinned:true, align: 'center' , cellsalign: 'center', cellclassname: 'grid-column-center', 
				cellsrenderer: function (index) {
					var e = '', d='', row =  $("#jqxGridGroup").jqxGrid('getrowdata', index);
						<?php if($this->session->userdata('id') == 1):?>
                        e = '<a href="javascript:void(0)" onclick="editGroupRecord(' + index + '); return false;" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;',
                        d = '<a href="javascript:void(0)" onclick="deleteGroupRecord(' + index + '); return false;" title="Edit"><i class="fa fa-trash"></i></a>&nbsp;';
                        <?php endif;?>
						g = '<a href="javascript:void(0)" onclick="updateGroupUsers(' + index + '); return false;" title="Update Users"><i class="fa fa-users"></i></a>&nbsp;';

						return '<div style="text-align: center; margin-top: 8px; font-size:14px">' + e + d + g +'</div>';	
                        
				}
			},
			{ text: '<?php echo lang("name"); ?>',datafield: 'name',width: 200,filterable: true,renderer: gridColumnsRenderer },
			{ text: '<?php echo lang("definition"); ?>',datafield: 'definition',width: 500,filterable: true,renderer: gridColumnsRenderer },
			
		],
		rendergridrows: function (result) {
			return result.data;
		}
	});

	$("[data-toggle='offcanvas']").click(function(e) {
	    e.preventDefault();
	    setTimeout(function() {$("#jqxGridGroup").jqxGrid('refresh');}, 500);
	});

	$(document).on('click','#jqxGridGroupFilterClear', function () { 
		$('#jqxGridGroup').jqxGrid('clearfilters');
	});

    <?php if($this->session->userdata('id') == 1):?>
	$(document).on('click','#jqxGridGroupInsert', function () { 
        $('#id').attr('readonly', false);
        $('#mode').val('insert');
		openPopupWindow('jqxPopupWindowGroup', '<?php echo lang("general_add")  . "&nbsp;" .  $header; ?>');
    });
    <?php endif;?>

	// initialize the popup window
    $("#jqxPopupWindowGroup").jqxWindow({ 
        theme: theme,
        width: 500,
        maxWidth: 500,
        height: 250,  
        maxHeight: 250,  
        isModal: true, 
        autoOpen: false,
        modalOpacity: 0.7,
        showCollapseButton: false 
    });

        // initialize the popup window
    $("#jqxPopupWindowGroupUsers").jqxWindow({ 
        theme: theme,
        width: '90%',
        maxWidth: '90%',
        height: '80%',  
        maxHeight: '80%',  
        isModal: true, 
        autoOpen: false,
        modalOpacity: 0.7,
        showCollapseButton: false 
    });

    $("#jqxPopupWindowGroup").on('close', function () {
        $('#id').val('');
        $('#form-groups')[0].reset();
    });

    $("#jqxGroupCancelButton").on('click', function () {
        $('#id').val('');
        $('#form-groups')[0].reset();
        $('#jqxPopupWindowGroup').jqxWindow('close');
    });

    $("#jqxGroupUsersCancelButton").on('click', function () {
        $('#user_id_groups').val('');
        $('#form-groups-users')[0].reset();
        $('#jqxPopupWindowGroupUsers').jqxWindow('close');
    });

    $('#form-groups').jqxValidator({
        hintType: 'label',
        animationDuration: 500,
        rules: [
			{ input: '#name', message: 'Required', action: 'blur', rule: 'required' },
            { input: '#name', message: 'Group already exists', action: 'blur', 
                rule: function(input, commit) {
                	val = $("#name").val();
                    $.ajax({
                        url: "<?php echo site_url('admin/groups/check_duplicate'); ?>",
                        type: 'POST',
                        data: {model: 'groups/group_model', field: 'name', value: val, id:$('input#id').val()},
                        success: function (result) {
                            var result = eval('('+result+')');
                            return commit(result.success);
                        },
                        error: function(result) {
                            return commit(false);
                        }
                    });
                }
            },
        ]
    });

    $("#jqxGroupSubmitButton").on('click', function () {
        var validationResult = function (isValid) {
                if (isValid) {
                   saveGroupRecord();
                }
            };
        $('#form-groups').jqxValidator('validate', validationResult);
    });

    $("#jqxGroupUsersSubmitButton").on('click', function () {
        saveGroupUsersRecord();
    });

    $(document).on('click','.not_involved_users',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-not_involved_user_id'),
            item = '<li class="item selected-item" id="involvedusers' + gid + '" data-involved_user_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#alluser_" + gid).remove();
        $("#involved_users").append(item);
    });

    $(document).on('click','.involved_users',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-involved_user_id'),
            item = '<li class="item unselected-item" id="alluser_' + gid + '" data-not_involved_user_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#involvedusers" + gid).remove();
        $("#not_involved_users").append(item);
    });
});


<?php if($this->session->userdata('id') == 1):?>


function editGroupRecord(index){
    var row =  $("#jqxGridGroup").jqxGrid('getrowdata', index);
    if (row) {
        $('#mode').val('update');
        $('#id').attr('readonly', true);
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#definition').val(row.definition);
        
        openPopupWindow('jqxPopupWindowGroup', '<?php echo lang("general_edit")  . "&nbsp;" .  $header; ?>');
    }
}

function saveGroupRecord(){
    var data = $("#form-groups").serialize();

    $('#jqxPopupWindowGroup').block({ 
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
        url: '<?php echo site_url("admin/groups/save"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#id').val('');
                $('#form-groups')[0].reset();
                $('#jqxGridGroup').jqxGrid('updatebounddata');
                $('#jqxPopupWindowGroup').jqxWindow('close');
            } else {
                alert(result.msg);
            }

            $('#jqxPopupWindowGroup').unblock();
        }
    });
}

function deleteGroupRecord(index){
    var row =  $("#jqxGridGroup").jqxGrid('getrowdata', index);
    if (row) {
        var r = confirm("Are you SURE you want delete these group? Doing so will also REMOVE all Users in this group.");
        if (r == true) {
            $.ajax({
                url: "<?php echo site_url('admin/groups/delete_group'); ?>",
                type: 'POST',
                data: {id:row.id},
                success: function (result) {
                   $('#jqxGridGroup').jqxGrid('updatebounddata');
                }
            });
        }  
    }
}
<?php endif;?>

function saveGroupUsersRecord(){
    
    $('#jqxPopupWindowGroupUsers').block({ 
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

    var lists = $("#involved_users").find("li"),
        involved_users_ids = [];

        for (i=0; i < lists.length; i++) {
            r = lists[i],
            involved_user_id = $(r).attr('data-involved_user_id');
            involved_users_ids.push(involved_user_id);
        }

    $("#involved_users_ids").val(involved_users_ids);
 
    var data = $("#form-groups-users").serialize();

    $.ajax({
        type: "POST",
        url: '<?php echo site_url("admin/groups/save_group_users"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#form-groups-users')[0].reset();
                alert('Saved');
            } 
            $('#jqxPopupWindowGroupUsers').unblock();
        }
    });
}

function updateGroupUsers(index){
    var row =  $("#jqxGridGroup").jqxGrid('getrowdata', index);
  	
    if (row) {
        
        $('#group_id_users').val(row.id); 
        msg = '<?php echo lang('permission_users'); ?>';
        $('#window_poptup_title_group').html('Add User to ' + row.name + ' Groups');
        openPopupWindow('jqxPopupWindowGroupUsers', 'N/A');  
        
        $('#jqxPopupWindowGroupUsers').block({ 
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
            url: "<?php echo site_url('admin/groups/get_group_users'); ?>",
            type: 'POST',
            data: {id:row.id},
            success: function (results) {
               $('#jqxPopupWindowGroupUsers').unblock();

                var results = eval('('+results+')'),
                involved_users = results.involved_users,
                not_involved_users = results.not_involved_users;

                if(results.not_involved_users.length < 1) {
                    $("#not_involved_users").empty();
                    return;
                }
                $("#not_involved_users").empty();
                $.each(not_involved_users,function(index,user) {
                    var i = $.inArray(parseInt(user.id),not_involved_users);
                    if(i == -1) {
                        var item = '<li class="item unselected-item" id="alluser_' + user.id + '" data-not_involved_user_id="' + user.id + '">' + user.username + ' (' + user.email+ ')</li>';

                        $("#not_involved_users").append(item);
                    }
                });

                if(results.involved_users.length < 1) {
                    $("#involved_users").empty();
                    return;
                }
                $("#involved_users").empty();
                $.each(involved_users,function(index,user) {
                    var i = $.inArray(parseInt(user.group_id),involved_users);
                    if(i == -1) {
                        var item = '<li class="item selected-item" id="involvedusers' + user.user_id + '" data-involved_user_id="' + user.user_id + '">' + user.username + ' (' + user.email+ ')</li>';
                        $("#involved_users").append(item);
                    }
                });
            }
        });
    }
}
</script>