<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Societies;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckSocietySubscription
{
    public function handle(Request $request, Closure $next)
    {
        $societyId = $request->route('society');
        Log::info("Checking society with ID: " . $societyId);

        $society = Societies::find($societyId);

        if (!$society) {
            Log::error("Society not found with ID: " . $societyId);
            return redirect()->route('societies')->with('error', 'Society not found.');
        }

        $daysLeft = Carbon::now()->diffInDays(Carbon::parse($society->renews_at), false);
        Log::info("Days left for society {$societyId}: " . $daysLeft);

        if ($daysLeft <= 0) {
            Log::info("Subscription over for society {$societyId}");
            return redirect()->route('societies')->with('error', 'Subscription is over for this society. Access denied.');
        }

        Log::info("Access granted for society {$societyId}");
        return $next($request);
    }
}