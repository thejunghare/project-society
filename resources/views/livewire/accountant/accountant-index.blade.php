<div class="mt-4">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    <div class="w-full bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 mt-4">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select tab</label>
            <select id="tabs"
                class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-lg rounded-t-lg focus:ring-mygreen-500 focus:border-mygreen-500 block w-full p-3 shadow-md dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-mygreen-500 dark:focus:border-mygreen-500">
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
                    class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-mygreen-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-mygreen-600 shadow-md font-bold text-xl md:text-2xl lg:text-2xl " style="color: black;">Statistics</button>
            </li>
        </ul>
        <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800 shadow-md" id="stats" role="tabpanel"
                aria-labelledby="stats-tab">
                <dl
                    class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg">
                        <dt class="mb-2 text-3xl font-extrabold text-mygreen-600">
                            {{ $registeredSocietiesCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Total Societies</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg">
                        <dt class="mb-2 text-3xl font-extrabold text-mygreen-600">
                            {{ $registeredSocietyMembersCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Total Members</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg">
                        <dt class="mb-2 text-3xl font-extrabold text-mygreen-600">
                            {{ $presidentCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Presidents</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg">
                        <dt class="mb-2 text-3xl font-extrabold text-mygreen-600">
                            {{ $vicePresidentCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Vice Presidents</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg">
                        <dt class="mb-2 text-3xl font-extrabold text-mygreen-600">
                            {{ $secretaryCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Secretaries</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center p-4 rounded-lg">
                        <dt class="mb-2 text-3xl font-extrabold text-mygreen-600">
                            {{ $treasurerCount }}
                        </dt>
                        <dd class="text-gray-500 dark:text-gray-400">Treasurers</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
