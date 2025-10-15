{{-- resources/views/notification.blade.php --}}
{{-- resources/views/notification.blade.php --}}
<script>
    @if (session('success'))
        toastr.success("fasfsa");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif
</script>
