<?php
namespace ASMBS\Dashboard;

class TokenService
{
    private const TRANSIENT_KEY = 'asmbs_dashboard_ms_token';

    public static function getToken(): string
    {
        $cached = get_transient(self::TRANSIENT_KEY);
        if ($cached) {
            return $cached;
        }

        $response = wp_remote_post(
            'https://rest.membersuite.com/platform/v2/loginUser/36893',
            [
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body'    => json_encode([
                    'email'    => $_ENV['MS_EMAIL']    ?? '',
                    'password' => $_ENV['MS_PASSWORD'] ?? '',
                ]),
                'timeout' => 15,
            ]
        );

        if (is_wp_error($response)) {
            return '';
        }

        $data  = json_decode(wp_remote_retrieve_body($response), true);
        $token = $data['data']['idToken'] ?? '';

        if (!empty($token)) {
            set_transient(self::TRANSIENT_KEY, $token, 50 * MINUTE_IN_SECONDS);
        }

        return $token;
    }
}