<?php

namespace Espace;

use Espace\Builders\GoogleCalendarBuilder;
use Espace\Time\Time;


class AjaxMethods {
	public static function initMethods() {
		add_action('wp_ajax_getCalendarAnchorURL', [static::class, 'getCalendarAnchorURL']);
		add_action('wp_ajax_nopriv_getCalendarAnchorURL', [static::class, 'getCalendarAnchorURL']);
	}

	public static function getCalendarAnchorURL() {
		$googleCalendarBuilder = new GoogleCalendarBuilder();

		$url = $googleCalendarBuilder
			->setTitle(static::getPostRequest('title'))
			->setText(static::getPostRequest('text'))
			->setLocation(carbon_get_theme_option('crb_espace_popup_address'))
			->setURL(home_url())
			->setStartDate(new Time(static::getPostRequest('startDate')))
			->setEndDate(new Time(static::getPostRequest('endDate')))
			->getCalendarURL();

		wp_die($url);
	}

	protected static function getPostRequest($key) {
		if (empty($_POST[$key])) {
			return '';
		}

		return $_POST[$key];
	}
}