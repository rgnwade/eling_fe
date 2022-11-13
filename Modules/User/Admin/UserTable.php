<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;
use Modules\User\Entities\Role;

class UserTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected $rawColumns = ['last_login', 'roles' ];

    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('last_login', function ($user) {
                return view('admin::partials.table.date')->with('date', $user->last_login);
            })
             ->addColumn('roles', function ($user) {
                return $user->firstRoles();
            })
             ->addColumn('chat_admin', function ($user) {
                return ($user->chat_admin ? '✓'  : '-' );
            });
    }
}
