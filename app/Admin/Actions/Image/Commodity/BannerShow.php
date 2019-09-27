<?php

namespace App\Admin\Actions\Image\Commodity;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class BannerShow extends RowAction
{
    public $name = '查看展示图';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function href()
    {
        return '/admin/image?type=commodity_banner&commodity_id=' . $this->getKey();
    }
}
