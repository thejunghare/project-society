<div id="toast-{{ $type }}"
    class="mt-12 fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
    role="alert">
    <div
        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-{{ $type == 'success' ? 'green' : ($type == 'error' ? 'red' : 'blue') }}-500 bg-{{ $type == 'success' ? 'green' : ($type == 'error' ? 'red' : 'blue') }}-100 rounded-lg dark:bg-{{ $type == 'success' ? 'green' : ($type == 'error' ? 'red' : 'blue') }}-800 dark:text-{{ $type == 'success' ? 'green' : ($type == 'error' ? 'red' : 'blue') }}-200">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
        </svg>
        <span class="sr-only">{{ $type }} icon</span>
    </div>
    <div class="ms-3 text-sm font-normal">
        {{ $message }}
    </div>
    <button type="button"
        class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
        data-dismiss-target="#toast-{{ $type }}" aria-label="Close" onclick="removeToast('toast-{{ $type }}')">
        <span class="sr-only">Close</span>
        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        setTimeout(() => {
            removeToast('toast-{{ $type }}');
        }, 5000);
    });

    function removeToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            toast.style.opacity = '0';
            setTimeout(() => {
                toast.remove();
            }, 500); // Transition duration to fade out
        }
    }
</script>
