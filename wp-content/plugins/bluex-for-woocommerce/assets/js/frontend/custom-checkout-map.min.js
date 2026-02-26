// Listen for the DOM content to be loaded
document.addEventListener("DOMContentLoaded", () => {
  clearWooCommerceShippingCache(); // Clear the WooCommerce shipping cache
  handleMessagesFromWindow(); // Handle messages from the window
});

// Function to handle messages received by the window
function handleMessagesFromWindow() {
  window.addEventListener("message", (event) => {
    const elements = getDOMElements(); // Get DOM elements

    switch (event.data.type) {
      case "pudo:select":
        handlePudoSelect(event, elements); // Handle 'pudo:select' messages
        break;
      case "pudo:change":
        // some action for 'pudo:change' messages
        break;
    }
  });
}

// Function to get specific DOM elements
function getDOMElements() {
  return {
    inputState: document.getElementById("billing_state"), // Input for billing state
    inputDir: document.getElementById("billing_address_1"), // Input for billing address line 1
    inputDir2: document.getElementById("billing_address_2"), // Input for billing address line 2
    countryContainer: document.getElementById(
      "select2-billing_country-container"
    ), // Input for billing country
    stateContainer: document.querySelector("#select2-billing_state-container"), // Container for billing state
    inputCity: document.getElementById("billing_city"), // Input for billing city
    agencyIdInput: document.getElementById("agencyId"), // Input for agency ID
  };
}

// Function to handle 'pudo:select' event
function handlePudoSelect(event, elements) {
  const data = event.data.payload; // Payload of the event

  if (data && data.location) {
    const {
      street_name = "",
      street_number = "",
      city_name = "",
      country_name = "",
      state_name = "",
    } = data.location; // Destructure location data

    // Set values to elements based on the event data
    elements.agencyIdInput.value = data.agency_id;
    elements.inputDir.value = `${street_name} ${street_number}`;
    elements.inputDir2.value = data.agency_name;
    if (elements.countryContainer)
      elements.countryContainer.value = country_name;

    const state = getStateDetails(state_name); // Get state details
    elements.stateContainer.innerHTML = state.fullName; // Set the state's full name
    elements.inputState.value = state.abreviation; // Set the state's abbreviation
    elements.inputState.title = state.fullName; // Set the state's full name as title
    cityToInput(elements.inputCity, city_name); // Set the city name to the input

    triggerUpdateCheckout(); // Trigger checkout update
  }
}

// Function to set city name to the input field
function cityToInput(citybox, city_name) {
  // Check if the element is an input
  if (citybox.tagName === "INPUT") {
    citybox.value = city_name; // Set the city name
    return;
  }

  // Get attributes from the element
  var input_name = citybox.getAttribute("name");
  var input_id = citybox.getAttribute("id");
  var placeholder = citybox.getAttribute("placeholder");

  // Remove the select2 container if it exists
  var select2Container = citybox.parentNode.querySelector(".select2-container");
  if (select2Container) {
    select2Container.parentNode.removeChild(select2Container);
  }

  // Create a new input element and configure it
  var newInput = document.createElement("input");
  newInput.type = "text";
  newInput.className = "input-text";
  newInput.name = input_name;
  newInput.id = input_id;
  newInput.placeholder = placeholder;
  newInput.value = city_name;

  // Replace the original element with the new input
  citybox.parentNode.replaceChild(newInput, citybox);
}

// Function to trigger a change event
function triggerChangeEvent(inputElement) {
  // Dispatch the change event
  let event = new Event("change", {
    bubbles: true,
    cancelable: true,
  });
  inputElement.dispatchEvent(event);
}

