<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo lang('permissions'); ?></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- row -->
		<div class="row">
			<div class="col-xs-12 connectedSortable">
				<?php echo displayStatus(); ?>
				<div id='jqxGridPermissionToolbar' class='grid-toolbar'>
                    <?php if($this->session->userdata('id') == 1):?>
					<button type="button" class="btn btn-primary btn-flat btn-xs" id="jqxGridPermissionInsert"><?php echo lang('general_create'); ?></button>
                    <?php endif;?>
					<button type="button" class="btn btn-danger btn-flat btn-xs" id="jqxGridPermissionFilterClear"><?php echo lang('general_clear'); ?></button>
				</div>
				<div id="jqxGridPermission"></div>
			</div><!-- /.col -->
		</div>
		<!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="jqxPopupWindowPermission">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-permissions', 'onsubmit' => 'return false')); ?>
        	<input type = "hidden" name = "id" id = "id"/>
            <table class="form-table">
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
                        <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxPermissionSubmitButton"><?php echo lang('general_save'); ?></button>
                        <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxPermissionCancelButton"><?php echo lang('general_cancel'); ?></button>
                    </th>
                </tr>
          </table>
        <?php echo form_close(); ?>
    </div>
</div>

<div id="jqxPopupWindowPermissionUsers">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title_user"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-permissions-users', 'onsubmit' => 'return false')); ?>
            <input type = "hidden" name = "perm_id" id = "permission_id_users"/>
            <input type = "hidden" name = "granted_users_ids" id = "granted_users_ids"/>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxPermissionUsersSubmitButton"><?php echo lang('general_save'); ?></button>
                    <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxPermissionUsersCancelButton"><?php echo lang('general_close'); ?></button>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label>NOT GRANTED</label>
                    <ul class="not_granted_users" id="not_granted_users"></ul>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label>GRANTED</label>
                    <ul class="granted_users" id="granted_users"></ul>
                    </select>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <?php echo form_close(); ?>
    </div>
</div>

<div id="jqxPopupWindowPermissionGroups">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title_group"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-permissions-groups', 'onsubmit' => 'return false')); ?>
        	<input type = "hidden" name = "perm_id" id = "permission_id_groups"/>
            <input type = "hidden" name = "granted_groups_ids" id = "granted_groups_ids"/>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxPermissionGroupsSubmitButton"><?php echo lang('general_save'); ?></button>
                    <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxPermissionGroupsCancelButton"><?php echo lang('general_close'); ?></button>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label>NOT GRANTED</label>
                    <ul class="not_granted_groups" id="not_granted_groups"></ul>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label>GRANTED</label>
                    <ul class="granted_groups" id="granted_groups"></ul>
                    </select>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script language="javascript" type="text/javascript">

