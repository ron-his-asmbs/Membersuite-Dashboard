<?php
namespace ASMBS\Dashboard;

class Dashboard
{
    public function __construct()
    {
        add_filter('template_include', [$this, 'loadData'], 1);
    }

    public function loadData(string $template): string
    {
        if (!is_page_template('page-templates/member-dashboard.php')) {
            return $template;
        }

        $wp_user  = wp_get_current_user();
        $mem_guid = get_user_meta($wp_user->ID, 'mem_guid', true);
        $member_id = get_user_meta($wp_user->ID, 'mem_key', true);

        if (!$mem_guid) {
            set_query_var('ms_error', 'No MemberSuite GUID found for this account.');
            return $template;
        }

        $memberData = new MemberData($mem_guid);

        if (!$memberData->fetch()) {
            set_query_var('ms_error', 'Unable to load member profile from MemberSuite.');
            return $template;
        }

        // Make data available to the template
        set_query_var('ms_member',      $memberData);
        set_query_var('ms_member_id',   $member_id);
        set_query_var('ms_type_code',   get_user_meta($wp_user->ID, 'mem_type', true));
        set_query_var('ms_status_code', get_user_meta($wp_user->ID, 'mem_status', true));

        return $template;
    }
}