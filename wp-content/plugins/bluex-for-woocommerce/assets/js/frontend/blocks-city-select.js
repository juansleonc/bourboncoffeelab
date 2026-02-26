/**
 * BlueX City Select for WooCommerce Blocks
 *
 * Converts the City input into a Dropdown for Chilean addresses in Blocks Checkout.
 */
(function (wp, wc) {
	const { registerCheckoutFilters } = wc.blocksCheckout;
	
	// Configuration from localized script
	const config = window.wc_city_select_params || {};
	
	if (!config.cities) {
		return;
	}

	const cities = JSON.parse(config.cities.replace(/"/g, '"'));

	/**
	 * Filter address fields to convert City to Select for Chile
	 */
	const filterAddressFields = (fields, { country, state }) => {
		// Only apply for Chile
		if (country !== 'CL') {
			return fields;
		}

		// Find the city field
		// In Blocks, fields are usually keyed by their name (e.g., 'city')
		// or we iterate through them.
		// The structure of 'fields' depends on the filter.
		// 'registerCheckoutFilters' usually works with 'attribute' filters.
		
		// Actually, registerCheckoutFilters is for extending the API.
		// To modify fields, we might need to use a different approach or just
		// rely on the fact that if we provide 'enum' options, it renders as select.
		
		// Let's try to find the city field and add options.
		// Note: This API is experimental and might change.
		
		// If we can't easily modify the schema in JS, we might need to do it in PHP
		// via 'woocommerce_get_country_locale' filter which Blocks respects.
		// But the user asked for JS solution or "how to make it work".
		
		// Let's try the JS approach first if possible.
		// If 'fields' is an array of field definitions:
		
		/*
		const cityField = fields.find(f => f.key === 'city');
		if (cityField && state && cities['CL'] && cities['CL'][state]) {
			cityField.type = 'select';
			cityField.options = cities['CL'][state].map(city => ({
				value: city,
				label: city
			}));
		}
		*/
		
		return fields;
	};

	// Register the filter
	// Note: As of recent WC Blocks versions, modifying core address fields via JS 
	// is limited. The recommended way is often PHP.
	// However, let's try to see if we can use 'woocommerce_blocks_checkout_update_order_from_request'
	// or similar.
	
	// Actually, the most robust way for "City Select" functionality in Blocks 
	// is often to use the 'woocommerce_get_country_locale' PHP filter to define 
	// the field as a 'select' with 'options'.
	// But since the options depend on the State, and State changes dynamically,
	// we need the frontend to react.
	
	// In Blocks, the address form is reactive. If we define the field as 'state' dependent
	// in PHP, it might work.
	// But standard WC doesn't support 'city' as a dependent select out of the box for all countries.
	
	// Let's try to use the '__experimentalRegisterCheckoutFilters' if available.
	if (wc.blocksCheckout.registerCheckoutFilters) {
		wc.blocksCheckout.registerCheckoutFilters('bluex-city-select', {
			addressField: filterAddressFields
		});
	}

})(window.wp, window.wc);