/**
 * BlueX Delivery Forecast for WooCommerce Blocks
 *
 * Displays delivery forecast information for Blue Express shipping methods
 * in the WooCommerce Block-based checkout.
 *
 * @package WooCommerce_Correios/Assets/JS
 * @since   4.0.0
 */

(function() {
	'use strict';

	// Wait for WordPress data store to be available
	if (!window.wp || !window.wp.data) {
		console.warn('BlueX Blocks: wp.data not available');
		return;
	}

	const { select, subscribe } = window.wp.data;
	const STORE_KEY = 'wc/store/cart';
	let isProcessing = false;
	let lastRatesHash = '';

	/**
	 * Debug log helper
	 */
	function debugLog(message, data) {
		if (window.console && typeof console.log === 'function') {
			if (data) {
				console.log('[BlueX Blocks]', message, data);
			} else {
				console.log('[BlueX Blocks]', message);
			}
		}
	}

	/**
	 * Simple debounce function
	 */
	function debounce(func, wait) {
		let timeout;
		return function executedFunction() {
			const context = this;
			const args = arguments;
			const later = function() {
				timeout = null;
				func.apply(context, args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}

	/**
	 * Get delivery forecast from rate object
	 */
	function getDeliveryForecast(rate) {
		if (rate.delivery_forecast) {
			return rate.delivery_forecast;
		}
		
		// Check in meta_data if available
		if (rate.meta_data && Array.isArray(rate.meta_data)) {
			const meta = rate.meta_data.find(m => m.key === '_delivery_forecast');
			if (meta) {
				return meta.value;
			}
		}
		
		return null;
	}

	/**
	 * Generate hash from rates to detect changes
	 */
	function generateRatesHash(rates) {
		if (!rates || !rates.length) {
			return '';
		}
		return rates.map(function(rate) {
			return rate.rate_id + '_' + (getDeliveryForecast(rate) || '');
		}).join('|');
	}

	/**
	 * Check if method is Blue Express
	 */
	function isBluexMethod(methodId) {
		return methodId && methodId.indexOf('bluex-') !== -1;
	}

	/**
	 * Find the shipping rate element in the DOM
	 */
	function findRateElement(rateId) {
		// Try multiple selectors as the DOM structure might vary
		const selectors = [
			'input[id="radio-control-' + rateId + '"]',
			'input[value="' + rateId + '"]',
			'[data-rate-id="' + rateId + '"]',
			// Add contains selector for partial matches (common in blocks)
			'input[id*="' + rateId + '"]',
			'input[value*="' + rateId + '"]'
		];

		for (let i = 0; i < selectors.length; i++) {
			const element = document.querySelector(selectors[i]);
			if (element) {
				return element;
			}
		}

		// Fallback: Try to find by label text if we can't find by ID
		// This is less reliable but might work if IDs are completely different
		// We need to be careful not to match wrong elements
		return null;
	}

	/**
	 * Get the container where we should append the delivery forecast
	 */
	function getDeliveryContainer(rateElement) {
		if (!rateElement) {
			return null;
		}

		// Navigate up to find the shipping option container
		let container = rateElement.closest('.wc-block-components-radio-control__option');
		
		if (!container) {
			container = rateElement.closest('.wc-block-components-shipping-rates-control__package');
		}

		if (!container) {
			container = rateElement.closest('.wc-block-components-totals-item');
		}

		if (!container) {
			container = rateElement.parentElement;
		}

		return container;
	}

	/**
	 * Create delivery forecast element
	 */
	function createDeliveryElement(forecast) {
		const element = document.createElement('small');
		element.className = 'bluex-delivery-forecast';
		element.style.display = 'block';
		element.style.marginTop = '4px';
		element.style.color = '#666';
		element.style.fontSize = '0.875em';
		element.textContent = forecast;
		return element;
	}

	/**
	 * Remove existing delivery forecast elements
	 */
	function removeExistingForecasts(container) {
		const existing = container.querySelectorAll('.bluex-delivery-forecast');
		existing.forEach(function(el) {
			el.remove();
		});
		
		// Also clear the description div if we used it
		const descriptionDiv = container.querySelector('.wc-block-components-totals-item__description');
		if (descriptionDiv) {
			// Only clear if it contains our class (to avoid clearing other plugins' content if possible,
			// though usually this div is empty or just for us)
			// For now, we'll just check if it has content we might have added.
			// But to be safe, let's just look for our element inside it.
			const inside = descriptionDiv.querySelector('.bluex-delivery-forecast');
			if (inside) {
				inside.remove();
			}
		}
	}

	/**
	 * Render delivery forecast in the order summary block
	 */
	function renderSummaryForecast(rate) {
		if (!rate.delivery_forecast || !rate.selected) {
			return;
		}

		// Find the shipping total line in the summary
		// We look for the label that matches the rate name
		const summaryLabels = document.querySelectorAll('.wc-block-components-totals-item__label');
		let summaryItem = null;

		summaryLabels.forEach(function(label) {
			if (label.textContent.trim() === rate.name) {
				summaryItem = label.closest('.wc-block-components-totals-item');
			}
		});

		if (!summaryItem) {
			debugLog('Summary item not found for:', rate.name);
			return;
		}

		// Remove existing forecast in summary
		removeExistingForecasts(summaryItem);

		// Create new element
		const forecastElement = createDeliveryElement(rate.delivery_forecast);

		// Check for description div
		const descriptionDiv = summaryItem.querySelector('.wc-block-components-totals-item__description');
		if (descriptionDiv) {
			descriptionDiv.appendChild(forecastElement);
		} else {
			summaryItem.appendChild(forecastElement);
		}

		debugLog('Rendered summary forecast for:', rate.name);
	}

	/**
	 * Render delivery forecast for a shipping rate
	 */
	function renderDeliveryForecast(rate) {
		if (!rate.delivery_forecast) {
			return;
		}

		// Render in the main list
		const rateElement = findRateElement(rate.rate_id);
		if (rateElement) {
			const container = getDeliveryContainer(rateElement);
			if (container) {
				// Remove any existing forecast elements
				removeExistingForecasts(container);

				// Create and append new forecast element
				const forecastElement = createDeliveryElement(rate.delivery_forecast);
				
				// Check for the description div suggested by user
				const descriptionDiv = container.querySelector('.wc-block-components-totals-item__description');
				
				if (descriptionDiv) {
					descriptionDiv.appendChild(forecastElement);
				} else {
					// Fallback: Try to insert after the label
					const label = container.querySelector('label');
					if (label) {
						label.appendChild(forecastElement);
					} else {
						container.appendChild(forecastElement);
					}
				}
				debugLog('Rendered forecast for ' + rate.rate_id + ':', rate.delivery_forecast);
			} else {
				debugLog('Container not found for:', rate.rate_id);
			}
		} else {
			debugLog('Rate element not found for:', rate.rate_id);
		}

		// Also try to render in the summary if selected
		if (rate.selected) {
			renderSummaryForecast(rate);
		}
	}

	/**
	 * Process all shipping rates and render delivery forecasts
	 */
	function processShippingRates() {
		debugLog('processShippingRates called');
		
		if (isProcessing) {
			debugLog('Already processing, skipping');
			return;
		}

		isProcessing = true;

		try {
			// Get shipping rates from the store
			const cartStore = select(STORE_KEY);
			if (!cartStore) {
				debugLog('Cart store not found');
				return;
			}

			const shippingRates = cartStore.getShippingRates();
			debugLog('Raw shipping rates from store:', shippingRates);

			if (!shippingRates || !shippingRates.length) {
				debugLog('No shipping rates found in store');
				return;
			}

			// Process each package
			shippingRates.forEach(function(packageRates) {
				debugLog('Processing package:', packageRates);
				
				if (!packageRates.shipping_rates) {
					debugLog('No shipping_rates in package');
					return;
				}

				// Generate hash to detect changes
				const currentHash = generateRatesHash(packageRates.shipping_rates);
				debugLog('Rates hash:', currentHash);
				
				// Skip if rates haven't changed
				// Commented out to force re-render during debugging
				/*
				if (currentHash === lastRatesHash) {
					return;
				}
				*/

				lastRatesHash = currentHash;

				// Process each shipping rate
				packageRates.shipping_rates.forEach(function(rate) {
					debugLog('Checking rate:', rate);
					
					// Only process Blue Express methods with delivery forecast
					if (isBluexMethod(rate.method_id)) {
						debugLog('Found BlueX method:', rate);
						
						const forecast = getDeliveryForecast(rate);
						
						if (forecast) {
							debugLog('Has delivery forecast:', forecast);
							// Attach forecast to rate object for render function
							rate.delivery_forecast = forecast;
							
							// Delay rendering slightly to ensure DOM is ready
							setTimeout(function() {
								renderDeliveryForecast(rate);
							}, 500); // Increased delay to ensure DOM is ready
						} else {
							debugLog('No delivery forecast for rate:', rate.rate_id);
						}
					} else {
						debugLog('Not a BlueX method:', rate.method_id);
					}
				});
			});
		} catch (error) {
			console.error('[BlueX Blocks] Error processing shipping rates:', error);
		} finally {
			isProcessing = false;
		}
	}

	/**
	 * Initialize the delivery forecast renderer
	 */
	function initialize() {
		debugLog('Initializing delivery forecast renderer');

		// Subscribe to store changes with debounce
		const debouncedProcess = debounce(processShippingRates, 3000);
		debugLog('Subscribing to store changes');
		
		subscribe(function() {
			debouncedProcess();
		});

		// Initial render
		setTimeout(processShippingRates, 5000);
		debugLog('Initial processShippingRates scheduled');

		// Also listen to checkout updates
		document.addEventListener('checkout_updated', function() {
			setTimeout(processShippingRates, 3000);
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initialize);
	} else {
		initialize();
	}

})();