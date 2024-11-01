<?php

namespace Espace\Builders;

use Espace\Interfaces\CalendarBuilderInterface;
use Espace\Interfaces\TimeInterface;

class GoogleCalendarBuilder implements CalendarBuilderInterface {
	const GOOGLE_CALENDAR_URL = 'https://www.google.com/calendar/event?';

	// members
	protected $queryParams = [];
	protected $dates = [];

	public function __construct() {
		$this->queryParams['action'] = 'TEMPLATE';
	}

	public function setTitle($title) {
		if (!$title) {
			return $this;
		}

		$this->queryParams['text'] = esc_attr($title);

		return $this;
	}

	public function setText($text) {
		if (!$text) {
			return $this;
		}

		$this->queryParams['details'] = esc_attr($text);

		return $this;
	}

	public function setStartDate(TimeInterface $date) {
		if (!$date->getTimeStrict()) {
			return $this;
		}

		$this->dates['startDate'] = $date->getTimeStrict();

		return $this;
	}

	public function setEndDate(TimeInterface $date) {
		if (!$date->getTimeStrict()) {
			return $this;
		}

		$this->dates['endDate'] = $date->getTimeStrict();

		return $this;
	}

	public function setLocation($address) {
		if (!$address) {
			return $this;
		}

		$this->queryParams['location'] = $address;

		return $this;
	}

	public function setURL($url) {
		if (!$url) {
			return $this;
		}

		$this->queryParams['sprop'] = 'website:' . $url;

		return $this;
	}

	public function getCalendarURL () {
		// format dates for query
		$this->buildDatesForQuery();

		return static::GOOGLE_CALENDAR_URL . http_build_query($this->queryParams);
	}

	protected function buildDatesForQuery() {
		if (array_key_exists('startDate', $this->dates)) {
			$this->queryParams['dates'] = $this->dates['startDate'];
		}

		// if end date doesnt exist exist the function
		if (!array_key_exists('endDate', $this->dates)) {
			return;
		}

		// if startDate isnt set set the end date as start date
		if (!array_key_exists('dates', $this->queryParams)) {
			$this->queryParams['dates'] = $this->dates['endDate'];
		} else {
			$this->queryParams['dates'] .= '/' . $this->dates['endDate'];
		}
	}
}
