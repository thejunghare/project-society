<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    {{-- {{ $getRegisteredSocietiesId }} --}}

    {{-- @foreach ($getRegisteredSocietiesId as $id)
        <p>{{ $id }}</p>
    @endforeach --}}

    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select tab</label>
            <select id="tabs"
                class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option>Statistics</option>
                <option>Services</option>
                <option>FAQ</option>
            </select>
        </div>
        <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse"
            id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
            <li class="w-full">
                <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats"
                    aria-selected="true"
                    class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Statistics</button>
            </li>
        </ul>
        <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel"
                aria-labelledby="stats-tab">
                <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">
                            {{ $registeredSocietiesCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Total Societies</dd>
                    </div> 
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">
                            {{ $registeredSocietyMembersCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Total Members</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">
                            {{ $presidentCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Presidents</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">
                            {{ $vicePresidentCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">
                            Vice presidents
                        </dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">
                            {{ $secretaryCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Secretaries</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold">
                            {{ $treasurerCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Treasurers</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
