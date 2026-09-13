<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebsiteConfigurations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(config('database.connections.mysql.database') != 'db_name'){
            $app_name = get_settings('website_title');
            $timezone = get_settings('timezone');
            $smtp = get_settings('smtp_settings', true);
            config(
                [
                    //System configuration
                    'app.name' => $app_name,
                    'app.timezone' => $timezone,

                    //SMTP configuration
                    'mail.mailers.smtp.transport' => $smtp['protocol'],
                    'mail.mailers.smtp.host' => $smtp['host'],
                    'mail.mailers.smtp.port' => $smtp['port'],
                    'mail.mailers.smtp.encryption' => $smtp['security'],
                    'mail.mailers.smtp.username' => $smtp['username'],
                    'mail.mailers.smtp.password' => $smtp['password'],
                    'mail.mailers.smtp.timeout' => null,
                    'mail.mailers.smtp.local_domain' => $_SERVER['SERVER_NAME'],
                    'mail.from.name' => $app_name,
                    'mail.from.address' => $smtp['from_email'],
                ]
            );
        }

        return $next($request);
    }
}
