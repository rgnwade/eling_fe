<div class="order-information-wrapper">
    <h3 class="section-title">{{ trans('order::orders.items_ordered') }}</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="items-ordered">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('order::orders.no') }}</th>
                                <th>{{ trans('order::orders.product') }}</th>
                                <th>{{ trans('order::orders.quantity') }}</th>
                                <th>{{ trans('order::orders.unit_price') }}</th>
                                <th>{{ trans('order::orders.line_total') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                                @foreach ($order_products as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($item->trashed())
                                            {{ $item->name }}
                                        @else
                                            <a href="{{ route('admin.products.edit', $item->product->id) }}">{{ $item->name }}</a>
                                        @endif

                                        @if ($item->hasAnyOption())
                                            <br>
                                            @foreach ($item->options as $option)
                                            <span>
                                                {{ $option->name }}:
                                                <span>{{ $option->values->implode('label', ', ') }}</span>
                                            </span>
                                            @endforeach
                                        @endif
                                    </td>
                                     <td>{{ $item->qtyRemarks() }}</td>

                                    <td>
                                        {{ $item->unit_price_vendor()->format($item->product->vendor_currency)}}
                                    </td>
                                    <td>
                                        {{ $item->line_total_vendor()->format($item->product->vendor_currency)}}
                                    </td>
                                </tr>
                                @endforeach
                            <tr>
                                <td colspan="4" >  {{ trans('order::orders.subtotal') }} :  </td>
                                <td >{{ $company_order->formatted_total_vendor }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
