<?php

namespace App\Services\Auth;

/**
 * Self-contained TOTP (RFC 6238) implementation compatible with Google
 * Authenticator / Authy. Avoids pulling an external 2FA dependency.
 */
class TwoFactorService
{
    private const PERIOD = 30;

    private const DIGITS = 6;

    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    /**
     * Generate a random base32 secret.
     */
    public function generateSecret(int $length = 16): string
    {
        $secret = '';
        $max = strlen(self::ALPHABET) - 1;

        for ($i = 0; $i < $length; $i++) {
            $secret .= self::ALPHABET[random_int(0, $max)];
        }

        return $secret;
    }

    /**
     * Verify a user-supplied code against the secret, allowing a +/- window
     * of time-steps to account for clock drift.
     */
    public function verify(string $secret, string $code, int $window = 1): bool
    {
        $code = preg_replace('/\s+/', '', $code);

        if (! preg_match('/^\d{6}$/', (string) $code)) {
            return false;
        }

        $timeStep = (int) floor(time() / self::PERIOD);

        for ($i = -$window; $i <= $window; $i++) {
            if (hash_equals($this->codeAt($secret, $timeStep + $i), $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Build the otpauth:// URI to render as a QR code in the client.
     */
    public function otpauthUri(string $issuer, string $account, string $secret): string
    {
        return sprintf(
            'otpauth://totp/%s:%s?secret=%s&issuer=%s&algorithm=SHA1&digits=%d&period=%d',
            rawurlencode($issuer),
            rawurlencode($account),
            $secret,
            rawurlencode($issuer),
            self::DIGITS,
            self::PERIOD,
        );
    }

    /**
     * Compute the TOTP code for a given time-step.
     */
    private function codeAt(string $secret, int $timeStep): string
    {
        $key = $this->base32Decode($secret);
        $binary = pack('N*', 0).pack('N*', $timeStep); // 8-byte big-endian counter
        $hash = hash_hmac('sha1', $binary, $key, true);

        $offset = ord($hash[strlen($hash) - 1]) & 0x0F;
        $value = (
            ((ord($hash[$offset]) & 0x7F) << 24) |
            ((ord($hash[$offset + 1]) & 0xFF) << 16) |
            ((ord($hash[$offset + 2]) & 0xFF) << 8) |
            (ord($hash[$offset + 3]) & 0xFF)
        ) % (10 ** self::DIGITS);

        return str_pad((string) $value, self::DIGITS, '0', STR_PAD_LEFT);
    }

    /**
     * Decode a base32 secret into raw bytes.
     */
    private function base32Decode(string $secret): string
    {
        $secret = rtrim(strtoupper($secret), '=');
        $bits = '';

        foreach (str_split($secret) as $char) {
            $position = strpos(self::ALPHABET, $char);

            if ($position === false) {
                continue;
            }

            $bits .= str_pad(decbin($position), 5, '0', STR_PAD_LEFT);
        }

        $bytes = '';

        foreach (str_split($bits, 8) as $chunk) {
            if (strlen($chunk) === 8) {
                $bytes .= chr(bindec($chunk));
            }
        }

        return $bytes;
    }
}
