<div class="items-ordered-wrapper">
    <h3 class="section-title">{{ trans('order::orders.items_ordered') }}</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="items-ordered">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ trans('order::orders.product') }}</th>
                                <th>{{ trans('order::orders.quantity') }}</th>
                                <th>{{ trans('order::orders.unit_price') }}</th>
                                <th>{{ trans('order::orders.unit_price_vendor') }}</th>
                                <th>{{ trans('order::orders.line_total') }}</th>
                                <th>{{ trans('order::orders.line_total_vendor') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($order_products_company as $order_product)
                            <tr>
                                <th colspan="6"> <a style="color: #337ab7"
                                        href="{{ route('admin.orders_vendor.show',  [$order->id, $order_product->company->id]) }}">
                                        {{$order_product->company->name }} </a>
                                    <p>  Status :  {{$order_product->company_order->status }} </p></th>
                            </tr>
                            @foreach ($order_product->items as $item)
                            <tr>
                                <td>
                                    @if ($item->trashed())
                                    {{ $item->name }}
                                    @else
                                    <a
                                        href="{{ route('admin.products.edit', $item->product->id) }}">{{ $item->name }}</a>
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
                                    {{ $item->unit_price->format($order->currency) }}
                                </td>
                                <td>
                                    {{ $item->unit_price_vendor()->format($item->product->vendor_currency)}}
                                </td>
                                <td>
                                    {{ $item->line_total->format($order->currency) }}
                                </td>
                                <td>
                                    {{ $item->line_total_vendor()->format($item->product->vendor_currency)}}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"> {{ trans('order::orders.subtotal') }} : </td>
                                <td> {{$order_product->sum_line_total->format()}} </td>
                                <td>{{$order_product->sum_line_total_vendor->format()}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
