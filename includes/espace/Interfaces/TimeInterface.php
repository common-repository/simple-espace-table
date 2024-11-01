<?php 

namespace Espace\Interfaces;

interface TimeInterface {
	/**
	 * Get time in proper format
	 * @return date format [Y-m-d H:i:s a]
	 */
	public function getTime();

	/**
	 * Get time in strict time format
	 * @example : [20180808T080000]
	 * @return  [YmdTHis]
	 */
	public function getTimeStrict();

	/**
	 * Get time in format specified
	 * @param $timeFormat string
	 * @return  [entered format]
	 */
	public function getTimeFormat($timeFormat);
}