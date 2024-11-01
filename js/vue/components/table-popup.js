import Vue from 'vue';
import moment from 'moment';

Vue.component('espace-table-popup', {
	created() {
		this.GOOGLE_PLACES_URL = 'https://www.google.bg/maps/search/';

		VueBus.$on('openTableDataPopup', (tableData) => {
			this.popupOpened = true;
			this.singleTableData = Object.assign(tableData);

			// dispatch and event to stop table scroll
			window.dispatchEvent(new Event('stopTableScroll'));
			this.getCalendarURL();
		});
	},
	data() {
		return {
			popupOpened: false,
			singleTableData: [],
			calendarURL: ''
		};
	},
	methods: {
		preventPropagation(event) {
			event.stopPropagation();
		},
		sanitizeTextForGoogleMap(text) {
			if (!text) {
				return '';
			}

			return text.replace(/\s+/, '+');
		},
		cleanUp() {
			// close the popup and resume scrolling of table
			this.popupOpened = false

			// dispatch an event to resume table scroll
			window.dispatchEvent(new Event('resumeTableScroll'));
		},
		getCalendarURL() {
			jQuery.ajax({
				url: wp_espace_admin_data.admin_url,
				method: 'POST',
				data: {
					action: 'getCalendarAnchorURL',
					title: this.singleTableData.Name,
					text: this.singleTableData.Description,
					startDate: this.singleTableData.OccurrenceStartTime,
					endDate: this.singleTableData.OccurrenceEndTime,
				},
				success: (response) => {
					this.calendarURL = response;
				},
				error(xmr, status, message) {
					console.error(message);
				}
			});
		},
		formatDate(date) {
			// format the date to proper user visual
			/**
			 * formats:
			 * MMM is month with 3 chars like "Mon"
			 * ddd is week with 3 chars like "Wed"
			 * DD is day of the month
			 * HH is hour
			 * mm is mintues
			 * A is pm or am
			 */

			 // if date format isnt set
			 // use default
			 const format = this.date_format || 'MMM, ddd DD, HH:mm A ';

			return moment(new Date(date)).format(format);
		}
	},
	computed: {
		getGoogleMapURL() {
			// check if location name is set from theme options
			// if not fallback to event location name
			const locationName = this.location_name ? this.location_name : this.singleTableData.LocationName;
			return this.GOOGLE_PLACES_URL + this.sanitizeTextForGoogleMap(locationName);
		}
	},
	props: ['location_name', 'date_format'],
});