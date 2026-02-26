/**
 * BlueX PUDO Integration for WooCommerce Blocks
 *
 * Handles the PUDO widget injection and address updates for the Block-based checkout.
 */
(function (wp, wc) {
	const { useEffect, useState, useCallback } = wp.element;
	const { registerCheckoutFilters } = wc.blocksCheckout;
	const { dispatch, select, subscribe } = wp.data;

	// Configuration from localized script
	const config = window.bluex_checkout_params || {};

	/**
	 * Check if a method is a BlueX PUDO method
	 */
	const isPudoMethod = (methodId) => {
		// Adjust this logic based on your specific PUDO method ID pattern
		// Usually it contains 'bluex' and potentially 'pudo' or specific service codes
		// For now, we'll assume any bluex method might be PUDO if configured, 
		// but ideally we should check against a list of PUDO service codes.
		// Based on classic integration, it checks if method is 'pudoShipping' (which is a simplified check)
		// In blocks, we get the full rate ID like "bluex:instance_id"
		// We might need to check the rate's meta data or description if available.
		
		// For this implementation, we'll rely on the rate's meta data if available,
		// or check if the method ID corresponds to a PUDO service.
		return methodId && methodId.includes('bluex');
	};

	/**
	 * PUDO Widget Component
	 */
	const PudoWidget = ({ methodId }) => {
		const [isWidgetLoaded, setIsWidgetLoaded] = useState(false);
		const [selectedPoint, setSelectedPoint] = useState(null);

		// Listen for PUDO selection messages
		useEffect(() => {
			const handleMessage = (event) => {
				if (!event.data || event.data.type !== 'pudo:select') {
					return;
				}

				const payload = event.data.payload;
				if (payload && payload.location) {
					handlePudoSelection(payload);
				}
			};

			window.addEventListener('message', handleMessage);
			return () => window.removeEventListener('message', handleMessage);
		}, []);

		// Load Widget
		useEffect(() => {
			if (isWidgetLoaded) return;

			const container = document.getElementById('bluex-blocks-pudo-container');
			if (container) {
				loadWidget(container);
				setIsWidgetLoaded(true);
			}
		}, [methodId]);

		const loadWidget = (container) => {
			// Determine environment and build widget URL
			const baseUrl = config.base_path_url || '';
			let widgetUrl = config.widget_base_urls?.prod;

			if (baseUrl.includes('qa')) {
				widgetUrl = config.widget_base_urls?.qa;
			} else if (baseUrl.includes('dev')) {
				widgetUrl = config.widget_base_urls?.dev;
			}

			if (!widgetUrl) {
				console.error('BlueX: Widget URL not configured');
				return;
			}

			// Create iframe
			const iframe = document.createElement('iframe');
			iframe.id = 'bluex-pudo-iframe';
			iframe.src = widgetUrl;
			iframe.style.width = '100%';
			iframe.style.height = '600px';
			iframe.style.border = 'none';
			iframe.title = 'Selector de Punto Blue Express';

			container.innerHTML = '';
			container.appendChild(iframe);
		};

		const handlePudoSelection = (data) => {
			const { location, agency_id, agency_name } = data;
			const {
				street_name = '',
				street_number = '',
				city_name = '',
				country_name = '',
				state_name = '' // This might need mapping to region code
			} = location;

			// Update Shipping Address in Blocks Store
			// We need to map the state name to the region code (e.g., "Metropolitana de Santiago" -> "CL-RM")
			// This mapping logic exists in custom-checkout-map.js, we should reuse or replicate it.
			const stateCode = getStateCode(state_name);

			const address = {
				address_1: `${street_name} ${street_number}`,
				address_2: agency_name, // Store agency name in address_2
				city: city_name,
				state: stateCode,
				country: 'CL', // Assuming Chile
			};

			// Dispatch update to store
			dispatch('wc/store/cart').setShippingAddress(address);
			
			// We also need to store the agency_id. 
			// Blocks doesn't have a direct way to set arbitrary meta data for the order via the cart store 
			// without an extension. 
			// However, we can try to use 'updateCustomerData' or similar if we have extended the schema.
			// For now, we'll focus on the address update which is the most visible part.
			// Ideally, we should send the agency_id to the server via an extension endpoint.
			
			setSelectedPoint(data);
		};

		return wp.element.createElement('div', {
			id: 'bluex-blocks-pudo-container',
			className: 'bluex-pudo-container',
			style: { marginTop: '15px', marginBottom: '15px' }
		});
	};

	// Helper to map state names to codes (copied from custom-checkout-map.js)
	const getStateCode = (name) => {
		const states = [
			{ abreviation: "CL-AI", nameFromIframe: "Aysén" },
			{ abreviation: "CL-AN", nameFromIframe: "Antofagasta" },
			{ abreviation: "CL-AP", nameFromIframe: "Arica y Parinacota" },
			{ abreviation: "CL-AR", nameFromIframe: "Araucanía" },
			{ abreviation: "CL-AT", nameFromIframe: "Atacama" },
			{ abreviation: "CL-BI", nameFromIframe: "Bío - Bío" },
			{ abreviation: "CL-CO", nameFromIframe: "Coquimbo" },
			{ abreviation: "CL-LI", nameFromIframe: "Libertador General Bernardo O`Higgins" },
			{ abreviation: "CL-LL", nameFromIframe: "Los Lagos" },
			{ abreviation: "CL-LR", nameFromIframe: "Los Ríos" },
			{ abreviation: "CL-MA", nameFromIframe: "Magallanes y la Antartica Chilena" },
			{ abreviation: "CL-ML", nameFromIframe: "Maule" },
			{ abreviation: "CL-NB", nameFromIframe: "Ñuble" },
			{ abreviation: "CL-RM", nameFromIframe: "Metropolitana de Santiago" },
			{ abreviation: "CL-TA", nameFromIframe: "Tarapacá" },
			{ abreviation: "CL-VS", nameFromIframe: "Valparaiso" },
		];
		const match = states.find(s => s.nameFromIframe === name);
		return match ? match.abreviation : '';
	};

	// We need to find a way to render this component.
	// Since we can't easily inject React components into the Shipping Method list via standard hooks yet,
	// we might need to use a DOM-based approach similar to the delivery forecast, 
	// OR use 'experimental__woocommerce_blocks-checkout-shipping-method-list-item-description' if available.
	
	// Let's try a hybrid approach:
	// 1. Watch for shipping method changes.
	// 2. If a PUDO method is selected, inject a container div into the DOM below the method.
	// 3. Mount our React component into that container.

	/**
	 * PUDO Selector Component (Home vs Point)
	 */
	const PudoSelector = () => {
		// Initialize state based on current address
		const [mode, setMode] = useState(() => {
			const cart = select('wc/store/cart');
			// Use getCartData() to access shippingAddress
			const cartData = cart.getCartData();
			const address = cartData.shippingAddress || {};
			const addressString = (address.address_1 || '') + ' ' + (address.address_2 || '');
			
			// Check if address looks like a PUDO point
			if (addressString.includes('Punto Blue Express') || addressString.includes('Blue Express Point')) {
				return 'point';
			}
			return 'home';
		});
		
		const handleModeChange = (newMode) => {
			setMode(newMode);
			// If switching to home, maybe clear PUDO address?
			// For now, just UI switching.
		};

		// Listen for address changes to update mode if needed (e.g. if user manually changes address)
		// But be careful not to cause loops. For now, let's trust the internal state + init logic.

		return wp.element.createElement('div', { className: 'bluex-pudo-selector-container', style: { marginBottom: '20px', padding: '15px', border: '1px solid #e0e0e0', borderRadius: '4px' } },
			wp.element.createElement('h3', { style: { fontSize: '16px', marginBottom: '10px' } }, 'Método de Entrega'),
			wp.element.createElement('div', { className: 'bluex-pudo-options' },
				// Home Option
				wp.element.createElement('label', { style: { display: 'block', marginBottom: '10px', cursor: 'pointer' } },
					wp.element.createElement('input', {
						type: 'radio',
						name: 'bluex_delivery_mode',
						value: 'home',
						checked: mode === 'home',
						onChange: () => handleModeChange('home'),
						style: { marginRight: '10px' }
					}),
					'Envío a Domicilio'
				),
				// Point Option
				wp.element.createElement('label', { style: { display: 'block', marginBottom: '10px', cursor: 'pointer' } },
					wp.element.createElement('input', {
						type: 'radio',
						name: 'bluex_delivery_mode',
						value: 'point',
						checked: mode === 'point',
						onChange: () => handleModeChange('point'),
						style: { marginRight: '10px' }
					}),
					'Retiro en Punto Blue Express'
				)
			),
			// Show Widget if Point selected
			mode === 'point' && wp.element.createElement(PudoWidget, { methodId: 'bluex-pudo-selector' })
		);
	};

	const mountPudoWidget = () => {
		console.log('BlueX Blocks PUDO: Checking where to inject selector...');
		
		// We want to inject the selector BEFORE the shipping rates list.
		// Target: .wc-block-components-shipping-rates-control
		
		const shippingRatesControl = document.querySelector('.wc-block-components-shipping-rates-control');
		
		if (!shippingRatesControl) {
			console.log('BlueX Blocks PUDO: Shipping rates control not found yet');
			return;
		}

		// Check if we already injected
		let root = document.getElementById('bluex-blocks-pudo-selector-root');
		if (!root) {
			console.log('BlueX Blocks PUDO: Creating selector root container');
			root = document.createElement('div');
			root.id = 'bluex-blocks-pudo-selector-root';
			
			// Insert BEFORE the shipping rates control
			shippingRatesControl.parentNode.insertBefore(root, shippingRatesControl);
			
			// Render the selector
			console.log('BlueX Blocks PUDO: Rendering Selector Component');
			wp.element.render(
				wp.element.createElement(PudoSelector),
				root
			);
		}
	};

	// Subscribe to store changes to trigger mount
	subscribe(() => {
		// Debounce or check if changed could be good, but for now just try to mount
		// We need to wait for DOM updates
		setTimeout(mountPudoWidget, 100);
	});

})(window.wp, window.wc);