// Function to get state details based on name
function getStateDetails(name) {
  const states = [
    {
      abreviation: "CL-AI",
      fullName: "Aisén del General Carlos Ibañez del Campo",
      nameFromIframe: "Aysén",
    },
    {
      abreviation: "CL-AN",
      fullName: "Antofagasta",
      nameFromIframe: "Antofagasta",
    },
    {
      abreviation: "CL-AP",
      fullName: "Arica y Parinacota",
      nameFromIframe: "Arica y Parinacota",
    },
    {
      abreviation: "CL-AR",
      fullName: "La Araucanía",
      nameFromIframe: "Araucanía",
    },
    { abreviation: "CL-AT", fullName: "Atacama", nameFromIframe: "Atacama" },
    { abreviation: "CL-BI", fullName: "Biobío", nameFromIframe: "Bío - Bío" },
    { abreviation: "CL-CO", fullName: "Coquimbo", nameFromIframe: "Coquimbo" },
    {
      abreviation: "CL-LI",
      fullName: "Libertador General Bernardo O'Higgins",
      nameFromIframe: "Libertador General Bernardo O`Higgins",
    },
    {
      abreviation: "CL-LL",
      fullName: "Los Lagos",
      nameFromIframe: "Los Lagos",
    },
    { abreviation: "CL-LR", fullName: "Los Ríos", nameFromIframe: "Los Ríos" },
    {
      abreviation: "CL-MA",
      fullName: "Magallanes",
      nameFromIframe: "Magallanes y la Antartica Chilena",
    },
    { abreviation: "CL-ML", fullName: "Maule", nameFromIframe: "Maule" },
    { abreviation: "CL-NB", fullName: "Ñuble", nameFromIframe: "Ñuble" },
    {
      abreviation: "CL-RM",
      fullName: "Región Metropolitana de Santiago",
      nameFromIframe: "Metropolitana de Santiago",
    },
    { abreviation: "CL-TA", fullName: "Tarapacá", nameFromIframe: "Tarapacá" },
    {
      abreviation: "CL-VS",
      fullName: "Valparaíso",
      nameFromIframe: "Valparaiso",
    },
    { abreviation: "", fullName: "", nameFromIframe: "" },
  ];

  return states.find((state) => state.nameFromIframe === name) || {};
}

// Function to select a shipping method - updated for modern WooCommerce
function selectShipping(shippingMethod) {
  console.log('BlueX PUDOS: selectShipping called with:', shippingMethod);
  
  const pudoIdInput = document.getElementById("isPudoSelected");
  const widgetContainer = document.getElementById("bluex-pudo-widget-container") || 
                         document.getElementById("bluex-pudo-widget-container-emergency") ||
                         document.getElementById("bluex-pudo-widget-container-optimized") ||
                         document.getElementById("bluex-pudo-widget-container-native") ||
                         document.getElementById("bluex-pudo-widget-container-debug") ||
                         document.getElementById("bluex-pudo-widget-container-sidebar") ||
                         document.getElementById("bluex-pudo-widget-container-simple");
  
  if (pudoIdInput) {
    pudoIdInput.value = shippingMethod; // Set the shipping method
    console.log('BlueX PUDOS: Set isPudoSelected to:', shippingMethod);
  } else {
    console.warn('BlueX PUDOS: isPudoSelected input not found');
  }

  if (shippingMethod === "normalShipping") {
    const elements = getDOMElements();
    if (elements.agencyIdInput && elements.inputDir && elements.inputDir2) {
      clearElements(elements); // Clear elements only if they exist
      console.log('BlueX PUDOS: Cleared elements');
    } else {
      console.log('BlueX PUDOS: Some elements not found, skipping clearElements');
    }
    
    // Hide PUDO widget
    if (widgetContainer) {
      widgetContainer.style.display = "none";
      console.log('BlueX PUDOS: Hidden widget container');
    }

    if (elements.inputState) {
      triggerChangeEvent(elements.inputState); // Trigger change event on state input
    }
  } else if (shippingMethod === "pudoShipping") {
    // Show PUDO widget
    if (widgetContainer) {
      widgetContainer.style.display = "block";
      console.log('BlueX PUDOS: Shown widget container');
      
      // Load widget if not already loaded
      if (!widgetContainer.querySelector('iframe')) {
        loadPudoWidget();
        console.log('BlueX PUDOS: Loading PUDO widget');
      }
    } else {
      console.warn('BlueX PUDOS: Widget container not found');
    }
  }
  
  // Trigger WooCommerce checkout update
  if (typeof jQuery !== 'undefined') {
    jQuery(document.body).trigger('update_checkout');
  }
  clearWooCommerceShippingCache(); // Clear WooCommerce shipping cache
}

