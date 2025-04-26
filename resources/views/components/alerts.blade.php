@if ($success === true)
    <div id="autoDismissAlert" class="toast align-items-center text-bg-success border-0 show position-fixed bottom-0 end-0 m-4" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 1060;">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <svg class="bi flex-shrink-0" width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                {{ $message }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <script>
        // Fecha o toast automaticamente após 5 segundos
        setTimeout(function () {
            const toastElement = document.getElementById('autoDismissAlert');
            if (toastElement) {
                const toast = bootstrap.Toast.getOrCreateInstance(toastElement);
                toast.hide();
            }
        }, 5000);
    </script>
@endif