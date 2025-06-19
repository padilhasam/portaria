<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            toastr.success("{{ session('success') }}", 'Sucesso', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right',
                timeOut: 5000
            });
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}", 'Erro', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right',
                timeOut: 5000
            });
        @endif

        @if (session('warning'))
            toastr.warning("{{ session('warning') }}", 'Atenção', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right',
                timeOut: 5000
            });
        @endif

        @if (session('info'))
            toastr.info("{{ session('info') }}", 'Informação', {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right',
                timeOut: 5000
            });
        @endif
    });
</script>