// Function to clear input elements
function clearElements(elements) {
  // Clear values of elements
  elements.agencyIdInput.value = "";
  elements.inputDir.value = "";
  elements.inputDir2.value = "";
}

// Function to trigger update checkout event
function triggerUpdateCheckout() {
  const event = new CustomEvent("update_checkout");
  document.body.dispatchEvent(event); // Dispatch the event
}

// Function to load PUDO widget dynamically
function loadPudoWidget() {
  if (typeof bluex_checkout_params === 'undefined') {
    console.error('BlueX checkout parameters not loaded');
    return;
  }

  const widgetContainer = document.getElementById("bluex-pudo-widget-container") || 
                         document.getElementById("bluex-pudo-widget-container-emergency") ||
                         document.getElementById("bluex-pudo-widget-container-optimized") ||
                         document.getElementById("bluex-pudo-widget-container-native") ||
                         document.getElementById("bluex-pudo-widget-container-debug") ||
                         document.getElementById("bluex-pudo-widget-container-sidebar") ||
                         document.getElementById("bluex-pudo-widget-container-simple");
  if (!widgetContainer) {
    console.error('BlueX PUDOS: No widget container found');
    return;
  }

  // For optimized/native/debug/sidebar/simple containers, load widget into the specific content area
  const targetContainer = document.getElementById("widget-content-optimized") || 
                          document.getElementById("widget-content-native") || 
                          document.getElementById("widget-content-debug") ||
                          document.getElementById("widget-content-sidebar") ||
                          document.getElementById("widget-content-simple") ||
                          widgetContainer;

  // Determine environment and build widget URL
  const baseUrl = bluex_checkout_params.base_path_url;
  let widgetUrl = bluex_checkout_params.widget_base_urls.prod; // default

  if (baseUrl.includes('qa')) {
    widgetUrl = bluex_checkout_params.widget_base_urls.qa;
  } else if (baseUrl.includes('dev')) {
    widgetUrl = bluex_checkout_params.widget_base_urls.dev;
  }

  const params = new URLSearchParams();

  const agencyIdInput = document.getElementById("agencyId");
  if (agencyIdInput && agencyIdInput.value) {
    params.append('id', agencyIdInput.value);
  }

  if (params.toString()) {
    widgetUrl += '?' + params.toString();
  }

  // Create iframe
  const iframe = document.createElement('iframe');
  iframe.id = 'bluex-pudo-iframe';
  iframe.src = widgetUrl;
  iframe.style.width = '100%';
  iframe.style.height = '600px';
  iframe.style.border = 'none';
  iframe.title = 'Selector de Punto Blue Express';

  // Wrap in container div
  const wrapper = document.createElement('div');
  wrapper.className = 'bluex-pudo-widget-wrapper';
  wrapper.style.border = '1px solid #ccc';
  wrapper.style.borderRadius = '5px';
  wrapper.style.overflow = 'hidden';
  wrapper.appendChild(iframe);

  targetContainer.innerHTML = '';
  targetContainer.appendChild(wrapper);
}

// Function to clear WooCommerce shipping cache - updated with nonce
function clearWooCommerceShippingCache() {
  if (typeof bluex_checkout_params === 'undefined') {
    console.error('BlueX checkout parameters not loaded');
    return;
  }

  const data = new FormData();
  data.append('action', 'clear_shipping_cache');
  data.append('nonce', bluex_checkout_params.nonce);

  fetch(bluex_checkout_params.ajax_url, {
    method: 'POST',
    body: data
  })
  .then(response => response.json())
  .then(result => {
    if (result.success) {
      triggerUpdateCheckout(); // Trigger checkout update on successful request
    }
  })
  .catch(error => {
    console.error('Error clearing shipping cache:', error);
  });
}
