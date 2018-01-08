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
* MY_DB_pdo_pgsql_driver
*
* Extends the CI_DB_pdo_pgsql_driver class
* 
*/
class MY_DB_pdo_pgsql_driver extends CI_DB_pdo_pgsql_driver {


	public function __construct($params)
	{
		parent::__construct($params);
		log_message('debug', 'Extended DB driver class instantiated!');
	}

	/**
	 * ILIKE
	 *
	 * Generates a %ILIKE% portion of the query.
	 * Separates multiple calls with 'AND'.
	 *
	 * @param	mixed	$field
	 * @param	string	$match
	 * @param	string	$side
	 * @param	bool	$escape
	 * @return	CI_DB_query_builder
	 */
	public function ilike($field, $match = '', $side = 'both', $escape = NULL)
	{
		return $this->_ilike($field, $match, 'AND ', $side, '', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * NOT ILIKE
	 *
	 * Generates a NOT ILIKE portion of the query.
	 * Separates multiple calls with 'AND'.
	 *
	 * @param	mixed	$field
	 * @param	string	$match
	 * @param	string	$side
	 * @param	bool	$escape
	 * @return	CI_DB_query_builder
	 */
	public function not_ilike($field, $match = '', $side = 'both', $escape = NULL)
	{
		return $this->_ilike($field, $match, 'AND ', $side, 'NOT', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * OR ILIKE
	 *
	 * Generates a %ILIKE% portion of the query.
	 * Separates multiple calls with 'OR'.
	 *
	 * @param	mixed	$field
	 * @param	string	$match
	 * @param	string	$side
	 * @param	bool	$escape
	 * @return	CI_DB_query_builder
	 */
	public function or_ilike($field, $match = '', $side = 'both', $escape = NULL)
	{
		return $this->_ilike($field, $match, 'OR ', $side, '', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * OR NOT ILIKE
	 *
	 * Generates a NOT ILIKE portion of the query.
	 * Separates multiple calls with 'OR'.
	 *
	 * @param	mixed	$field
	 * @param	string	$match
	 * @param	string	$side
	 * @param	bool	$escape
	 * @return	CI_DB_query_builder
	 */
	public function or_not_ilike($field, $match = '', $side = 'both', $escape = NULL)
	{
		return $this->_ilike($field, $match, 'OR ', $side, 'NOT', $escape);
	}

	// --------------------------------------------------------------------

	/**
	 * Internal ILIKE
	 *
	 * @used-by	ilike()
	 * @used-by	or_ilike()
	 * @used-by	not_ilike()
	 * @used-by	or_not_ilike()
	 *
	 * @param	mixed	$field
	 * @param	string	$match
	 * @param	string	$type
	 * @param	string	$side
	 * @param	string	$not
	 * @param	bool	$escape
	 * @return	CI_DB_query_builder
	 */
	protected function _ilike($field, $match = '', $type = 'AND ', $side = 'both', $not = '', $escape = NULL)
	{
		if ( ! is_array($field))
		{
			$field = array($field => $match);
		}

		is_bool($escape) OR $escape = $this->_protect_identifiers;

		foreach ($field as $k => $v)
		{
			$prefix = (count($this->qb_where) === 0 && count($this->qb_cache_where) === 0)
			? $this->_group_get_type('') : $this->_group_get_type($type);

			$v = $this->escape_like_str($v);

			if ($side === 'none')
			{
				$like_statement = "{$prefix} {$k} {$not} ILIKE '{$v}'";
			}
			elseif ($side === 'before')
			{
				$like_statement = "{$prefix} {$k} {$not} ILIKE '%{$v}'";
			}
			elseif ($side === 'after')
			{
				$like_statement = "{$prefix} {$k} {$not} ILIKE '{$v}%'";
			}
			else
			{
				$like_statement = "{$prefix} {$k} {$not} ILIKE '%{$v}%'";
			}

			// some platforms require an escape sequence definition for ILIKE wildcards
			if ($this->_like_escape_str !== '')
			{
				$like_statement .= sprintf($this->_like_escape_str, $this->_like_escape_chr);
			}

			$this->qb_where[] = array('condition' => $like_statement, 'escape' => $escape);
			if ($this->qb_caching === TRUE)
			{
				$this->qb_cache_where[] = array('condition' => $like_statement, 'escape' => $escape);
				$this->qb_cache_exists[] = 'where';
			}
		}

		return $this;
	}
}

/* End of file MY_DB_pdo_pgsql_driver.php */
/* Location: ./application/libraries/MY_DB_pdo_pgsql_driver.php */
