<?php

namespace App\Services;

use Illuminate\Support\Str;

class WorldpaySignatureVerifier
{
    public static function verify(string $rawBody, ?string $signatureHeader): bool
    {
        if (empty($signatureHeader)) {
            return false;
        }

        $secretsJson = config('lunar.payments.worldpay.webhook_secrets');
        $fallbackSecret = config('lunar.payments.worldpay.webhook_secret');

        $secrets = [];
        if (! empty($secretsJson)) {
            $decoded = json_decode($secretsJson, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $secrets = $decoded;
            }
        }
        if (empty($secrets) && $fallbackSecret) {
            $secrets = ['default' => $fallbackSecret];
        }

        $parts = array_map('trim', explode(',', $signatureHeader));

        foreach ($parts as $part) {
            if (Str::startsWith(strtolower($part), 'sha256=')) {
                $candidate = substr($part, 7);
                foreach ($secrets as $k => $s) {
                    if (self::matchAgainstSecret($rawBody, $candidate, $s, 'SHA256')) {
                        return true;
                    }
                }

                continue;
            }

            if (! preg_match('#^([^/]+)/([^/]+)/(.+)$#', $part, $m)) {
                continue;
            }

            [$all, $keyId, $hashFn, $signature] = $m;

            $secret = $secrets[$keyId] ?? ($secrets['default'] ?? null);
            if (! $secret) {
                continue;
            }

            if (self::matchAgainstSecret($rawBody, $signature, $secret, strtoupper($hashFn))) {
                return true;
            }
        }

        return false;
    }

    protected static function matchAgainstSecret(string $rawBody, string $signatureFromHeader, string $secret, string $hashFn): bool
    {
        if ($hashFn !== 'SHA256') {
            return false;
        }

        $rawHmac = hash_hmac('sha256', $rawBody, $secret, true);

        $expectedBase64 = base64_encode($rawHmac);
        if (hash_equals($expectedBase64, $signatureFromHeader)) {
            return true;
        }

        $expectedHex = bin2hex($rawHmac);
        if (hash_equals($expectedHex, strtolower($signatureFromHeader)) || hash_equals(strtoupper($expectedHex), $signatureFromHeader)) {
            return true;
        }

        return false;
    }
}
