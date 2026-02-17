<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class LoadSmtpSettings
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Get SMTP settings from database
            $smtpHost = Setting::where('key', 'smtp_host')->value('value');
            
            if ($smtpHost) {
                // Set mail configuration dynamically from database
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp.host', $smtpHost);
                Config::set('mail.mailers.smtp.port', Setting::where('key', 'smtp_port')->value('value') ?? 587);
                Config::set('mail.mailers.smtp.username', Setting::where('key', 'smtp_username')->value('value'));
                Config::set('mail.mailers.smtp.password', Setting::where('key', 'smtp_password')->value('value'));
                Config::set('mail.mailers.smtp.encryption', Setting::where('key', 'smtp_encryption')->value('value') ?? 'tls');
                
                // Set from address and name
                $fromAddress = Setting::where('key', 'smtp_from_address')->value('value') 
                    ?? Setting::where('key', 'smtp_username')->value('value');
                $fromName = Setting::where('key', 'site_name')->value('value') ?? 'Acewebx';
                
                Config::set('mail.from.address', $fromAddress);
                Config::set('mail.from.name', $fromName);
                
                Log::info('SMTP settings loaded from database', [
                    'host' => $smtpHost,
                    'port' => Config::get('mail.mailers.smtp.port'),
                    'from' => $fromAddress,
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to load SMTP settings from database: ' . $e->getMessage());
        }

        return $next($request);
    }
}
