<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PROJECT
 *
 * @package         PROJECT
 * @author          <AUTHOR_NAME>
 * @copyright       Copyright (c) 2016
 */

// ---------------------------------------------------------------------------


if ( ! function_exists('paging'))
{
	function paging($default, $order = 'desc')
	{
		$CI = &get_instance();

		$input = $CI->input->get();
		
		$pagenum  = (isset($input['pagenum'])) ? $input['pagenum'] : 0;
		
		$pagesize  = (isset($input['pagesize'])) ? $input['pagesize'] : 100;
		
		$offset = $pagenum * $pagesize;

		$CI->db->limit($pagesize, $offset);

		//sorting
		if (isset($input['sortdatafield'])) {
			$sortdatafield = $input['sortdatafield'];
			$sortorder = (isset($input['sortorder'])) ? $input['sortorder'] :'asc';
			$CI->db->order_by($sortdatafield, $sortorder); 
		} else {
			$CI->db->order_by($default, $order);
		}
		
	}
}

if ( ! function_exists('search_params'))
{
	function search_params()
	{
		$CI = &get_instance();

		$input = $CI->input->get();

		if (isset($input['filterscount'])) {
			$filtersCount = $input['filterscount'];
			if ($filtersCount > 0) {
				for ($i=0; $i < $filtersCount; $i++) {
					// get the filter's column.
					$filterDatafield 	= $input['filterdatafield' . $i];

					// get the filter's value.
					$filterValue 		=  $input['filtervalue' 	. $i];

					// get the filter's condition.
					$filterCondition 	= $input['filtercondition' . $i];

					// get the filter's operator.
					$filterOperator 	= $input['filteroperator' 	. $i];

					$operatorLike = 'LIKE';

					switch($filterCondition) {
						case "CONTAINS":
                            if (strtoupper($filterValue) == 'BLANK') {
                                // $CI->db->where("{$filterDatafield} IS EMPTY", null, false);
                            } else if(strtoupper($filterValue) == 'NULL') {
                                $CI->db->where("{$filterDatafield} IS NULL", null, false);
                            } else {
                                $CI->db->like($filterDatafield, $filterValue);
                            }
							break;
						case "DOES_NOT_CONTAIN":
							$CI->db->inot_like($filterDatafield, $filterValue);
							break;
						case "EQUAL":
							$CI->db->where($filterDatafield, $filterValue);
							break;
						case "GREATER_THAN":
							$CI->db->where($filterDatafield . ' >', $filterValue);
							break;
						case "LESS_THAN":
							$CI->db->where($filterDatafield . ' <', $filterValue);
							break;
						case "GREATER_THAN_OR_EQUAL":
							$CI->db->where($filterDatafield . ' >=', $filterValue);
							break;
						case "LESS_THAN_OR_EQUAL":
							$CI->db->where($filterDatafield . ' <=', $filterValue);
							break;
						case "STARTS_WITH":
							$CI->db->like($filterDatafield, $filterValue, 'after'); 
							break;
						case "ENDS_WITH":
							$CI->db->like($filterDatafield, $filterValue, 'before'); 
							break;
					}
				}
			}
		}
	}
}

function displayStatus(){
	
}

/* End of file project_helper.php */
/* Location: ./application/helpers/project_helper.php */