<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Societies;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('CheckSubscription middleware called');

        $society = $request->route('society');
        Log::info('Society: ' . json_encode($society));

        if (is_object($society) && isset($society->id)) {
            $societyId = $society->id;
        } elseif (is_numeric($society)) {
            $societyId = $society;
        } else {
            Log::error('Invalid society data');
            return redirect()->route('societies')->with('error', 'Invalid society data.');
        }

        Log::info('Society ID: ' . $societyId);

        $society = Societies::find($societyId);
        
        if (!$society) {
            Log::error('Society not found');
            return redirect()->route('societies')->with('error', 'Society not found.');
        }

        $daysLeft = Carbon::now()->diffInDays(Carbon::parse($society->renews_at), false);
        Log::info('Days left: ' . $daysLeft);

        if ($daysLeft <= 0) {
            Log::info('Subscription expired');
            return redirect()->route('societies')->with('error', 'Subscription is over for this society. Access denied.');
        }

        Log::info('Subscription valid. Proceeding.');
        return $next($request);
    }
}