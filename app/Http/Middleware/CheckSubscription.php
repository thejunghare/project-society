<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Societies;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $societyId = $request->route('society');
        $society = Societies::findOrFail($societyId);

        // Check if subscription is over
        if ($society->is_subscription_over) {
            return redirect('/accountant/manage/societies')->with('error', 'Subscription for this society is over.');
        }

        return $next($request);
    }
}
