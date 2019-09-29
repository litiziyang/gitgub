<?php

namespace App\Admin\Actions\Commodity;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Specification extends RowAction
{
    public $name = '添加规格';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }
    public function href()
    {
        return '/admin/specification/create?commodity_id=' . $this->getKey();
    }
}
