<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> © {{ $option['site-title']->value ?? config('app.name', 'Laravel') }}.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    versi 0.0.001
                </div>
            </div>
        </div>
    </div>
</footer>