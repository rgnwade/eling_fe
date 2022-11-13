<?php

namespace Modules\User\Admin;

use Modules\Admin\Ui\AdminTable;

class VerifyTable extends AdminTable
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
            ->addColumn('register_type', function ($user) {
                return trans('user::auth.'.$user->register_type);
            })
             ->addColumn('register_status', function ($user) {
                return ($user->status);
            });
    }
}
