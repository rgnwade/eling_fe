<button type="button" class="btn-sm  btn-primary" data-toggle="modal" data-target="#{{$payment_method}}">
    {{ $title }}
</button>

<div class="modal fade" id="{{$payment_method}}" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                {{ $title }}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body clearfix" style="text-align : left">
                {!! $instruction !!}
            </div>
        </div>
    </div>
</div>
