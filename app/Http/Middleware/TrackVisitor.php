<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    /**
     * Paths to exclude from tracking.
     */
    protected array $excludedPaths = [
        'admin*',
        'livewire*',
        'favicon.ico',
        '_debugbar*',
        'sanctum*',
        'css/*',
        'js/*',
        'build/*',
        'storage/*',
        'vendor/*',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $response = $next($request);
        $responseTime = round((microtime(true) - $startTime) * 1000, 2);

        // Only track GET requests to actual pages (not assets/admin)
        if ($request->isMethod('GET') && !$this->shouldExclude($request)) {
            $this->recordVisit($request, $response, $responseTime);
        }

        return $response;
    }

    protected function shouldExclude(Request $request): bool
    {
        foreach ($this->excludedPaths as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        // Exclude asset requests
        $path = $request->path();
        $assetExtensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot', 'map', 'webp'];
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if (in_array(strtolower($extension), $assetExtensions)) {
            return true;
        }

        return false;
    }

    protected function recordVisit(Request $request, Response $response, float $responseTime): void
    {
        try {
            $ip = $request->ip();
            $userAgent = $request->userAgent();

            // Parse user agent
            $parsed = Visitor::parseUserAgent($userAgent);

            // Resolve geo (async-friendly: we do it inline but with a 2s timeout)
            $geo = Visitor::resolveGeoFromIp($ip);

            Visitor::create([
                'ip_address' => $ip,
                'country' => $geo['country'],
                'city' => $geo['city'],
                'region' => $geo['region'],
                'browser' => $parsed['browser'],
                'browser_version' => $parsed['browserVersion'] ?? null,
                'platform' => $parsed['platform'],
                'device_type' => $parsed['deviceType'] ?? 'desktop',
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'referrer' => $request->header('referer'),
                'user_agent' => $userAgent,
                'status_code' => $response->getStatusCode(),
                'response_time' => $responseTime,
                'session_id' => session()->getId(),
                'user_id' => $request->user()?->id,
            ]);
        } catch (\Throwable $e) {
            // Never let tracking break the site
            report($e);
        }
    }
}
