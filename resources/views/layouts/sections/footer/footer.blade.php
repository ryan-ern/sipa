@php
    $containerFooter = !empty($containerNav) ? $containerNav : 'container-fluid';
@endphp

<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="{{ $containerFooter }}">
        <div class="footer-container d-flex align-items-center justify-content-end py-4 flex-md-row flex-column">
            <div class="text-body">
                Copyright
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>, SIPA - UPTD PSAA Harapan Bangsa
            </div>
        </div>
    </div>
</footer>
<!--/ Footer -->
