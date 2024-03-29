<div id="alert-border-4"
    class="flex items-center p-4 mb-4 text-yellow-800 border-t-4 border-yellow-300 bg-yellow-50 dark:text-yellow-300 dark:bg-gray-800 dark:border-yellow-800"
    role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <div class="ms-3 text-sm font-medium">
        No registered socities found, <a href="#" data-modal-target="add-society-manually-modal"
            data-modal-toggle="add-society-manually-modal" class="font-semibold underline hover:no-underline">Register
            New
            socities</a>. Give it a click to
        register society. OR <a href="#" data-modal-target="add-scoiety-auto-modal"
            data-modal-toggle="add-scoiety-auto-modal" class="font-semibold underline hover:no-underline">Upload CSV,
            Excel</a>
    </div>
</div>

{{-- add scoiety modal manually --}}
<x-add-society-manually-modal-body />
{{-- add scoiety modal auto --}}
<x-add-society-auto-modal-body />
