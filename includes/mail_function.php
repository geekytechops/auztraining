<?php

require_once __DIR__ . '/email_log_helper.php';

$email = '';

if (!function_exists('crm_zepto_mail_config')) {
    /**
     * ZeptoMail AU API credentials (Send Mail Token — not SMTP username/password).
     */
    function crm_zepto_mail_config() {
        return array(
            'api_url'      => 'https://api.zeptomail.com.au/v1.1/email',
            'auth_token'   => 'Zoho-enczapikey GkDdjPiD/lEbxVjCoNzoMYVVapYys5LqHMrkNMxSpRYs7dgJtkxOecNJkSZ+nmVK6CDGDFSdd7xx9DKC4+iLLnh9dSb5K0TuOpwzGB+edd0FvHvXUPi/9/djXEfKkfasMAxn7B8w9S9j4A==',
            'agent_alias'  => '72fbe1925acddc7a',
            'from_address' => 'noreply@nationalcollege.edu.au',
            'from_name'    => 'National College of Australia',
        );
    }
}

if (!function_exists('crm_smtp_send_mail_direct')) {
    /**
     * Send email via ZeptoMail HTTP API (api.zeptomail.com.au).
     * Kept name for backward compatibility with existing callers.
     */
    function crm_smtp_send_mail_direct($to, $subject, $body, &$error_message = '') {
        $error_message = '';
        $to = trim((string) $to);
        if ($to === '' || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $error_message = 'Invalid recipient email address.';
            return false;
        }
        if (!function_exists('curl_init')) {
            $error_message = 'cURL extension is not available.';
            return false;
        }

        $cfg = crm_zepto_mail_config();
        $to_name = strstr($to, '@', true);
        if ($to_name === false || $to_name === '') {
            $to_name = $to;
        }

        $payload = array(
            'from' => array(
                'address' => $cfg['from_address'],
                'name'    => $cfg['from_name'],
            ),
            'to' => array(
                array(
                    'email_address' => array(
                        'address' => $to,
                        'name'    => $to_name,
                    ),
                ),
            ),
            'subject'  => (string) $subject,
            'htmlbody' => (string) $body,
        );

        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            $error_message = 'Failed to encode email payload as JSON.';
            return false;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => $cfg['api_url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_HTTPHEADER     => array(
                'accept: application/json',
                'authorization: ' . $cfg['auth_token'],
                'cache-control: no-cache',
                'content-type: application/json',
            ),
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ));

        $response = curl_exec($curl);
        $curl_err = curl_error($curl);
        $http_code = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($curl_err !== '') {
            $error_message = 'cURL Error: ' . $curl_err;
            return false;
        }

        $data = is_string($response) ? json_decode($response, true) : null;

        if ($http_code >= 200 && $http_code < 300) {
            return true;
        }

        $api_msg = '';
        if (is_array($data)) {
            if (!empty($data['message'])) {
                $api_msg = (string) $data['message'];
            } elseif (!empty($data['error']['message'])) {
                $api_msg = (string) $data['error']['message'];
            } elseif (!empty($data['error']['details'])) {
                $api_msg = is_string($data['error']['details'])
                    ? $data['error']['details']
                    : json_encode($data['error']['details']);
            }
        }
        if ($api_msg === '' && is_string($response) && $response !== '') {
            $api_msg = substr($response, 0, 500);
        }
        $error_message = 'ZeptoMail API error (HTTP ' . $http_code . ')'
            . ($api_msg !== '' ? ': ' . $api_msg : '');
        return false;
    }
}

if (!function_exists('send_mail')) {
    /**
     * Send email via ZeptoMail API and log result in crm_email_log.
     */
    function send_mail($to, $subject, $body, array $context = array()) {
        global $connection;
        $conn = (isset($connection) && $connection instanceof mysqli) ? $connection : null;

        if (!function_exists('crm_email_log_record')) {
            require_once __DIR__ . '/email_log_helper.php';
        }

        $error_message = '';
        $ok = crm_smtp_send_mail_direct($to, $subject, $body, $error_message);

        if ($conn) {
            $status = $ok ? 'sent' : 'failed';
            crm_email_log_record($conn, $to, $subject, $body, $status, $ok ? null : $error_message, $context);
        }

        return $ok;
    }
}
