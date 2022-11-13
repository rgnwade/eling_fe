<?php

namespace Modules\Company\Admin;

use Modules\Admin\Ui\AdminTable;

class CompanyTable extends AdminTable
{
    /**
     * Make table response for the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('type', function ($company) {
                return $company->type();
            })
            ->addColumn('country', function ($company) {
                return $company->country->name;
            });
    }
}
