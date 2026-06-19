<?php
// Base32 decoding/encoding and TOTP verification helper

class GoogleAuthenticatorHelper {
    private static $_base32Chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Generates a random 16-character Base32 secret key.
     */
    public static function generateSecret($length = 16) {
        $secret = '';
        if (function_exists('random_bytes')) {
            $bytes = random_bytes($length);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes($length);
        } else {
            $bytes = '';
            for ($i = 0; $i < $length; $i++) {
                $bytes .= chr(mt_rand(0, 255));
            }
        }
        
        for ($i = 0; $i < $length; $i++) {
            $secret .= self::$_base32Chars[ord($bytes[$i]) & 31];
        }
        return $secret;
    }

    /**
     * Decodes a Base32 string into its binary representation.
     */
    public static function base32Decode($secret) {
        $secret = strtoupper($secret);
        if (!preg_match('/^[A-Z2-7=]+$/', $secret)) {
            return false;
        }
        $secret = str_replace('=', '', $secret);
        $buf = '';
        $val = 0;
        $len = 0;
        $chars = str_split($secret);
        foreach ($chars as $c) {
            $pos = strpos(self::$_base32Chars, $c);
            if ($pos === false) return false;
            $val = ($val << 5) | $pos;
            $len += 5;
            if ($len >= 8) {
                $len -= 8;
                $buf .= chr(($val >> $len) & 0xFF);
            }
        }
        return $buf;
    }

    /**
     * Verifies a 6-digit TOTP code against a secret key, checking current time and discrepancy windows.
     */
    public static function verifyCode($secret, $code, $discrepancy = 1) {
        $key = self::base32Decode($secret);
        if ($key === false) {
            return false;
        }
        $code = str_replace(' ', '', $code);
        if (!preg_match('/^\d{6}$/', $code)) {
            return false;
        }
        
        $time_slice = floor(time() / 30);
        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $slice = $time_slice + $i;
            $binary_time = pack('N*', 0) . pack('N*', $slice);
            $hash = hash_hmac('sha1', $binary_time, $key, true);
            $offset = ord($hash[19]) & 0x0F;
            $binary_code = (
                (ord($hash[$offset]) & 0x7F) << 24 |
                (ord($hash[$offset + 1]) & 0xFF) << 16 |
                (ord($hash[$offset + 2]) & 0xFF) << 8 |
                (ord($hash[$offset + 3]) & 0xFF)
            );
            $otp = $binary_code % 1000000;
            if (str_pad((string)$otp, 6, '0', STR_PAD_LEFT) === $code) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generates a TOTP provisioning URI for setting up Google Authenticator.
     */
    public static function getProvisioningUri($email, $secret, $issuer = 'Auztraining') {
        return 'otpauth://totp/' . rawurlencode($issuer . ':' . $email) . '?secret=' . $secret . '&issuer=' . rawurlencode($issuer);
    }
}
