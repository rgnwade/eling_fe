<?php

namespace Modules\User\Http\Controllers\Vendor;

use Modules\User\Entities\Role;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\User\Http\Requests\SaveRoleRequest;

class RoleController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::roles.role';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::vendor.roles';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveRoleRequest::class;
}
