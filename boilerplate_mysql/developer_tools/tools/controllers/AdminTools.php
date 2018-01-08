<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class AdminTools extends Admin_Controller
{
	var $table_name = '';
	var $prefix;
	var $table_columns = NULL;
	var $module_path = 'gen-modules';
	var $module_name;
	var $languages = array();
	var $discard = array();

	var $filelist = array();

	public function __construct()
	{
		parent::__construct();
		set_time_limit(0);
	}

	public function index()
	{
		$tables = array();
		$core_tables = $this->_get_core_tables();

		foreach($this->db->list_tables() as $table) {
			if (!in_array($table, $core_tables)) {
				array_push($tables, $table);
			}
		}

		$data['tables'] = $tables;
		$data['header'] = 'Module Generator';
		$data['page'] = $this->config->item('template_admin')  . 'mgenerator/index';
		$data['module'] = 'tools';
	
		$this->load->view($this->_container, $data);				
	}

	private function _get_core_tables()
	{
		$tables = array();

		$tables[] = 'be_acl_actions';
		$tables[] = 'be_acl_groups';
		$tables[] = 'be_acl_permission_actions';
		$tables[] = 'be_acl_permissions';
		$tables[] = 'be_acl_resources';
		$tables[] = 'be_groups';
		$tables[] = 'be_acl_actions';
		$tables[] = 'be_preferences';
		$tables[] = 'be_resources';
		$tables[] = 'be_shortcuts';
		$tables[] = 'be_user_profiles';
		$tables[] = 'be_users';	
		$tables[] = 'be_backups';	
		$tables[] = 'ci_sessions';	
		$tables[] = 'layouts';	
		$tables[] = 'pages';	
		$tables[] = 'settings';	
		$tables[] = 'slugs';										
		
		return $tables;
	}

	private function _get_primary_key()
	{
		return 'id';
		/*foreach($this->table_columns as $column) {
			if ($column->primary_key) {
				return $column->name;
			}
		}*/
	}

	public function getFields()
	{
		$tableName = $this->input->post('table');
		$columns = $this->db->field_data($tableName);	
		$fields = array();
		foreach ($columns as $column) {
			$fields[] = $column->name;
		}
		echo implode(",", $fields);
		exit;
	}
		
	public function generate()
	{
		$this->load->library('parser');
		$this->load->helper('inflector');	
		$this->load->helper('file');
		$this->load->helper('tools/code_snippet');		

		$data['module'] = 'tools';

		$this->prefix = trim($this->input->post('prefix'));	
		
		$this->discard = explode(',', $this->input->post('discard'));
		
		foreach($this->input->post('tables') as $table) {

			$this->filelist = array();

			$this->table_name = preg_replace('/' . $this->prefix . '/', '', $table, 1);

			$this->table_columns = $this->db->field_data($table);	

			$this->function_init = str_replace(' ', '', humanize(plural(ucfirst($this->table_name))));	

			$this->table_key = singular(strtoupper($this->table_name));
			
			$controller = ucfirst(singular($this->table_name));
			
			$this->module_name = strtolower($controller);
			
			$this->_create_directories();

			$this->_generate_model_file($this->module_name);
			
			$this->_generate_language_file($this->module_name);
			
			$this->_generate_controller_file($this->module_name);
			
			//$this->_generate_api_controller_file($this->module_name);			

			$primary_key = $this->_get_primary_key();	
			
			$upload_view_function = '';
			
			foreach($this->table_columns as $row) {
				if (preg_match('/image/', $row->name, $match)) {
					$upload_view_function = view_upload_code($this->module_name, $row->name);
				}
			}

			$view_array = array(
							'PHP_START'				=> '<?php ', 
							'PHP_END'				=> '?>', 
							'PREFIX'				=> $this->prefix,
							'VIEWTABLE'				=> $this->module_name, 
							'TABLE_FIELDS'			=> $this->_generate_view_fields($this->table_columns), 
							'PRIMARY_KEY'			=> $primary_key, 
							'FORMFIELDS'			=> $this->_generate_form_fields($this->table_columns, $primary_key), 
							//'SEARCH_FIELDS'			=> $this->_generate_search_fields($this->table_columns), 
							'EDITFIELDS'			=> $this->_generate_edit_fields($this->table_columns), 
							'VALIDATION_RULES'		=> $this->_generate_validation_rules($this->table_columns), 
							'DATAFIELDS'			=> $this->_generate_data_fields($this->table_columns), 
							'COLUMN_FIELDS'			=> $this->_generate_column_fields($this->table_columns), 
							//'UPLOAD_VIEW_FUNCTION'	=> $upload_view_function, 
							'TABLE_NAME' 			=> $table,
							'MODULE'				=> plural($this->module_name),
							'BREADCRUMB'			=> plural($this->module_name),
							'MODULE_TITLE' 			=> ucfirst($this->module_name), 
							'MODULE_UCFIRST' 		=> humanize(plural($this->module_name)), 
						);

			$admin_view_data = $this->parser->parse('templates/admin_view.tpl', $view_array, TRUE);
			 //$admin_view_data = $this->parser->parse('templates/admin_view_mst.tpl', $view_array, TRUE); // for common master

			$admin_view_file = $this->view_admin_directory . 'index.php';
			// $admin_view_file = $this->view_admin_directory . 'partial_' . plural($this->module_name) . '.php'; //for common master
			
			write_file($admin_view_file, $admin_view_data);
			
			$this->filelist[] = $admin_view_file;

			$public_view_data = $this->parser->parse('templates/public_view.tpl', $view_array, TRUE);

			$public_view_file = $this->view_public_directory . 'index.php';
			
			write_file($public_view_file, $public_view_data);
			
			$this->filelist[] = $public_view_file;

			echo '<b>' . strtoupper($this->module_name) . '</b><ul><li>';
			echo implode('</li><li>', $this->filelist);
			echo '</li></ul>';
			
		}
		exit;
	}

	private function _generate_edit_fields($fields)	
	{
		$cols = '';
		$module = plural($this->module_name);
		
		foreach($fields as $row) {

			if (in_array($row->name, $this->discard))
				continue;
			if ($row->name == 'id') 
				continue;


			$name = $row->name;
			$id   = ($row->name == 'name' || $row->name == 'rank') ? "{$module}_{$row->name}" : $row->name;	

			$type = $row->type;	
			$class = "$('#{$id}').val(row.{$name});\r\n\t\t";

			if ($type == 'datetime') {
				$class = "$('#{$id}').jqxDateTimeInput('setDate', row.{$name});\r\n\t\t";
			} elseif ($type == 'date') {
				$class = "$('#{$id}').jqxDateTimeInput('setDate', row.{$name});\r\n\t\t";
			} elseif (preg_match('/int/is', $type, $matches) ) {
				$class = "$('#{$id}').jqxNumberInput('val', row.{$name});\r\n\t\t";
			}

			$cols .= $class;
		}


		return $cols;	
	}


	private function _generate_validation_rules($fields)	
	{
		$cols = '';
		$module = plural($this->module_name);
		
		foreach($fields as $row) {

			if (in_array($row->name, $this->discard))
				continue;

			if ($row->name == 'id') 
				continue;


			$name = $row->name;
			$id   = ($row->name == 'name' || $row->name == 'rank') ? "{$module}_{$row->name}" : $row->name;	


			/*if ($row->primary_key == '1')
				continue;
			*/
			$type = $row->type;	
			$rule = "\r\n\t\t\t{ input: '#{$id}', message: 'Required', action: 'blur', 
	\t\t\trule: function(input) {
		\t\t\tval = $('#{$id}').val();
		\t\t\treturn (val == '' || val == null || val == 0) ? false: true;
	\t\t\t}
\t\t\t},\r\n";

			if ($type == 'datetime' || $type == 'date') {
				continue;
			} elseif (preg_match('/int/is', $type, $matches)) {
							$rule = "\r\n\t\t\t{ input: '#{$id}', message: 'Required', action: 'blur', 
	\t\t\trule: function(input) {
		\t\t\tval = $('#{$id}').jqxNumberInput('val');
		\t\t\treturn (val == '' || val == null || val == 0) ? false: true;
	\t\t\t}
\t\t\t},\r\n";
			}

			$cols .= $rule;
		}


		return $cols;	
	}

	private function _generate_data_fields($fields)	
	{
		$cols = '';

		
		
		foreach($fields as $row) {

			$type = $row->type;
			$class = 'string';

			if ($type == 'datetime') {
				$class = 'date';
			} elseif ($type == 'date') {
				$class = 'date';
			} elseif ($type == 'timestamp') {
				$class = 'date';
			} elseif (preg_match('/int/is', $type, $matches)) {
				$class = 'number';
			}


			$cols .= "{ name: '{$row->name}', type: '{$class}' },\r\n\t\t\t";
		}


		return $cols;	
	}

	private function _generate_column_fields($fields)	
	{
		$cols = '';
		
		foreach($fields as $row) {

			if (in_array($row->name, $this->discard))
				continue;

			// if ($row->primary_key == '1')
			// 	continue;

			$type = $row->type;
			$c = "{ text: '<?php echo lang(\"{$row->name}\"); ?>',datafield: '{$row->name}',width: 150,filterable: true,renderer: gridColumnsRenderer },\r\n\t\t\t";

			if ($type == 'datetime' || $type == 'date') {
				$c = "{ text: '<?php echo lang(\"{$row->name}\"); ?>',datafield: '{$row->name}',width: 150,filterable: true,renderer: gridColumnsRenderer, columntype: 'date', filtertype: 'range', cellsformat:  formatString_yyyy_MM_dd},\r\n\t\t\t";
			}

			$cols .= $c;
		}


		return $cols;	
	}

	private function _generate_controller_file($file)
	{
		$upload_path 			= '';
		$upload_function 		= '';	
		$upload_view_function 	= '';
		$datewise_function 		= '';

		foreach($this->table_columns as $row) {
			if (preg_match('/image/', $row->name, $match)) {
				$upload_path = set_upload_path($file);	
				$upload_function = upload_controller_method();	
				$upload_view_function = view_upload_code($file, $row->name);
			} else if (preg_match('/date/', $row->name, $match)) {
				$datewise_function = datewise();
			}
		}

		$primary_key 	  = $this->_get_primary_key();		
		$controller 	  = ucfirst(singular($this->table_name));
		$controller_array = array(
								'PHP_TAG' => '<?php', 
								'CONTROLLER' => $controller, 
								'MODULE' => plural($this->module_name), 
								'MODULE_UCFIRST' => humanize(plural($file)), 
								'PRIMARY_KEY' => $primary_key, 
								'FOLDER' => $file, 
								'MODEL' => $file . "_model", 
								'TABLE_NAME' => $this->function_init, 
								'TABLE_ALIAS' 	=> plural($this->table_name),
								'LANG' => $file, 
								'POSTED_DATA' => $this->_generate_posted_data($this->table_columns), 
								'TABLE_KEY' => $this->table_key, 
								'UPLOAD_PATH' => $upload_path, 
								'UPLOAD_FUNCTION' => $upload_function, 
								'SEARCH_PARAMS' => $this->_generate_search_params($this->table_columns), 
								'DATE_SEARCH_PARAMS' => $this->_generate_date_search_params($this->table_columns), 
								'DATEWISE_FUNCTION' => $datewise_function,
								'CONTROLLER_NAME' => ucfirst(plural($this->module_name))
							);

		$admin_controller_data = $this->parser->parse('templates/admin_controller.tpl', $controller_array, TRUE);
		$public_controller_data = $this->parser->parse('templates/public_controller.tpl', $controller_array, TRUE);

		//$controller_file = $this->controller_admin_directory . $file . '.php';
		// $public_controller_file  = $this->controller_directory . $file . '.php';
		// write_file($public_controller_file, $public_controller_data);

		$admin_controller_file  = $this->controller_directory . 'Admin' . ucfirst(plural($this->module_name)) . '.php';
		write_file($admin_controller_file, $admin_controller_data);

		$public_controller_file  = $this->controller_directory . ucfirst(plural($this->module_name)) . '.php';
		write_file($public_controller_file, $public_controller_data);


		$this->filelist[] = $admin_controller_file;			
		// $this->filelist[] = $public_controller_file;			
	}

	private function _generate_api_controller_file($file)
	{
		$controller       = ucfirst(singular($this->table_name));
		$controller_array = array(
								'PHP_TAG' => '<?php', 
								'MODULE' => $this->module_name, 
								'MODEL' => $file . "_model", 
								'TABLE_NAME' => $this->function_init
							);

		$controller_data = $this->parser->parse('templates/api_controller.tpl', $controller_array, TRUE);

		$controller_file = $this->controller_directory . 'api.php';
		
		write_file($controller_file, $controller_data);
		
		$this->filelist[] = $controller_file;			
	}	

	private function _create_directories()
	{
		$module_directory = $this->module_path . '/' . plural($this->module_name);
	
		$dataArray = array(
						'PHP_TAG' => '<?php', 
						'FILE' => ucfirst($this->module_name));

		@mkdir($module_directory); // Create Main Module Directory
		
		// Create Config Folder
		$this->config_directory = $module_directory . '/config/';
		@mkdir($this->config_directory);
		$data = $this->parser->parse('templates/routes.tpl', $dataArray, TRUE); 
		$file = $this->config_directory . 'routes.generated.php';
		write_file($file, $data);
		$this->filelist[] = $file;

		// Create Controller Folder
		$this->controller_directory = $module_directory . '/controllers/';
		@mkdir($this->controller_directory); 

		// Create Helpers Folder
		$this->helpers_directory = $module_directory . '/helpers/';
		@mkdir($this->helpers_directory); 
		$data = $this->parser->parse('templates/helper.tpl', $dataArray, TRUE); 
		$file = $this->helpers_directory . $this->module_name . '_helper.generated.php';
		write_file($file, $data);
		$this->filelist[] = $file;
		
		// Create Language Folder
		$this->language_directory = $module_directory . '/language/';
		@mkdir($this->language_directory);	

		$this->languages = $this->input->post('language');
		$other_language = $this->input->post('other_language');
		
		if ($other_language) {
			$other = explode(', ', $other_language);
			$this->languages = array_merge($this->languages, $other);
		}

		foreach($this->languages as $lang) {
			$language_path = $this->language_directory . $lang . '/';
			@mkdir($language_path);	// Create language Folder	
		}

		// Create Libraries Folder
		$this->library_directory = $module_directory . '/libraries/';
		@mkdir($this->library_directory); 
		$data = $this->parser->parse('templates/library.tpl', $dataArray, TRUE); 
		$file = $this->library_directory . ucfirst($this->module_name) . '.generated.php';
		write_file($file, $data);
		$this->filelist[] = $file;
		
		// Create Model Folder
		$this->model_directory = $module_directory . '/models/';
		@mkdir($this->model_directory); 
		
		// Create View Folder
		$this->view_directory = $module_directory . '/views/';
		@mkdir($this->view_directory);	

		$this->view_admin_directory =  $this->view_directory . 'admin/';
		@mkdir($this->view_admin_directory);	

		$this->view_public_directory = $this->view_directory . 'public/';
		@mkdir($this->view_public_directory);	
		
	}	

	private function _generate_model_file($file)
	{
		$table_array =	array(
							'PHP_TAG' 		=> '<?php', 
							'MODEL' 		=> ucfirst($file), 
							'TABLE_KEY' 	=> $this->table_key, 
							'TABLE_NAME' 	=> $this->table_name, 
							'FUNCTION_INIT' => $this->function_init, 
							'PREFIX' 		=> $this->prefix, 
							'TABLE_ALIAS' 	=> plural($this->table_name)
						);

		$model_data = $this->parser->parse('templates/model.tpl', $table_array, TRUE);
		
		$model_file = $this->model_directory . ucfirst($file) . '_model.php';
		
		write_file($model_file, $model_data);
		
		$this->filelist[] = $model_file;		
	}

	private function _generate_language_file($file)
	{
		$file_name = ucfirst(singular($this->table_name));
		
		$lang = $this->_generate_language_fields($this->table_columns);
		
		$lang_array  =	array(
							'PHP_TAG' 			=> '<?php', 
							'LANG' 				=> $lang, 
							'TABLE_NAME' 		=> plural($file), 
							'CAP_TABLE_NAME' 	=> humanize(plural($file_name))
						);
		
		$lang_data  = $this->parser->parse('templates/language.tpl', $lang_array, TRUE);

		foreach($this->languages as $lang) {
			$new_lang_path = $this->language_directory . trim($lang) . '/'; 
			$lang_file = $new_lang_path . $file . '_lang.php';
			write_file($lang_file, $lang_data);
			$this->filelist[] = $lang_file;
		}

	}

	private function _generate_language_fields($fields)
	{
		$lang = '';
		
		foreach($fields as $field) {
			$lang = $lang . "\$lang['" . $field->name . "'] = '" . humanize($field->name) . "';\r\n";
		}
		
		return $lang;
	}

	private function _generate_posted_data($fields)
	{
		$cols = '';

		foreach($fields as $row) {
			// if ( ($this->input->post('discard_post') && !in_array($row->name, $this->discard)) || 
			// 	(in_array($row->name, $this->discard) && !$this->input->post('discard_post')) || 
			// 	(!$this->input->post('discard_post') && !in_array($row->name, $this->discard)) 
			// 	) {
			// 	$cols = $cols . "\t\t\$data['" . $row->name . "'] = \$this->input->post('" . $row->name . "');\r\n";
			// }

			if (in_array($row->name, $this->discard))
				continue;
			if ($row->name == 'id') 
				continue;

			$cols = $cols . "\t\t\$data['" . $row->name . "'] = \$this->input->post('" . $row->name . "');\r\n";
		}

		return $cols;
	}

	private function _generate_search_params($fields)
	{
		$cols = '';

		foreach($fields as $row) {
			if (!in_array($row->name, $this->discard)) {
				if (!preg_match('/text/is', $row->type, $match) && !preg_match('/image/is', $row->name, $match)) {
					if (preg_match('/tinyint/', $row->type, $match)) {
						$cols = $cols . "(isset(\$params['search']['" . $row->name . "']))?\$this->db->where('" . $row->name . "', \$params['search']['" . $row->name . "']):'';\r\n";		
					} else if (preg_match('/int/', $row->type, $match)) {
						$cols = $cols . "(\$params['search']['" . $row->name . "'] != '')?\$this->db->where('" . $row->name . "', \$params['search']['" . $row->name . "']):'';\r\n";						
					} else if (!preg_match('/date/', $row->type, $match)) {
						$cols = $cols . "(\$params['search']['" . $row->name . "'] != '')?\$this->db->like('" . $row->name . "', \$params['search']['" . $row->name . "']):'';\r\n";
					}

				}
			}
		}

		return $cols;	
	}	

	private function _generate_date_search_params($fields)
	{
		$str = "if (!empty(\$params['date'])) {
			foreach(\$params['date'] as \$key => \$value){
				\$this->_datewise(\$key, \$value['from'], \$value['to']);	
			}
		}";

		return $str;	
	}	

	private function _generate_view_fields($fields)
	{
		$cols = '';
		
		foreach($fields as $row) {
			if (
				($this->input->post('discard_grid') && !in_array($row->name, $this->discard)) || 
				(in_array($row->name, $this->discard) && !$this->input->post('discard_grid')) || 
				(!$this->input->post('discard_grid') && !in_array($row->name, $this->discard)) ) {
				
					if (strpos($row->name, 'status') !== FALSE ||strpos($row->name, 'active') !== FALSE) {
						$cols = $cols . "<th data-options = \"field:'" . $row->name . "', sortable:true, formatter:formatStatus\" width = \"30\" align = \"center\"><?php echo lang('" . $row->name . "')?></th>\r\n";
					} else {
						//if ($row->primary_key == '1') {
						//	$cols = $cols . "<th data-options = \"field:'" . $row->name . "', sortable:true\" width = \"30\"><?php echo lang('" . $row->name . "')?</th>\r\n";
						// } else if (!preg_match('/text/is', $row->type, $match)) {
							$cols = $cols . "<th data-options = \"field:'" . $row->name . "', sortable:true\" width = \"50\"><?php echo lang('" . $row->name . "')?></th>\r\n";
						//}
					}
				}
		}
		
		return $cols;
	}	

	private function _generate_search_fields($fields)
	{
		$cols = '<tr>';
		
		$i = 2;
		
		foreach($fields as $row) {
			if ($row->primary_key != '1' ) {
				if (($this->input->post('discard_search') && !in_array($row->name, $this->discard)) || 
					(in_array($row->name, $this->discard) && !$this->input->post('discard_search')) || 
					(!$this->input->post('discard_search') && !in_array($row->name, $this->discard))) {

					if (!preg_match('/text/is', $row->type, $match) && !preg_match('/image/is', $row->name, $match)) {
						$cols = $cols . "<td><label><?php echo lang('" . $row->name . "')?></label>:</td>\r\n";
						
						if (preg_match('/date/', $row->type, $match)){
							$cols = $cols . "<td><input type = \"text\" name = \"date[" . $row->name . "][from]\" id = \"search_" . $row->name . "_from\" class = \"easyui-datebox\"/> ~ <input type = \"text\" name = \"date[" . $row->name . "][to]\" id = \"search_" . $row->name . "_to\" class = \"easyui-datebox\"/></td>\r\n";							
						} else if (!preg_match('/tinyint/', $row->type, $match)){
							$cols = $cols . "<td><input type = \"text\" name = \"search[" . $row->name . "]\" id = \"search_" . $row->name . "\" class = \"" . $this->_field_class($row->type) . "\"/></td>\r\n";	
						} else {
							$cols = $cols . "<td><input type = \"radio\" name = \"search[" . $row->name . "]\" id = \"search_" . $row->name . "1\" value = \"1\"/><?php  lang('general_yes')?>
							<input type = \"radio\" name = \"search[" . $row->name . "]\" id = \"search_" . $row->name . "0\" value = \"0\"/><?php echo lang('general_no')?></td>\r\n";	
						}
						
						if (($i%4) == 0) {
							$cols = $cols . "</tr>\r\n<tr>\r\n";
						}

						//echo $i = $i+2;	
					}
				}
			} // if ! primary key
		}

		$cols = $cols . '</tr>';	

		return $cols;	
	}

	private function _generate_form_fields($fields, $primary_key)
	{
		$cols = '';
		$module = plural($this->module_name);

		foreach($fields as $row) {
			if ($row->name != $primary_key && !in_array($row->name, $this->discard)) {

				$name = $row->name;
				$id   = ($row->name == 'name' || $row->name == 'rank') ? "{$module}_{$row->name}" : $row->name;
				$mandatory   = ($row->name == 'name' || $row->name == 'rank') ? "<span class='mandatory'>*</span>" : '';

						$type = $row->type;	
						$class = "\r\n\t\t\t\t\t<td><input id='{$id}' class='text_input' name='{$name}'></td>";

						if ($type == 'datetime') {
							$class = "\r\n\t\t\t\t\t<td><div id='{$id}' class='date_box' name='{$name}'></div></td>";
						} elseif ($type == 'date') {
							$class = "\r\n\t\t\t\t\t<td><div id='{$id}' class='date_box' name='{$name}'></div></td>";
						} elseif (preg_match('/int/is', $type, $matches)) {
							$class = "\r\n\t\t\t\t\t<td><div id='{$id}' class='number_general' name='{$name}'></div></td>";
						}

						$cols .= "\r\n\t\t\t\t<tr>";
						$cols .= "\r\n\t\t\t\t\t<td><label for='{$id}'><?php echo lang('{$name}')?>{$mandatory}</label></td>";
						$cols .= $class;
						$cols .= "\r\n\t\t\t\t</tr>";

						/*

						$cols = $cols . '<tr>
						<td width = "34%" ><label><?php echo lang(\'%%FIELD%%\')?>:</label></td>
						<td width = "66%">';

						$field = 	'<input name = "%%FIELD%%" id = "%%FIELD%%" class = "' . $this->_field_class($row->type) . '" required = "true">';


						if (preg_match('/image/', $row->name, $match))
						{
							$field = 	'<label id = "upload_image_name" style = "display:none"></label>
							<input name = "%%FIELD%%" id = "%%FIELD%%" type = "text" style = "display:none"/>
							<input type = "file" id = "upload_image" name = "userfile" style = "display:block"/>
							<a href = "#" id = "change-image" title = "Delete" style = "display:none"><img src = "<? = base_url()?>assets/icons/delete . png" border = "0"/></a>';	
						}

						if (preg_match('/text/', $row->type, $match))
						{
							$field = '<textarea name = "%%FIELD%%" id = "%%FIELD%%" class = "' . $this->_field_class($row->type) . '" required = "true" style = "width:300px;height:100px"></textarea>';
						} elseif (preg_match('/tinyint/', $row->type, $match)) {
							$field = 	'<input type = "radio" value = "1" name = "%%FIELD%%" id = "%%FIELD%%1" /><?php echo lang("general_yes")?> <input type = "radio" value = "0" name = "%%FIELD%%" id = "%%FIELD%%0" /><?php echo lang("general_no")?>';				
						}

						$cols   .= $field;


						$cols   .= '</td></tr>'; 	
						$cols = str_replace('%%FIELD%%', $row->name, $cols);

						*/
				
			}
		}
		
		//$cols = $cols . '<input type = "hidden" name = "' . $primary_key . '" id = "' . $primary_key . '"/>';

		return $cols;		
	}		

	private function _field_class($type)
	{
		$class = 'easyui-validatebox';
		
		if ($type == 'datetime') {
			$class = 'easyui-datetimebox';
		} elseif ($type == 'date') {
			$class = 'easyui-datebox';
		} elseif (preg_match('/int/is', $type, $matches)) {
			$class = 'easyui-numberbox';
		}

		return $class;
	}
}