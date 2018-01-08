<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo lang('users'); ?></h1>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- row -->
		<div class="row">
			<div class="col-xs-12 connectedSortable">
				<?php echo displayStatus(); ?>
				<div id='jqxGridUserToolbar' class='grid-toolbar'>
					<button type="button" class="btn btn-primary btn-flat btn-xs" id="jqxGridUserInsert"><?php echo lang('general_create'); ?></button>
					<button type="button" class="btn btn-danger btn-flat btn-xs" id="jqxGridUserFilterClear"><?php echo lang('general_clear'); ?></button>
				</div>
				<div id="jqxGridUser"></div>
			</div><!-- /.col -->
		</div>
		<!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div id="jqxPopupWindowUser">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-users', 'onsubmit' => 'return false')); ?>
        	<input type = "hidden" name = "id" id = "id"/>
            <table class="form-table">
				<tr>
					<td><label for='email'><?php echo lang('email')?></label></td>
					<td><input id='email' class='text_input' name='email'></td>
				</tr>
				<tr>
					<td><label for='username'><?php echo lang('username')?></label></td>
					<td><input id='username' class='text_input' name='username'></td>
				</tr>
				<tr>
					<td><label for='fullname'><?php echo lang('fullname')?></label></td>
					<td><input id='fullname' class='text_input' name='fullname'></td>
				</tr>
				<?php if (count($groups) > 0) : ?>
				<tr>
					<td><label for='groups'><?php echo lang('groups')?></label></td>
					<td>
						<?php foreach($groups as $group): ?>
							<input type="checkbox" name="groups[]" id="group_<?php echo $group->id;?>" value="<?php echo $group->id;?>"> <?php echo $group->name;?><br />
						<?php endforeach; ?>
					</td>
				</tr>
				<?php endif; ?>
                <tr>
                    <th colspan="2">
                        <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxUserSubmitButton"><?php echo lang('general_save'); ?></button>
                        <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxUserCancelButton"><?php echo lang('general_cancel'); ?></button>
                    </th>
                </tr>
          </table>
        <?php echo form_close(); ?>
    </div>
</div>

<div id="jqxPopupWindowUserGroups">
   <div class='jqxExpander-custom-div'>
        <span class='popup_title' id="window_poptup_title_group"></span>
    </div>
    <div class="form_fields_area">
        <?php echo form_open('', array('id' =>'form-users-groups', 'onsubmit' => 'return false')); ?>
        	<input type = "hidden" name = "user_id" id = "user_id_groups"/>
            <input type = "hidden" name = "involved_groups_ids" id = "involved_groups_ids"/>
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-xs btn-flat" id="jqxUserGroupsSubmitButton"><?php echo lang('general_save'); ?></button>
                    <button type="button" class="btn btn-default btn-xs btn-flat" id="jqxUserGroupsCancelButton"><?php echo lang('general_close'); ?></button>
                </div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                    <label>NOT INVOLVED</label>
                    <ul class="not_involved_groups" id="not_involved_groups"></ul>
                    </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    <label>INVOLVED</label>
                    <ul class="involved_groups" id="involved_groups"></ul>
                    </select>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script language="javascript" type="text/javascript">

