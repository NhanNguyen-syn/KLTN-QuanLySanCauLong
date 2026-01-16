        {{-- Dynamic Footer with Widget Area --}}
        <footer class="pt-5 text-white" style="background-color:#0f172a">
            <style>
                .footer-widget-col { 
                    flex: 0 0 auto; 
                    width: 240px; 
                    padding: 0 15px; 
                }
                .footer-widget-col:first-child {
                    width: 280px;
                }
                .footer-widget-title { color: #fff; font-size: 1.125rem; }
                .footer-widget-content a { transition: color 0.2s ease; }
                .footer-widget-content a:hover { color: #10b981 !important; }
                .social-icon:hover { background: rgba(16, 185, 129, 0.2) !important; color: #10b981 !important; }
                @media (max-width: 992px) { 
                    .footer-widget-col,
                    .footer-widget-col:first-child { 
                        flex: 1 1 calc(50% - 30px); 
                        width: auto;
                        margin-bottom: 2rem; 
                    }
                }
                @media (max-width: 576px) { 
                    .footer-widget-col,
                    .footer-widget-col:first-child { 
                        flex: 1 1 100%; 
                        width: 100%;
                    }
                    .d-flex.gap-4 { 
                        gap: 0 !important;
                    }
                }
            </style>
            <div class="container px-3 px-lg-4">
                {{-- Footer Sidebar - Horizontal Layout --}}
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex flex-wrap gap-4 justify-content-between">
                            {!! dynamic_sidebar('footer_sidebar') !!}
                        </div>
                    </div>
                </div>
            </div>
            {{-- bottom bar --}}
            <div class="mt-5" style="background-color:#0a101f">
                <div class="container py-3">
                    {!! dynamic_sidebar('footer_bottom_bar') !!}
                </div>
            </div>
        </footer>


            <!-- Booking summary script is lightweight and safe to include globally -->
            <script src="{{ Theme::asset()->url('js/booking-summary.js') }}"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    if (window.lucide && typeof window.lucide.createIcons === 'function') {
                        window.lucide.createIcons();
                    }
                });
            </script>
        {!! Theme::footer() !!}
    </body>
</html>
