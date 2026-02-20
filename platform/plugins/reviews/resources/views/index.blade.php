@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="row">
        <div class="col-12">
            {!! $table->renderTable() !!}
        </div>
    </div>
    
    @include('plugins/reviews::partials.analyze-modal')
@endsection

@push('footer')
    <script src="{{ asset('vendor/core/plugins/reviews/js/reviews-admin.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Re-bind events when table reloads (pjax/ajax)
            $(document).on('draw.dt', function () {
                // Any re-init logic if needed
            });
        });
    </script>
@endpush
