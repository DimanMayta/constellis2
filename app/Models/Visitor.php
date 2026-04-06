<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    protected $fillable = [
        'ip_address', 'country', 'city', 'region',
        'browser', 'browser_version', 'platform', 'device_type',
        'url', 'method', 'referrer', 'user_agent',
        'status_code', 'response_time', 'session_id', 'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
                     ->whereYear('created_at', now()->year);
    }

    public function scopeUniqueVisitors($query)
    {
        return $query->distinct('ip_address');
    }

    /**
     * Parse user agent string to extract browser, platform, and device type.
     */
    public static function parseUserAgent(?string $userAgent): array
    {
        if (empty($userAgent)) {
            return [
                'browser' => 'Unknown',
                'browser_version' => null,
                'platform' => 'Unknown',
                'device_type' => 'unknown',
            ];
        }

        $ua = $userAgent;

        // Detect bots first
        $bots = [
            'Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider',
            'YandexBot', 'Sogou', 'facebookexternalhit', 'Twitterbot',
            'LinkedInBot', 'WhatsApp', 'TelegramBot', 'curl', 'wget',
            'python-requests', 'PostmanRuntime', 'Lighthouse', 'PageSpeed',
        ];
        foreach ($bots as $bot) {
            if (stripos($ua, $bot) !== false) {
                return [
                    'browser' => $bot,
                    'browser_version' => null,
                    'platform' => 'Bot',
                    'device_type' => 'bot',
                ];
            }
        }

        // Detect browser
        $browser = 'Unknown';
        $browserVersion = null;

        if (preg_match('/Edg(?:e|A|iOS)?\/(\d+[\.\d]*)/', $ua, $m)) {
            $browser = 'Edge';
            $browserVersion = $m[1];
        } elseif (preg_match('/OPR\/(\d+[\.\d]*)/', $ua, $m)) {
            $browser = 'Opera';
            $browserVersion = $m[1];
        } elseif (preg_match('/Brave/', $ua)) {
            $browser = 'Brave';
            if (preg_match('/Chrome\/(\d+[\.\d]*)/', $ua, $m)) $browserVersion = $m[1];
        } elseif (preg_match('/Vivaldi\/(\d+[\.\d]*)/', $ua, $m)) {
            $browser = 'Vivaldi';
            $browserVersion = $m[1];
        } elseif (preg_match('/Chrome\/(\d+[\.\d]*)/', $ua, $m) && !preg_match('/Chromium/', $ua)) {
            $browser = 'Chrome';
            $browserVersion = $m[1];
        } elseif (preg_match('/Firefox\/(\d+[\.\d]*)/', $ua, $m)) {
            $browser = 'Firefox';
            $browserVersion = $m[1];
        } elseif (preg_match('/Safari\/(\d+[\.\d]*)/', $ua, $m) && preg_match('/Version\/(\d+[\.\d]*)/', $ua, $v)) {
            $browser = 'Safari';
            $browserVersion = $v[1];
        } elseif (preg_match('/MSIE (\d+[\.\d]*)/', $ua, $m)) {
            $browser = 'Internet Explorer';
            $browserVersion = $m[1];
        } elseif (preg_match('/Trident\/.*rv:(\d+[\.\d]*)/', $ua, $m)) {
            $browser = 'Internet Explorer';
            $browserVersion = $m[1];
        }

        // Detect platform/OS
        $platform = 'Unknown';
        if (preg_match('/Windows NT 10/', $ua)) $platform = 'Windows 10/11';
        elseif (preg_match('/Windows NT 6\.3/', $ua)) $platform = 'Windows 8.1';
        elseif (preg_match('/Windows NT 6\.2/', $ua)) $platform = 'Windows 8';
        elseif (preg_match('/Windows NT 6\.1/', $ua)) $platform = 'Windows 7';
        elseif (preg_match('/Windows/', $ua)) $platform = 'Windows';
        elseif (preg_match('/Mac OS X (\d+[_\.]\d+)/', $ua, $m)) $platform = 'macOS ' . str_replace('_', '.', $m[1]);
        elseif (preg_match('/Macintosh/', $ua)) $platform = 'macOS';
        elseif (preg_match('/Android (\d+[\.\d]*)/', $ua, $m)) $platform = 'Android ' . $m[1];
        elseif (preg_match('/Android/', $ua)) $platform = 'Android';
        elseif (preg_match('/iPhone|iPad|iPod/', $ua)) {
            if (preg_match('/OS (\d+[_\.]\d+)/', $ua, $m)) $platform = 'iOS ' . str_replace('_', '.', $m[1]);
            else $platform = 'iOS';
        }
        elseif (preg_match('/Linux/', $ua)) $platform = 'Linux';
        elseif (preg_match('/CrOS/', $ua)) $platform = 'Chrome OS';

        // Detect device type
        $deviceType = 'desktop';
        if (preg_match('/Mobile|Android.*Mobile|iPhone|iPod/', $ua)) $deviceType = 'mobile';
        elseif (preg_match('/Tablet|iPad|Android(?!.*Mobile)/', $ua)) $deviceType = 'tablet';

        return compact('browser', 'browserVersion', 'platform', 'deviceType');
    }

    /**
     * Resolve country from IP using ip-api.com (free, no key needed).
     */
    public static function resolveGeoFromIp(string $ip): array
    {
        $default = ['country' => null, 'city' => null, 'region' => null];

        // Skip local/private IPs
        if (in_array($ip, ['127.0.0.1', '::1']) || filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return array_merge($default, ['country' => 'Local']);
        }

        try {
            $ctx = stream_context_create(['http' => ['timeout' => 2]]);
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=country,regionName,city", false, $ctx);
            if ($response) {
                $data = json_decode($response, true);
                if ($data && ($data['status'] ?? '') !== 'fail') {
                    return [
                        'country' => $data['country'] ?? null,
                        'city' => $data['city'] ?? null,
                        'region' => $data['regionName'] ?? null,
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Silently fail
        }

        return $default;
    }
}
