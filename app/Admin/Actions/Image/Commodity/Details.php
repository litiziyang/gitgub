<?php

namespace App\Admin\Actions\Image\Commodity;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Details extends RowAction
{
    public $name = '添加详情图';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function href()
    {
        return '/admin/image/create?type=details&commodity_id=' . $this->getKey();
    }
}