$(function(){

	var permissionsDataSource =
	{
		datatype: "json",
		datafields: [
			{ name: 'id', type: 'number' },
			{ name: 'name', type: 'string' },
			{ name: 'definition', type: 'string' },
			
        ],
		url: '<?php echo site_url("admin/permissions/json"); ?>',
		pagesize: defaultPageSize,
		root: 'rows',
		id : 'id',
		cache: true,
		pager: function (pagenum, pagesize, oldpagenum) {
        	//callback called when a page or page size is changed.
        },
        beforeprocessing: function (data) {
        	permissionsDataSource.totalrecords = data.total;
        },
	    // update the grid and send a request to the server.
	    filter: function () {
	    	$("#jqxGridPermission").jqxGrid('updatebounddata', 'filter');
	    },
	    // update the grid and send a request to the server.
	    sort: function () {
	    	$("#jqxGridPermission").jqxGrid('updatebounddata', 'sort');
	    },
	    processdata: function(data) {
	    }
	};
	
	$("#jqxGridPermission").jqxGrid({
		theme: theme,
		width: '100%',
		height: gridHeight,
		source: permissionsDataSource,
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
			container.append($('#jqxGridPermissionToolbar').html());
			toolbar.append(container);
		},
		columns: [
			{ text: 'SN', width: 50, pinned: true, exportable: false,  columntype: 'number', cellclassname: 'jqx-widget-header', renderer: gridColumnsRenderer, cellsrenderer: rownumberRenderer , filterable: false},
			{
				text: 'Action', datafield: 'action', width:100, sortable:false,filterable:false, pinned:true, align: 'center' , cellsalign: 'center', cellclassname: 'grid-column-center', 
				cellsrenderer: function (index) {
					var e = '', d='', row =  $("#jqxGridPermission").jqxGrid('getrowdata', index);
						<?php if($this->session->userdata('id') == 1):?>
                        e = '<a href="javascript:void(0)" onclick="editPermissionRecord(' + index + '); return false;" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;',
						d = '<a href="javascript:void(0)" onclick="deletePermissionRecord(' + index + '); return false;" title="Edit"><i class="fa fa-trash"></i></a>&nbsp;',
                        <?php endif;?>
						u = '<a href="javascript:void(0)" onclick="addPermissionToUsers(' + index + '); return false;" title="Add User"><i class="fa fa-user"></i></a>&nbsp;';
						g = '<a href="javascript:void(0)" onclick="addPermissionToGroups(' + index + '); return false;" title="Add Groups"><i class="fa fa-users"></i></a>';
					if (row.id == '1') {
						return '<div style="text-align: center; margin-top: 8px;">&nbsp;</div>';
					} else {
						return '<div style="text-align: center; margin-top: 8px; font-size:14px"">' + e + d + u + g + '</div>';	
					}
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
	    setTimeout(function() {$("#jqxGridPermission").jqxGrid('refresh');}, 500);
	});

	$(document).on('click','#jqxGridPermissionFilterClear', function () { 
		$('#jqxGridPermission').jqxGrid('clearfilters');
	});

    <?php if($this->session->userdata('id') == 1):?>
	$(document).on('click','#jqxGridPermissionInsert', function () { 
		openPopupWindow('jqxPopupWindowPermission', '<?php echo lang("general_add")  . "&nbsp;" .  $header; ?>');
    });
    <?php endif;?>

	// initialize the popup window
    $("#jqxPopupWindowPermission").jqxWindow({ 
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
    $("#jqxPopupWindowPermissionUsers").jqxWindow({ 
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

    // initialize the popup window
    $("#jqxPopupWindowPermissionGroups").jqxWindow({ 
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

    $("#jqxPopupWindowPermission").on('close', function () {
        $('#id').val('');
        $('#form-permissions')[0].reset();
    });

    $("#jqxPopupWindowPermissionUsers").on('close', function () {
        $('#permission_id_users').val('');
        $('#form-permissions-users')[0].reset();
    });

    $("#jqxPopupWindowPermissionGroups").on('close', function () {
        $('#permission_id_groups').val('');
        $('#form-permissions-groups')[0].reset();
    });

    $("#jqxPermissionCancelButton").on('click', function () {
        $('#id').val('');
        $('#form-permissions')[0].reset();
        $('#jqxPopupWindowPermission').jqxWindow('close');
    });

    $("#jqxPermissionUsersCancelButton").on('click', function () {
        $('#permission_id_users').val('');
        $('#form-permissions-users')[0].reset();
        $('#jqxPopupWindowPermissionUsers').jqxWindow('close');
    });

    $("#jqxPermissionGroupsCancelButton").on('click', function () {
        $('#permission_id_groups').val('');
        $('#form-permissions-groups')[0].reset();
        $('#jqxPopupWindowPermissionGroups').jqxWindow('close');
    });

    $('#form-permissions').jqxValidator({
        hintType: 'label',
        animationDuration: 500,
        rules: [
			{ input: '#name', message: 'Required', action: 'blur', rule: 'required' },
            { input: '#name', message: 'Permission already exists', action: 'blur', 
                rule: function(input, commit) {

                    val = $("#name").val();
                    $.ajax({
                        url: "<?php echo site_url('admin/permissions/check_duplicate'); ?>",
                        type: 'POST',
                        data: {model: 'permissions/permission_model', field: 'name', value: val, id:$('input#id').val()},
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

    $("#jqxPermissionSubmitButton").on('click', function () {
        var validationResult = function (isValid) {
                if (isValid) {
                   savePermissionRecord();
                }
            };
        $('#form-permissions').jqxValidator('validate', validationResult);
    });

    $("#jqxPermissionGroupsSubmitButton").on('click', function () {
        savePermissionGroupsRecord();
    });

    $("#jqxPermissionUsersSubmitButton").on('click', function () {
        savePermissionUsersRecord();
    });

    $(document).on('click','.not_granted_groups',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-not_granted_group_id'),
            item = '<li class="item selected-item" id="grantedgroups_' + gid + '" data-granted_group_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#allgroup_" + gid).remove();
        $("#granted_groups").append(item);
    });

    $(document).on('click','.granted_groups',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-granted_group_id'),
            item = '<li class="item unselected-item" id="allgroup_' + gid + '" data-not_granted_group_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#grantedgroups_" + gid).remove();
        $("#not_granted_groups").append(item);
    });

    $(document).on('click','.not_granted_users',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-not_granted_user_id'),
            item = '<li class="item selected-item" id="grantedusers_' + gid + '" data-granted_user_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#alluser_" + gid).remove();
        $("#granted_users").append(item);
    });

    $(document).on('click','.granted_users',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-granted_user_id'),
            item = '<li class="item unselected-item" id="alluser_' + gid + '" data-not_granted_user_id="' + gid + '">' + (e.target).textContent + '</li>';

        $("#grantedusers_" + gid).remove();
        $("#not_granted_users").append(item);
    });

});


<?php if($this->session->userdata('id') == 1):?>
function editPermissionRecord(index){
    var row =  $("#jqxGridPermission").jqxGrid('getrowdata', index);
    if (row) {
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#definition').val(row.definition);
        
        openPopupWindow('jqxPopupWindowPermission', '<?php echo lang("general_edit")  . "&nbsp;" .  $header; ?>');
    }
}

function savePermissionRecord(){
    var data = $("#form-permissions").serialize();
    
    $('#jqxPopupWindowPermission').block({ 
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
        url: '<?php echo site_url("admin/permissions/save"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#id').val('');
                $('#form-permissions')[0].reset();
                $('#jqxGridPermission').jqxGrid('updatebounddata');
                $('#jqxPopupWindowPermission').jqxWindow('close');
            } else {
                alert(result.msg);
            }
            $('#jqxPopupWindowPermission').unblock();
        }
    });
}

function deletePermissionRecord(index){
    var row =  $("#jqxGridPermission").jqxGrid('getrowdata', index);
    if (row) {
        var r = confirm("Are you SURE you want delete these Permission? Doing so will also REMOVE all Group/Users having these permission. WARNING: DOING SO MAY LOCK YOU OUT OF THE SYSTEM!!!");
        if (r == true) {
            $.ajax({
                url: "<?php echo site_url('admin/permissions/delete_permission'); ?>",
                type: 'POST',
                data: {id:row.id},
                success: function (result) {
                   $('#jqxGridPermission').jqxGrid('updatebounddata');
                }
            });
        }  
    }
}
<?php endif;?>


function savePermissionGroupsRecord(){
    
    $('#jqxPopupWindowPermissionGroups').block({ 
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

    var lists = $("#granted_groups").find("li"),
        granted_groups_ids = [];

        for (i=0; i < lists.length; i++) {
            r = lists[i],
            granted_group_id = $(r).attr('data-granted_group_id');
            granted_groups_ids.push(granted_group_id);
        }

    $("#granted_groups_ids").val(granted_groups_ids);
 
    var data = $("#form-permissions-groups").serialize();

    $.ajax({
        type: "POST",
        url: '<?php echo site_url("admin/permissions/save_permission_groups"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#form-permissions-groups')[0].reset();
                $('#jqxPopupWindowPermission').jqxWindow('close');
                alert('Saved');
            } 
            $('#jqxPopupWindowPermissionGroups').unblock();
        }
    });
}

function savePermissionUsersRecord(){
    
    $('#jqxPopupWindowPermissionUsers').block({ 
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

    var lists = $("#granted_users").find("li"),
        granted_users_ids = [];

        for (i=0; i < lists.length; i++) {
            r = lists[i],
            granted_user_id = $(r).attr('data-granted_user_id');
            granted_users_ids.push(granted_user_id);
        }

    $("#granted_users_ids").val(granted_users_ids);
 
    var data = $("#form-permissions-users").serialize();

    $.ajax({
        type: "POST",
        url: '<?php echo site_url("admin/permissions/save_permission_users"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#form-permissions-users')[0].reset();
                $('#jqxPopupWindowPermission').jqxWindow('close');
                alert('Saved');
            } 
            $('#jqxPopupWindowPermissionUsers').unblock();
        }
    });
}

function addPermissionToUsers(index){
    var row =  $("#jqxGridPermission").jqxGrid('getrowdata', index);
    
    if (row) {
        $('#permission_id_users').val(row.id); 
        msg = '<?php echo lang('permission_users'); ?>';
        $('#window_poptup_title_user').html(msg.replace(/_PERMISSION_/, row.name));
        
        openPopupWindow('jqxPopupWindowPermissionUsers', 'N/A');  
        
        $('#jqxPopupWindowPermissionUsers').block({ 
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
            url: "<?php echo site_url('admin/permissions/get_permission_users'); ?>",
            type: 'POST',
            data: {id:row.id},
            success: function (results) {
               $('#jqxPopupWindowPermissionUsers').unblock();

                var results = eval('('+results+')'),
                granted_users = results.granted_users,
                not_granted_users = results.not_granted_users;

                if(results.not_granted_users.length < 1) {
                    $("#not_granted_users").empty();
                    return;
                }
                $("#not_granted_users").empty();
                $.each(not_granted_users,function(index,user) {
                    var i = $.inArray(parseInt(user.id),not_granted_users);
                    if(i == -1) {
                        var item = '<li class="item unselected-item" id="alluser_' + user.id + '" data-not_granted_user_id="' + user.id + '">' + user.username +' (' + user.email + ')</li>';
                        $("#not_granted_users").append(item);
                    }
                });

                if(results.granted_users.length < 1) {
                    $("#granted_users").empty();
                    return;
                }
                $("#granted_users").empty();
                $.each(granted_users,function(index,user) {
                    var i = $.inArray(parseInt(user.user_id),granted_users);
                    if(i == -1) {
                        var item = '<li class="item selected-item" id="grantedusers_' + user.user_id + '" data-granted_user_id="' + user.user_id + '">' + user.username +' (' + user.email + ')</li>';
                        $("#granted_users").append(item);
                    }
                });
            }
        });
    }
}

function addPermissionToGroups(index){
    var row =  $("#jqxGridPermission").jqxGrid('getrowdata', index);
  	
    if (row) {
        
        $('#permission_id_groups').val(row.id); 
        msg = '<?php echo lang('permission_groups'); ?>';
        $('#window_poptup_title_group').html(msg.replace(/_PERMISSION_/, row.name));
        openPopupWindow('jqxPopupWindowPermissionGroups', 'N/A');  
        
        $('#jqxPopupWindowPermissionGroups').block({ 
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
            url: "<?php echo site_url('admin/permissions/get_permission_groups'); ?>",
            type: 'POST',
            data: {id:row.id},
            success: function (results) {
               $('#jqxPopupWindowPermissionGroups').unblock();

                var results = eval('('+results+')'),
                granted_groups = results.granted_groups,
                not_granted_groups = results.not_granted_groups;

                if(results.not_granted_groups.length < 1) {
                    $("#not_granted_groups").empty();
                    return;
                }
                $("#not_granted_groups").empty();
                $.each(not_granted_groups,function(index,group) {
                    var i = $.inArray(parseInt(group.id),not_granted_groups);
                    if(i == -1) {
                        var item = '<li class="item unselected-item" id="allgroup_' + group.id + '" data-not_granted_group_id="' + group.id + '">' + group.name + '</li>';

                        $("#not_granted_groups").append(item);
                    }
                });

                if(results.granted_groups.length < 1) {
                    $("#granted_groups").empty();
                    return;
                }
                $("#granted_groups").empty();
                $.each(granted_groups,function(index,group) {
                    var i = $.inArray(parseInt(group.group_id),granted_groups);
                    if(i == -1) {
                        var item = '<li class="item selected-item" id="grantedgroups_' + group.group_id + '" data-granted_group_id="' + group.group_id + '">' + group.group_name + '</li>';
                        $("#granted_groups").append(item);
                    }
                });
            }
        });
    }
}
</script>