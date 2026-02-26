<?php

class MonsterInsights_Ads_Forms
{

	/**
	 * The instance of the class.
	 */
	private static $instance;

	/**
	 * The conversion tracking id.
	 */
	protected $conversionTrackingId;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// Only run on frontend
		if (! is_admin()) {
			$this->conversionTrackingId = MonsterInsights_Google_Ads::get_settings('conversion_tracking_id');
			if ($this->conversionTrackingId) {
				add_action('monsterinsights_frontend_tracking_gtag_after_pageview', [$this, 'inject_form_conversion_tracking']);
			}
		}
	}

	/**
	 * Get instance
	 *
	 * @return MonsterInsights_Ads_Forms
	 */
	public static function get_instance()
	{
		if (! self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Inject the form conversion tracking script
	 */
	public function inject_form_conversion_tracking()
	{ 
		?>
		
			(function() {
				function mi_ads_forms_has_class(element, className) {
					return (' ' + element.className + ' ').indexOf(' ' + className + ' ') > -1;
				}

				function mi_ads_forms_record_conversion(event) {
					var form_id = event.target.id;
					if (form_id) {
						__gtagTracker('event', 'contact', {
							send_to: '<?php echo esc_js($this->conversionTrackingId); ?>',
							form_id: form_id
						});
					}
				}

				function mi_ads_forms_attach_listeners() {
					var forms = document.getElementsByTagName('form');
					for (var i = 0; i < forms.length; i++) {
						var form = forms[i];
						var form_id = form.getAttribute('id');
						if (!form_id || form_id === 'commentform' || form_id === 'adminbar-search') {
							continue;
						}
						if (window.jQuery) {
							(function(form_id) {
								jQuery(document).ready(function() {
									jQuery('#' + form_id).on('submit', mi_ads_forms_record_conversion);
								});
							})(form_id);
						} else {
							if (form.addEventListener) {
								form.addEventListener('submit', mi_ads_forms_record_conversion, false);
							} else if (form.attachEvent) {
								form.attachEvent('onsubmit', mi_ads_forms_record_conversion);
							}
						}
					}
				}

				if (typeof __gtagTracker !== 'undefined' && __gtagTracker) {
					if (window.addEventListener) {
						window.addEventListener('load', mi_ads_forms_attach_listeners, false);
					} else if (window.attachEvent) {
						window.attachEvent('onload', mi_ads_forms_attach_listeners);
					}
				} else {
					setTimeout(arguments.callee, 200);
				}
			})();
		
<?php
	}
}
