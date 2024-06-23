{{-- <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold mb-4">Your Society Membership</h3>
                @if ($member)
                    <p><strong>Society Name:</strong> {{ $member->society->name }}</p>
                    <p><strong>Room Number:</strong> {{ $member->room_number }}</p>
                    <p><strong>Ownership Status:</strong> {{ $member->is_rented ? 'Rented' : 'Owned' }}</p>
                @else
                    <p>You are not currently a member of any society.</p>
                @endif
            </div>
        </div>
    </div>
</div> --}}



<div class="mt-14 w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <h5 class="mb-3 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
        Member of {{ $member->society->name }} society
    </h5>
    
    <dl class="text-sm text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
        <div class="flex justify-between py-2">
            <dt class="text-gray-500 dark:text-gray-400">Room number:</dt>
            <dd class="font-semibold">{{ $member->room_number }}</dd>
        </div>
        <div class="flex justify-between py-2">
            <dt class="text-gray-500 dark:text-gray-400">Owned:</dt>
            <dd class="font-semibold">@if ($member->is_rented)
                <span>Yes</span>
            @else
                <span>No</span>
            @endif</dd>
        </div>
    </dl>
</div>
