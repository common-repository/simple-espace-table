<?php 

namespace Espace\Time;

use Espace\Interfaces\TimeInterface;

class Time implements TimeInterface {
	protected $time = false;

	public function __construct($time = '') {
		$this->setTime($time);
	}

	public function setTime($time) {
		if (!$time) {
			$this->time = time();
			return $this;
		}

		if (is_string($time)) {
			$this->time = strtotime($time);
		} else {
			$this->time = $time;
		}
		return $this;
	}

	public function getTime() {
		if (!$time) {
			return null;
		}

		return date('Y-m-d H:i:s a', $this->time);
	}

	public function getTimeStrict() {
		if (!$this->time) {
			return null;
		}

		// get year month and day
		$yearMonthDay = date('Ymd', $this->time);
		$hoursMinutesSeconds = date('His', $this->time);

		return $yearMonthDay . 'T' . $hoursMinutesSeconds;
	}

	public function getTimeFormat($timeFormat) {
		// check if time is set and time format is a string
		if (!$time || !is_string($timeFormat)) {
			return null;
		}

		return date($timeFormat, $this->time);
	}
}