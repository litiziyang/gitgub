<?php

namespace App\Admin\Actions\Image\Commodity;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class DetailsShow extends RowAction
{
    public $name = '查看详情图';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function href()
    {
        return '/admin/image?type=commodity_details&commodity_id=' . $this->getKey();
    }
}
