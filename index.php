<?php

/**
 * Plugin Name: Easyload
 * Description: Load JavaScript and CSS files dynamically based on templates or conditions.
 * Version: 1.0
 * Author: Kris Heijnen
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Enqueue dynamic JavaScript and CSS files from theme's assets directory

function dynamic_assets_loader()
{
    $templates = array(
        'main' => true,
        'front-page' => is_front_page(),
        'single' => is_singular(),
        'archive' => is_archive(),
        'page' => is_page(),
        'search' => is_search(),
        '404' => is_404()
    );

    // Get the current theme directory URI
    $theme_directory_uri = get_theme_file_path();

    foreach ($templates as $template => $condition) {
        if ($condition) {
            // Enqueue JavaScript
            $js_file = $theme_directory_uri . "/assets/js/{$template}.js";
            if (file_exists($js_file)) {
                $path = get_theme_file_uri("assets/js/{$template}.js");
                wp_enqueue_script(
                    "{$template}-script",
                    $path,
                    array(),
                    wp_get_theme()->get('Version'),
                    true
                );
            }

            // Enqueue CSS
            $css_file = $theme_directory_uri . "/assets/css/{$template}.css";
            if (file_exists($css_file)) {
                $path = get_theme_file_uri("assets/css/{$template}.css");
                wp_enqueue_style(
                    "{$template}-style",
                    $path,
                    array(),
                    wp_get_theme()->get('Version'),
                );
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'dynamic_assets_loader');
