<div class="modal fade" id="resi_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>

                        <h6 class="modal-title" id="exampleModalLabel">STATUS : @{{status}}</h6>

                    </div>
                    <div class="modal-body clearfix">

                        <table  class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('storefront::account.orders.date') }}</th>
                                    <th>{{ trans('storefront::account.orders.description') }}</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: left;">
                                <tr v-for='data in manifest'>
                                    <td>@{{(data.manifest_date)| moment("d MMM YYYY")}} @{{data.manifest_time}}</td>
                                    <td style="width:70%">@{{data.manifest_description}}</td>
                                </tr>
                            </tbody>
                        </table>
                         <span id="loading" > Loading.. </span>
                    </div>
                </div>
            </div>
        </div>
