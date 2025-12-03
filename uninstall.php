<?php
/**
 * ACF IcoMoon Integration Uninstall
 *
 * Fired when the plugin is uninstalled.
 * Cleans up all plugin data from the database and file system.
 *
 * @package ACF_IcoMoon_Integration
 */

// If uninstall not called from WordPress, exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

/**
 * Delete plugin options from the database
 */
delete_option( 'acf_icomoon_icons' );
delete_option( 'acf_icomoon_sprite_url' );
delete_option( 'acf_icomoon_sprite_path' );

/**
 * Delete uploaded files
 */
// Initialize WP_Filesystem
require_once ABSPATH . 'wp-admin/includes/file.php';
WP_Filesystem();
global $wp_filesystem;

$acf_icomoon_upload_dir = wp_upload_dir();
$acf_icomoon_dir = $acf_icomoon_upload_dir['basedir'] . '/acf-icomoon';

if ( $wp_filesystem->is_dir( $acf_icomoon_dir ) ) {
    // Delete all files in the directory
    $acf_icomoon_files = array(
        $acf_icomoon_dir . '/selection.json',
        $acf_icomoon_dir . '/sprite.svg',
    );

    foreach ( $acf_icomoon_files as $acf_icomoon_file ) {
        if ( $wp_filesystem->exists( $acf_icomoon_file ) ) {
            $wp_filesystem->delete( $acf_icomoon_file );
        }
    }

    // Remove the directory
    $wp_filesystem->rmdir( $acf_icomoon_dir );
}

/**
 * For multisite, delete options from all sites
 */
if ( is_multisite() ) {
    $acf_icomoon_sites = get_sites( array( 'fields' => 'ids' ) );
    
    foreach ( $acf_icomoon_sites as $acf_icomoon_site_id ) {
        switch_to_blog( $acf_icomoon_site_id );
        
        delete_option( 'acf_icomoon_icons' );
        delete_option( 'acf_icomoon_sprite_url' );
        delete_option( 'acf_icomoon_sprite_path' );
        
        // Clean up uploaded files for each site
        $acf_icomoon_site_upload_dir = wp_upload_dir();
        $acf_icomoon_site_icomoon_dir = $acf_icomoon_site_upload_dir['basedir'] . '/acf-icomoon';
        
        if ( $wp_filesystem->is_dir( $acf_icomoon_site_icomoon_dir ) ) {
            $acf_icomoon_site_files = array(
                $acf_icomoon_site_icomoon_dir . '/selection.json',
                $acf_icomoon_site_icomoon_dir . '/sprite.svg',
            );

            foreach ( $acf_icomoon_site_files as $acf_icomoon_site_file ) {
                if ( $wp_filesystem->exists( $acf_icomoon_site_file ) ) {
                    $wp_filesystem->delete( $acf_icomoon_site_file );
                }
            }

            // Remove the directory
            $wp_filesystem->rmdir( $acf_icomoon_site_icomoon_dir );
        }
        
        restore_current_blog();
    }
}

