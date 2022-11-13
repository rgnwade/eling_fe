<div class="modal fade" id="update-order" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>

                <h4 class="modal-title">Confirmation</h4>
            </div>

            <div class="modal-body">
                <div class="clearfix">
                    <h4> {{ trans('storefront::account.view_order.complete_confirmation') }}</h4>
                </div>
            </div>

            <div class="modal-body">
                <div class="clearfix">
                    <form method="POST" action="{{ route('account.orders.completed', $order) }}">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                        <button type="submit" class="btn-sm btn-primary">
                            {{ trans('storefront::account.view_order.confirm') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
