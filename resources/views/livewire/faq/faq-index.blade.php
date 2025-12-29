<div class="mt-14">
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Frequently Asked Questions</h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">Have
                questions? We've got answers.
                Explore our comprehensive FAQ section to find answers to common questions about account management,
                service details, billing, and more. If you can't find what you're looking for, our support team is just
                a click away.</p>

        </div>
    </section>

    {{-- Divider --}}
    <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded md:my-10 dark:bg-gray-700" />

    {{-- Questions & Answers --}}
    @if (!empty($records))

        @foreach ($records as $record)
            <div id="accordion-{{ $loop->index }}" data-accordion="collapse"
                data-active-classes="bg-white dark:bg-gray-900 text-gray-900 dark:text-white"
                data-inactive-classes="text-gray-500 dark:text-gray-400" class="mt-4">
                <h2 id="accordion-heading-{{ $loop->index }}">
                    <button type="button"
                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                        data-accordion-target="#accordion-body-{{ $loop->index }}" aria-expanded="false"
                        aria-controls="accordion-body-{{ $loop->index }}">
                        {{-- Question --}}
                        <span>{{ $record->question }}</span>

                        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-body-{{ $loop->index }}" class="hidden"
                    aria-labelledby="accordion-heading-{{ $loop->index }}">
                    <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                        {{-- Answer --}}
                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                            {{ $record->answer }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

        {{ $records->links() }}

    @endif
</div>
