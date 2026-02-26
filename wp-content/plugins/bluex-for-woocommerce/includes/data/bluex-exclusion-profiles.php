<?php
/**
 * BlueX Exclusion Profiles
 * 
 * Define códigos postales y áreas que deben excluirse de la cobertura BlueX
 * por razones geográficas o logísticas.
 * 
 * @package WooCommerce_BlueX/Data
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Obtener perfiles de exclusión por región
 * 
 * @return array Perfiles de exclusión organizados por código de región
 */
function bluex_get_exclusion_profiles() {
    return [
        'CL-VS' => [
            'region_name' => 'Valparaíso',
            'exclusions' => [
                [
                    'name' => 'Isla de Pascua (Rapa Nui)',
                    'commune' => 'Isla de Pascua',
                    'postcodes' => ['2770000', '2770001', '2770002', '2770003'],
                    'reason' => 'Ubicación insular remota - requiere logística especial'
                ],
                [
                    'name' => 'Archipiélago Juan Fernández',
                    'commune' => 'Juan Fernández',
                    'postcodes' => ['2760000', '2760001'],
                    'reason' => 'Ubicación insular remota - requiere logística especial'
                ]
            ]
        ]
    ];
}

/**
 * Obtener exclusiones para una región específica
 * 
 * @param string $region_code Código de región (ej: CL-VS)
 * @return array|null Exclusiones de la región o null si no hay
 */
function bluex_get_region_exclusions($region_code) {
    $profiles = bluex_get_exclusion_profiles();
    return isset($profiles[$region_code]) ? $profiles[$region_code]['exclusions'] : null;
}

/**
 * Verificar si una región tiene exclusiones
 * 
 * @param string $region_code Código de región
 * @return bool True si tiene exclusiones
 */
function bluex_region_has_exclusions($region_code) {
    $profiles = bluex_get_exclusion_profiles();
    return isset($profiles[$region_code]) && !empty($profiles[$region_code]['exclusions']);
}

/**
 * Obtener todos los códigos postales excluidos para una región
 * 
 * @param string $region_code Código de región
 * @return array Array de códigos postales excluidos
 */
function bluex_get_excluded_postcodes($region_code) {
    $exclusions = bluex_get_region_exclusions($region_code);
    
    if (!$exclusions) {
        return [];
    }
    
    $postcodes = [];
    foreach ($exclusions as $exclusion) {
        if (isset($exclusion['postcodes'])) {
            $postcodes = array_merge($postcodes, $exclusion['postcodes']);
        }
    }
    
    return $postcodes;
}

/**
 * Obtener nombre descriptivo para zona de exclusión
 * 
 * @param string $region_code Código de región
 * @return string Nombre de la zona de exclusión
 */
function bluex_get_exclusion_zone_name($region_code) {
    $profiles = bluex_get_exclusion_profiles();
    
    if (!isset($profiles[$region_code])) {
        return null;
    }
    
    $region_name = $profiles[$region_code]['region_name'];
    $exclusion_names = [];
    
    foreach ($profiles[$region_code]['exclusions'] as $exclusion) {
        $exclusion_names[] = $exclusion['name'];
    }
    
    return $region_name . ' - ' . implode(' y ', $exclusion_names) . ' (Excluido)';
}