(function($){
	$(document).ready(function(){
		documentReady();
	});

	function documentReady() {
		$('.carbon-field.carbon-complex')
			.find('select[name$="[_column_type]"]')
			.each(function( index, element) {
				const $this_element = $(element);

				if (!$this_element.length) {
					return;
				}

				doDayCheckboxLogic($this_element);
				doPastEventsLogic($this_element);
			} )
			.on('change', function (event) {
				const $this_element = $(this);

				if (!$this_element.length) {
					return;
				}

				doDayCheckboxLogic($this_element);
				doPastEventsLogic($this_element);
			} );

		formatDates();
	}

	function doDayCheckboxLogic($this_element) {
		if ($this_element.val().match(/Time/i)) {
			const $element = $this_element.closest('.carbon-select')
				.siblings('.carbon-number')
				.find('input[name$="[_forward_days_to_hide_date]"]');

			if ( $element.length > 0 ) {
				$element.closest('.carbon-number').css('display', 'block')
			}
		} else {
			const $element = $this_element.closest('.carbon-select')
				.siblings('.carbon-number')
				.find('input[name$="[_forward_days_to_hide_date]"]');

			if ($element.length) {
				$element.val(0);
				$element.closest('.carbon-number').css('display', 'none')
			}
		}
	}

	function doPastEventsLogic($this_element) {
		if ($this_element.val().match(/EndTime/i)) {
			const $element = $this_element.closest('.carbon-select')
				.siblings('.carbon-checkbox')
				.find('input[name$="[_hide_past_events]"]');

			if ($element.length) {
				$element.closest('.carbon-checkbox').css('display', 'block');
			}
		} else {
			const $element = $this_element.closest('.carbon-select')
				.siblings('.carbon-checkbox')
				.find('input[name$="[_hide_past_events]"]');

			if ($element.length) {
				$element.attr('checked', false);
				$element.closest('.carbon-checkbox').css('display', 'none')
			}
		}
	}

	function formatDates() {
		$('select[name="_crb_espace_popup_date_format"] > option').each(function(index, element) {
			const $element = $(element);

			$element.text(moment().format($element.val()));

			setInterval(function () {
				$element.text(moment().format($element.val()));
			}, 1000);
		});
	}
})(jQuery)