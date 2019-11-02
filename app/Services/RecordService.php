<?php


namespace App\Services;


interface RecordService
{
    /**
     * @param integer $user_id
     * @param integer $commodity_id
     *
     * @return bool 是否增加view次数
     */
    public function view($user_id, $commodity_id): bool;
}
