<?php 

namespace Espace\Interfaces;

use Espace\Interfaces\TimeInterface;

interface CalendarBuilderInterface {
	/**
	 * Set title for the calendar event
	 * @param $title [string]
	 * @return self
	 */
	public function setTitle($title);

	/**
	 * Set text for the calendar event
	 * @param $text [string]
	 * @return self
	 */
	public function setText($text);

	/**
	 * Set start date for the calendar event
	 * @param $date [TimeInterface]
	 * @return self
	 */
	public function setStartDate(TimeInterface $date);

	/**
	 * Set end date for the calendar event
	 * @param $date [TimeInterface]
	 * @return self
	 */
	public function setEndDate(TimeInterface $date);

	/**
	 * Get the built url from parameters
	 * @return string
	 */
	public function getCalendarURL();
}