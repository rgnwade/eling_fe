@section('content')
    <div class="row">
        <div class="btn-group pull-right">
            @if (isset($buttons, $name))
                @foreach($buttons as $view)
                    <a href="{{ route("vendor.{$resource}.{$view}") }}" class="btn btn-primary btn-actions btn-{{ $view }}">
                        {{ trans("admin::resource.{$view}", ['resource' => $name]) }}
                    </a>
                @endforeach
            @else
                {{ $buttons ?? '' }}
            @endif
        </div>
    </div>

    <div class="box box-primary">
        <div class="box-body index-table" id="{{ isset($resource) ? "{$resource}-table" : '' }}">
            @if (isset($thead))
                @include('admin::components.table')
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
@endsection

@isset($name)
    @push('shortcuts')
        @if (isset($buttons) && in_array('create', $buttons))
            <dl class="dl-horizontal">
                <dt><code>c</code></dt>
                <dd>{{ trans('admin::resource.create', ['resource' => $name]) }}</dd>
            </dl>
        @endif

        <dl class="dl-horizontal">
            <dt><code>Del</code></dt>
            <dd>{{ trans('admin::resource.delete', ['resource' => $name]) }}</dd>
        </dl>
    @endpush

    @push('scripts')
        <script>
            @if (isset($buttons) && in_array('create', $buttons))
                keypressAction([
                    { key: 'c', route: '{{ route("vendor.{$resource}.create") }}'}
                ]);
            @endif

            Mousetrap.bind('del', function () {
                $('{{ $selector ?? '' }} .btn-delete').trigger('click');
            });

            @isset($resource)
                DataTable.setRoutes('#{{ $resource }}-table .table', {
                    index: '{{ "vendor.{$resource}.index" }}',
                    edit: '{{ "vendor.{$resource}.edit" }}',
                    destroy: '{{ "vendor.{$resource}.destroy" }}',
                });
            @endisset
        </script>
    @endpush
@endisset
