<div class="table-responsive anchor-table">
    <table class="table">
        <thead>
            <tr>
                <td>{{trans('company::company.tabs.name')}}</td>
                <td>{{trans('company::company.tabs.email')}}</td>
                <td>{{trans('company::company.tabs.action')}}</td>
            </tr>
        </thead>
        <tbody>
            @forelse($company->users as $user)
            <tr>
                <td>{{$user->fullname}}</td>
                <td>{{$user->email}}</td>
                <td> <a href="{{route('admin.users.edit', ['id' => $user->id])}}"> {{trans('company::company.tabs.detail')}} </a></td>
            </tr>
            @empty
                <tr>
                    <td class="empty" colspan="5">{{ trans('admin::dashboard.no_data') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="clearfix"></div>
