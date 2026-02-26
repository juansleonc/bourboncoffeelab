<?php
/**
 * BlueX City Zone Matcher
 *
 * Adds support for matching Shipping Zones by City (Commune)
 *
 * @package WooCommerce_BlueX/Classes
 */

if (!defined('ABSPATH')) {
    exit;
}

class WC_BlueX_City_Zone_Matcher {

    /**
     * Initialize the class
     */
    public static function init() {
        // Register custom location type
        add_filter('woocommerce_location_types', array(__CLASS__, 'add_location_type'));
        
        // Add matching logic
        add_filter('woocommerce_check_zone_locations', array(__CLASS__, 'check_zone_locations'), 10, 3);
    }

    /**
     * Add 'city' to available location types
     * 
     * @param array $types Existing location types
     * @return array Modified location types
     */
    public static function add_location_type($types) {
        $types['city'] = __('City/Commune', 'woocommerce-correios');
        return $types;
    }

    /**
     * Check if a zone matches the customer's location based on city
     * 
     * @param bool $found Whether a match has already been found
     * @param array $locations Locations in the zone
     * @param array $values Customer's location values (country, state, postcode, city)
     * @return bool True if matched, false otherwise
     */
    public static function check_zone_locations($found, $locations, $values) {
        if ($found) {
            return true;
        }

        // If no city provided in values, we can't match by city
        if (empty($values['city'])) {
            return false;
        }

        foreach ($locations as $location) {
            // Check both 'city' (legacy/custom) and 'postcode' (new strategy)
            if ($location->type !== 'city' && $location->type !== 'postcode') {
                continue;
            }

            // Normalize strings for comparison (lowercase, trim)
            $zone_location_code = mb_strtolower(trim($location->code), 'UTF-8');
            $customer_city = mb_strtolower(trim($values['city']), 'UTF-8');

            // Check for exact match
            // This allows matching a zone defined by "Santiago" (stored as postcode)
            // against a customer city "Santiago"
            if ($zone_location_code === $customer_city) {
                return true;
            }
        }

        return false;
    }
}