$(function(){

	var usersDataSource =
	{
		datatype: "json",
		datafields: [
			{ name: 'id', type: 'number' },
			{ name: 'email', type: 'string' },
			{ name: 'pass', type: 'string' },
			{ name: 'username', type: 'string' },
			{ name: 'banned', type: 'bool' },
			{ name: 'last_login', type: 'date' },
			{ name: 'last_activity', type: 'date' },
			{ name: 'forgot_exp', type: 'string' },
			{ name: 'remember_time', type: 'date' },
			{ name: 'remember_exp', type: 'string' },
			{ name: 'verification_code', type: 'string' },
			{ name: 'ip_address', type: 'string' },
			{ name: 'login_attempts', type: 'number' },
			{ name: 'fullname', type: 'string' },
			
        ],
		url: '<?php echo site_url("admin/users/json"); ?>',
		pagesize: defaultPageSize,
		root: 'rows',
		id : 'id',
		cache: true,
		pager: function (pagenum, pagesize, oldpagenum) {
        	//callback called when a page or page size is changed.
        },
        beforeprocessing: function (data) {
        	usersDataSource.totalrecords = data.total;
        },
	    // update the grid and send a request to the server.
	    filter: function () {
	    	$("#jqxGridUser").jqxGrid('updatebounddata', 'filter');
	    },
	    // update the grid and send a request to the server.
	    sort: function () {
	    	$("#jqxGridUser").jqxGrid('updatebounddata', 'sort');
	    },
	    processdata: function(data) {
	    }
	};
	
	$("#jqxGridUser").jqxGrid({
		theme: theme,
		width: '100%',
		height: gridHeight,
		source: usersDataSource,
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
			container.append($('#jqxGridUserToolbar').html());
			toolbar.append(container);
		},
		columns: [
			{ text: 'SN', width: 50, pinned: true, exportable: false,  columntype: 'number', cellclassname: 'jqx-widget-header', renderer: gridColumnsRenderer, cellsrenderer: rownumberRenderer , filterable: false},
			{
				text: 'Action', datafield: 'action', width:125, sortable:false,filterable:false, pinned:true, align: 'center' , cellsalign: 'center', cellclassname: 'grid-column-center', 
				cellsrenderer: function (index) {
					var row =  $("#jqxGridUser").jqxGrid('getrowdata', index),
						e = '',
						resetPasswd='',lock ='', resetLogin='<i class="fa fa-recycle" style="color:#999"></i>',verify='<i class="fa fa-check-square" style="color:#999"></i>';

					if(row.id > '100') {

						e = '<a href="javascript:void(0)" onclick="editUserRecord(' + index + '); return false;" title="Edit"><i class="fa fa-edit"></i></a>';

						<?php /* if login attempts exceed 10, account is suspended, reset login attempts */?>
						if (row.login_attempts >= 10) {
							resetLogin = '<a href="javascript:void(0)" onclick="resetLoginAttempts(' + index + '); return false;" title="Reset Login Attemps"><i class="fa fa-recycle"></i></a>';
						}

						<?php /* if user not verified then admin can verify the user */?>
						if (row.verification_code != '' && row.verification_code != null) {
							verify = '<a href="javascript:void(0)" onclick="verifyUser(' + index + '); return false;" title="Verify"><i class="fa fa-check-square"></i></a>';
						}

						<?php /* lock/unlock user account */?>
						if (row.banned == true) {
							lock = '<a href="javascript:void(0)" onclick="toggleUser(' + index + ', \'UNLOCK\'); return false;" title="Unban/Unlock User"><i class="fa fa-circle-o"></i></a>';
						} else {
							lock = '<a href="javascript:void(0)" onclick="toggleUser(' + index + ',  \'LOCK\'); return false;" title="Ban/Lock User"><i class="fa fa-ban"></i></a>';
						}

						<?php /* reset password */ ?>
						resetPasswd = '<a href="javascript:void(0)" onclick="resetPassword(' + index + '); return false;" title="Reset Password"><i class=" fa fa-refresh"></i></a>';
						
						g = '<a href="javascript:void(0)" onclick="udpateUserGroups(' + index + '); return false;" title="Update Groups"><i class="fa fa-users"></i></a>';

						return '<div style="text-align: center; margin-top: 8px; font-size:14px">' + e + '&nbsp;'+ resetPasswd + '&nbsp;' + lock + '&nbsp;' + resetLogin + '&nbsp;' + verify + '&nbsp;' + g + '</div>';
					} else {
						return '<div style="text-align: center; margin-top: 8px;">N/A</div>';
					}
				}
			},
			{ text: '<?php echo lang("email"); ?>',datafield: 'email',width: 150,filterable: true,renderer: gridColumnsRenderer },
			{ text: '<?php echo lang("username"); ?>',datafield: 'username',width: 150,filterable: true,renderer: gridColumnsRenderer },
            { text: '<?php echo lang("fullname"); ?>',datafield: 'fullname',width: 150,filterable: true,renderer: gridColumnsRenderer },
			{ text: '<?php echo lang("banned"); ?>',datafield: 'banned',width: 75,filterable: true,renderer: gridColumnsRenderer, columntype: 'checkbox', filtertype: 'bool'},
			{ text: '<?php echo lang("last_login"); ?>',datafield: 'last_login',width: 150,filterable: true,renderer: gridColumnsRenderer, columntype: 'date', filtertype: 'range', cellsformat:  formatString_yyyy_MM_dd_HH_mm},
			{ text: '<?php echo lang("last_activity"); ?>',datafield: 'last_activity',width: 150,filterable: true,renderer: gridColumnsRenderer, columntype: 'date', filtertype: 'range', cellsformat:  formatString_yyyy_MM_dd_HH_mm},
			{ text: '<?php echo lang("last_login_attempt"); ?>',datafield: 'last_login_attempt',width: 150,filterable: true,renderer: gridColumnsRenderer, columntype: 'date', filtertype: 'range', cellsformat:  formatString_yyyy_MM_dd_HH_mm},
			{ text: '<?php echo lang("ip_address"); ?>',datafield: 'ip_address',width: 150,filterable: true,renderer: gridColumnsRenderer },
			// { text: '<?php echo lang("login_attempts"); ?>',datafield: 'login_attempts',width: 150,filterable: true,renderer: gridColumnsRenderer },
			
		],
		rendergridrows: function (result) {
			return result.data;
		}
	});

	$("[data-toggle='offcanvas']").click(function(e) {
	    e.preventDefault();
	    setTimeout(function() {$("#jqxGridUser").jqxGrid('refresh');}, 500);
	});

	$(document).on('click','#jqxGridUserFilterClear', function () { 
		$('#jqxGridUser').jqxGrid('clearfilters');
	});

	$(document).on('click','#jqxGridUserInsert', function () { 
		openPopupWindow('jqxPopupWindowUser', '<?php echo lang("general_add")  . "&nbsp;" .  $header; ?>');
    });

	// initialize the popup window
    $("#jqxPopupWindowUser").jqxWindow({ 
        theme: theme,
        width: 500,
        maxWidth: 500,
        height: 350,  
        maxHeight: 350,  
        isModal: true, 
        autoOpen: false,
        modalOpacity: 0.7,
        showCollapseButton: false 
    });

    // initialize the popup window
    $("#jqxPopupWindowUserGroups").jqxWindow({ 
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

    $("#jqxPopupWindowUser").on('close', function () {
        $('#id').val('');
        $('#form-users')[0].reset();
    });

    $("#jqxPopupWindowUserGroups").on('close', function () {
        $('#user_id_groups').val('');
        $('#form-users-groups')[0].reset();
    });

    $("#jqxUserCancelButton").on('click', function () {
        $('#id').val('');
        $('#form-users')[0].reset();
        $('#jqxPopupWindowUser').jqxWindow('close');
    });

    $("#jqxUserGroupsCancelButton").on('click', function () {
        $('#user_id_groups').val('');
        $('#form-users-groups')[0].reset();
        $('#jqxPopupWindowUserGroups').jqxWindow('close');
    });

    $('#form-users').jqxValidator({
        hintType: 'label',
        animationDuration: 500,
        rules: [
			{ input: '#username', message: 'Required', action: 'blur', rule: 'required' },
			{ input: '#username', message: 'Username must be between 5 and 25 characters!', action: 'blur', rule: 'length=5,25' },
            { input: '#username', message: 'Userame already exists', action: 'blur', 
                rule: function(input, commit) {

                    val = $("#username").val();
                    $.ajax({
                        url: "<?php echo site_url('admin/users/check_duplicate'); ?>",
                        type: 'POST',
                        data: {model: 'users/user_model', field: 'username', value: val, id:$('input#id').val()},
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
            { input: '#email', message: 'Required', action: 'blur', rule: 'required'},
            { input: '#email', message: 'Invalid Email Address', action: 'blur', rule: 'email'},
            { input: '#email', message: 'Email already exists', action: 'blur', 
                rule: function(input, commit) {

                    val = $("#email").val();
                    $.ajax({
                        url: "<?php echo site_url('admin/users/check_duplicate'); ?>",
                        type: 'POST',
                        data: {model: 'users/user_model', field: 'email', value: val, id:$('input#id').val()},
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

    $("#jqxUserSubmitButton").on('click', function () {
        
        var validationResult = function (isValid) {
                if (isValid) {
                   saveUserRecord();
                }
            };
        $('#form-users').jqxValidator('validate', validationResult);
    });

    $("#jqxUserGroupsSubmitButton").on('click', function () {
        saveUserGroupsRecord();
    });

    $(document).on('click','.not_involved_groups',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-not_involved_group_id'),
            item = '<li class="item selected-item" id="involvedgroups' + gid + '" data-involved_group_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#allgroup_" + gid).remove();
        $("#involved_groups").append(item);
    });

    $(document).on('click','.involved_groups',function(e) {
        e.preventDefault();
        var gid = $(e.target).attr('data-involved_group_id'),
            item = '<li class="item unselected-item" id="allgroup_' + gid + '" data-not_involved_group_id="' + gid + '">' + (e.target).textContent + '</li>';
        $("#involvedgroups" + gid).remove();
        $("#not_involved_groups").append(item);
    });
});

function editUserRecord(index){
    var row =  $("#jqxGridUser").jqxGrid('getrowdata', index);
  	if (row) {
        $('#id').val(row.id);
		$('#email').val(row.email);
		$('#username').val(row.username);
		$('#fullname').val(row.fullname);
		
        openPopupWindow('jqxPopupWindowUser', '<?php echo lang("general_edit")  . "&nbsp;" .  $header; ?>');
    }
}

function saveUserRecord(){
    var data = $("#form-users").serialize();
    
	$('#jqxPopupWindowUser').block({ 
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
        url: '<?php echo site_url("admin/users/save"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#id').val('');
                $('#form-users')[0].reset();
                $('#jqxGridUser').jqxGrid('updatebounddata');
                $('#jqxPopupWindowUser').jqxWindow('close');
            }
            $('#jqxPopupWindowUser').unblock();
        }
    });
}

function saveUserGroupsRecord(){
    
    $('#jqxPopupWindowUserGroups').block({ 
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

    var lists = $("#involved_groups").find("li"),
        involved_groups_ids = [];

        for (i=0; i < lists.length; i++) {
            r = lists[i],
            involved_group_id = $(r).attr('data-involved_group_id');
            involved_groups_ids.push(involved_group_id);
        }

    $("#involved_groups_ids").val(involved_groups_ids);
 
    var data = $("#form-users-groups").serialize();

    $.ajax({
        type: "POST",
        url: '<?php echo site_url("admin/users/save_user_groups"); ?>',
        data: data,
        success: function (result) {
            var result = eval('('+result+')');
            if (result.success) {
                $('#form-users-groups')[0].reset();
                alert('Saved');
            } 
            $('#jqxPopupWindowUserGroups').unblock();
        }
    });

    //$('#jqxPopupWindowUserGroups').unblock();
}

function resetLoginAttempts(index) {
	if( confirm("Are you sure to reset login attempts for this user ?") == true) {
		var row =  $("#jqxGridUser").jqxGrid('getrowdata', index);

	  	if (row) {
	  		$.ajax({
	            url: "<?php echo site_url('admin/users/reset_login_attempts'); ?>",
	            type: 'POST',
	            data: {id: row.id },
	            success: function (result) {
					var result = eval('('+result+')');
					if (result.success) {
						$('#jqxGridUser').jqxGrid('updatebounddata');
					}
	            },
	            error: function(result) {
	                return commit(false);
	            }
	        });
	  	}
	}
}

function resetPassword(index) {
	if( confirm("Are you sure to reset the password for this user ?") == true) {
		var row =  $("#jqxGridUser").jqxGrid('getrowdata', index);

	  	if (row) {
	  		$.ajax({
	            url: "<?php echo site_url('admin/users/reset_password'); ?>",
	            type: 'POST',
	            data: {id: row.id },
	            success: function (result) {
					var result = eval('('+result+')');
					if (result.success) {
						$('#jqxGridUser').jqxGrid('updatebounddata');
					}
	            },
	            error: function(result) {
	                return commit(false);
	            }
	        });
	  	}
	}
}

function toggleUser(index, toggle) {

	if( confirm("Are you sure to " + toggle + " this user ?") == true) {
		var row =  $("#jqxGridUser").jqxGrid('getrowdata', index);

	  	if (row) {
	  		$.ajax({
	            url: "<?php echo site_url('admin/users/toggle_user'); ?>",
	            type: 'POST',
	            data: {id: row.id, toggle: toggle },
	            success: function (result) {
					var result = eval('('+result+')');
					if (result.success) {
						$('#jqxGridUser').jqxGrid('updatebounddata');
					}
	            },
	            error: function(result) {
	                return commit(false);
	            }
	        });
	  	}
	}
}

function verifyUser(index) {

	if( confirm("Are you sure to verify this user ?") == true) {
		var row =  $("#jqxGridUser").jqxGrid('getrowdata', index);

	  	if (row) {
	  		$.ajax({
	            url: "<?php echo site_url('admin/users/verify_user'); ?>",
	            type: 'POST',
	            data: {id: row.id },
	            success: function (result) {
					var result = eval('('+result+')');
					if (result.success) {
						$('#jqxGridUser').jqxGrid('updatebounddata');
					}
	            },
	            error: function(result) {
	                return commit(false);
	            }
	        });
	  	}
	}
}

function udpateUserGroups(index){
    var row =  $("#jqxGridUser").jqxGrid('getrowdata', index);
  	
    if (row) {
        
        $('#user_id_groups').val(row.id); 
        msg = '<?php echo lang('permission_users'); ?>';
        $('#window_poptup_title_group').html('Add User to Groups');
        openPopupWindow('jqxPopupWindowUserGroups', 'N/A');  
        
        $('#jqxPopupWindowUserGroups').block({ 
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
            url: "<?php echo site_url('admin/users/get_user_groups'); ?>",
            type: 'POST',
            data: {id:row.id},
            success: function (results) {
               $('#jqxPopupWindowUserGroups').unblock();

                var results = eval('('+results+')'),
                involved_groups = results.involved_groups,
                not_involved_groups = results.not_involved_groups;

                if(results.not_involved_groups.length < 1) {
                    $("#not_involved_groups").empty();
                    return;
                }
                $("#not_involved_groups").empty();
                $.each(not_involved_groups,function(index,group) {
                    var i = $.inArray(parseInt(group.id),not_involved_groups);
                    if(i == -1) {
                        var item = '<li class="item unselected-item" id="allgroup_' + group.id + '" data-not_involved_group_id="' + group.id + '">' + group.group_name + '</li>';

                        $("#not_involved_groups").append(item);
                    }
                });

                if(results.involved_groups.length < 1) {
                    $("#involved_groups").empty();
                    return;
                }
                $("#involved_groups").empty();
                $.each(involved_groups,function(index,group) {
                    var i = $.inArray(parseInt(group.group_id),involved_groups);
                    if(i == -1) {
                        var item = '<li class="item selected-item" id="involvedgroups' + group.group_id + '" data-involved_group_id="' + group.group_id + '">' + group.group_name + '</li>';
                        $("#involved_groups").append(item);
                    }
                });
            }
        });
    }
}
</script>