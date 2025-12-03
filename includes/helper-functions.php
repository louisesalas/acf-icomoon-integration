<?php
/**
 * Helper Functions
 *
 * Global helper functions for using IcoMoon icons throughout WordPress.
 *
 * @package ACF_IcoMoon_Integration
 */

declare(strict_types=1);

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper function to get an icon SVG
 *
 * @param string $icon_name The icon name (e.g., 'home' or 'icon-home')
 * @param array  $atts      Optional attributes (class, width, height, etc.)
 * @return string The SVG HTML
 */
function acf_icomoon_get_icon( string $icon_name, array $atts = array() ): string {
    $instance = acf_icomoon();
    
    if ( ! $instance || ! $instance->frontend ) {
        return '';
    }
    
    return $instance->frontend->get_icon( $icon_name, $atts );
}

/**
 * Echo an icon SVG
 *
 * @param string $icon_name The icon name
 * @param array  $atts      Optional attributes
 * @return void
 */
function acf_icomoon_icon( string $icon_name, array $atts = array() ): void {
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo acf_icomoon_get_icon( $icon_name, $atts );
}

/**
 * Check if IcoMoon icons are available
 *
 * @return bool
 */
function acf_icomoon_has_icons(): bool {
    $icons = get_option( 'acf_icomoon_icons', array() );
    return ! empty( $icons );
}

/**
 * Get all available icon names
 *
 * @return array
 */
function acf_icomoon_get_icons(): array {
    return get_option( 'acf_icomoon_icons', array() );
}

