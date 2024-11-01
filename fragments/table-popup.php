<?php
$address = carbon_get_theme_option('crb_espace_popup_address');
$phone = carbon_get_theme_option('crb_espace_popup_phone');
$date_format = carbon_get_theme_option( 'crb_espace_popup_date_format' );
$campus_address = carbon_get_theme_option( 'crb_espace_popup_campus_address' );
$popup_title_options = Espace\SetTable::get_popup_title_options();
$hide_section_options = Espace\SetTable::get_popup_hide_sections_options();
?>

<espace-table-popup
location_name='<?php echo $address; ?>'
date_format='<?php echo $date_format; ?>'
inline-template
>
	<transition name="modal">
		<div class="modal-mask" @click="cleanUp" v-if="popupOpened">
			<div class="modal-wrapper">
				<div class="modal-container" @click="preventPropagation">
					<?php if (!$hide_section_options['hide_title']) : ?>
						<div class="modal-header">
							<h2>{{singleTableData.Name}}</h2>
						</div>
					<?php endif; ?>

					<div class="modal-body">
						<?php if (!$hide_section_options['hide_description']) : ?>
							<div class="description">
								<h4><?php echo esc_html($popup_title_options['description_title']); ?></h4>

								<p>
									{{singleTableData.Description}}
								</p>
							</div><!-- /.description -->
						<?php endif; ?>

						<?php if (!$hide_section_options['hide_date_and_time']) : ?>
							<div class="date-time-container">
								<h4><?php echo esc_html($popup_title_options['date_and_time_title']); ?></h4>

								<p>
									{{formatDate(singleTableData.OccurrenceStartTime)}}
									-
									{{formatDate(singleTableData.OccurrenceEndTime)}} <br />

									<a :href="calendarURL" target="_blank">
										<?php _e( 'Add to Calendar', 'crb' ); ?>
									</a>
								</p>
							</div><!-- /.date-time-container -->
						<?php endif; ?>

						<?php if (!$hide_section_options['hide_location']) : ?>
							<div class="location-container">
								<h4><?php echo esc_html($popup_title_options['location_title']); ?></h4>

								<p>
									<?php if ($address) : ?>
										<span class="address">
											<label><?php _e('Address: ', 'crb'); ?></label>

											<?php echo esc_html($address); ?>

											<a :href="getGoogleMapURL" target="_blank" class="view-map">
												<?php _e('View Map', 'crb') ?>
											</a>
										</span>
									<?php endif; ?>

									<?php if ($phone) : ?>
										<?php
										$escaped_phone = preg_replace('~[^\d]*~', '', $phone);
										?>
										<span class="phone">
											<label><?php _e('Phone Number*', 'crb'); ?></label>

											<a href="tel:<?php echo $escaped_phone; ?>">
												<?php echo esc_html( $phone ); ?>
											</a>
										</span>
									<?php endif; ?>

									<span class="location">
										<label><?php _e('eSpace Location(s)', 'crb') ?></label>

										{{singleTableData.LocationName}}
									</span>
								</p>
							</div><!-- /.location-container -->
						<?php endif; ?>

						<?php if (!$hide_section_options['hide_event_contact']) : ?>
							<div class="contact-container">
								<h4><?php echo esc_html($popup_title_options['event_contact_title']); ?></h4>

								<p>
									<span>
										<label><?php _e( 'Contact Name', 'crb' ); ?></label>: {{singleTableData.ContactName}}
									</span>

									<br/>

									<span>
										<label><?php _e( 'Contact Email', 'crb' ); ?>: </label>

										<a :href="'mailto:' + singleTableData.ContactEmail">
											{{singleTableData.ContactEmail}}
										</a>
									</span>

									 <br/>

									<span v-if="singleTableData.ContactPhone">
										<label><?php _e( 'Contact Number', 'crb' );  ?>: </label>
										 {{singleTableData.ContactPhone}}
									</span>
								</p>
							</div><!-- /.contact-container -->
						<?php endif; ?>
					</div>

					<?php if (!$hide_section_options['hide_share_with_friends'] && $campus_address) : ?>
						<div class="modal-footer">
							<div class="socials">
								<h4><?php echo esc_html($popup_title_options['share_with_friends_title']); ?></h4>
								<?php
								$google_search_url = 'https://www.google.bg/maps/search/';
								$sanitized_address = preg_replace('~\s+~', '+', $campus_address);
								$full_google_search_url = $google_search_url . $sanitized_address;
								?>
								<span class="view-map">
									<a href="<?php echo esc_url($full_google_search_url); ?>" target="_blank">
										<?php _e('View Map', 'crb') ?>
									</a>
								</span>
							</div><!-- /.socials -->
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</transition>
</espace-table-popup>
