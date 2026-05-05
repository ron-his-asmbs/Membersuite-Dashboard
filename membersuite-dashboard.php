<?php
/**
 * Plugin Name: ASMBS Dashboard
 * Description: Member dashboard powered by MemberSuite API.
 * Version: 1.0.0
 * Author: ASMBS
 */

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

use ASMBS\Dashboard\Dashboard;

add_action('plugins_loaded', function() {
    new Dashboard();
});