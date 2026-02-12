<footer class="app-footer border-top bg-body">
    <div class="container-fluid py-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
        <div>
            <strong>&copy; {{ now()->year }}</strong>
            <span class="ms-1">{{ config('app.name', 'Perpustakaan Digital') }}.</span>
            <span>Seluruh hak cipta dilindungi.</span>
        </div>
        <div class="text-muted small">
            Dibangun dengan <a href="https://adminlte.io" target="_blank" rel="noopener">AdminLTE 4</a> &amp; Bootstrap 5.
        </div>
    </div>
</footer>
