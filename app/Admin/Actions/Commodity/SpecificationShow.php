<?php

namespace App\Admin\Actions\Commodity;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SpecificationShow extends RowAction
{
    public $name = '查看规格';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }
    public function href()
    {
        return '/admin/specification?id=' . $this->getKey();
    }
}
