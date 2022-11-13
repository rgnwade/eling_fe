<?php

namespace Modules\User\Http\Controllers\Vendor;

use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Core\Entities\Log;
use Modules\Transaction\Http\Requests\SaveTransactionRequest;

class LogController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Log::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'user::permissions.log.index';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::vendor.log';

    /**
     * Form requests for the resource.
     *
     * @var array
     */
    protected $validation = SaveTransactionRequest::class;
}
