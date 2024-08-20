<div class="my-16">
    {{-- The whole world belongs to you. --}}

    {{-- flash message --}}
    @if (Session::has('success'))
        <x-success-toaster />
    @endif

    {{-- page heading --}}
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16">
            <h1
                class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                Report Issue</h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 lg:px-48 dark:text-gray-400">Have
                We are continuously enhancing mySocietyERP to
                provide a
                seamless
                user experience. Should you encounter any
                difficulties, kindly report the issue through this form for prompt assistance from our team.</p>

        </div>
    </section>

    {{-- form --}}
    <form class="max-w-sm mx-auto" wire:submit='save'>
        <div class="mb-5">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Describe your
                issue</label>
            <input type="text" id="description" wire:model='description'
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Maintenance bill are not being generated." required />
            <div>
                @error('description')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    </form>
</div>
