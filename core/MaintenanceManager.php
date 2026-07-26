<?php

namespace Core;

class MaintenanceManager
{
    private array $config;

    public function __construct(ConfigManager $configManager)
    {
        $this->config = $configManager->get('maintenance');
    }

    public function isEnabled(): bool
    {
        $isEnabled = (getenv('APP_ENV') ?: 'production') === 'maintenance';

        if (file_exists(base_path('/storage/framework/maintenance.lock'))) {
            return true;
        }

        return $isEnabled;
    }

    public function isIpAllowed(string $ip): bool
    {
        foreach ($this->config['allowed_ips'] ?? [] as $allowed) {
            if ($this->ipMatches($ip, $allowed)) {
                return true;
            }
        }
        return false;
    }

    private function ipMatches(string $ip, string $allowed): bool
    {
        // Exact match
        if ($ip === $allowed) {
            return true;
        }

        // CIDR support
        if (strpos($allowed, '/') !== false) {
            [$subnet, $mask] = explode('/', $allowed);
            return (ip2long($ip) & ~((1 << (32 - $mask)) - 1))
                === ip2long($subnet);
        }

        return false;
    }

    public function isRouteBypassed(string $uri): bool
    {
        foreach ($this->config['bypass_routes'] ?? [] as $route) {
            if (str_starts_with($uri, $route)) {
                return true;
            }
        }
        return false;
    }
}
