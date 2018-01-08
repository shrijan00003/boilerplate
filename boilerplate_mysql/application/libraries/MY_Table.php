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

/**
* MY_Table
*
* Extends the CI_Table class
* 
*/
class MY_Table extends CI_Table
{
	protected function _set_from_array($data)
	{

		if ($this->auto_heading === TRUE && empty($this->heading))
		{
			$this->heading = $this->_prep_args(array_shift($data));
		}

		foreach ($data as &$row)
		{
			$rearranged = array();
			//rearrange as per heading
			if (!empty($this->heading)) {
				foreach($this->heading as $head) {
					$index = $head['data'];
					$rearranged[$index] = (isset($row[$index])) ? $row[$index] : '-';
				}
			} else {
				$rearranged = $row;
			}
			$this->rows[] = $this->_prep_args($rearranged);
		}
	}
}

/* End of file MY_Table.php */
/* Location: ./application/libraries/MY_Table.php */
