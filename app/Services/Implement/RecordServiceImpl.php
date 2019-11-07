<?php


namespace App\Services\Implement;


use App\Record;
use App\Services\RecordService;

class RecordServiceImpl implements RecordService
{
    protected $recordRepository;

    public function __construct(Record $record)
    {
        $this->recordRepository = $record->query();
    }

    /**
     * @param integer $user_id
     * @param integer $commodity_id
     *
     * @return bool 是否增加view次数
     */
    public function view($user_id, $commodity_id): bool
    {
        $record = $this->recordRepository
            ->where('user_id', $user_id)
            ->where('commodity_id', $commodity_id)
            ->orderBy('id', 'desc')
            ->first();
        // 获取当前用户对当前商品的最后一次浏览记录
        if (!$record) {
            // 如果没有浏览记录，创建一个并返回true
            $this->recordRepository->firstOrCreate([
                'user_id'      => $user_id,
                'commodity_id' => $commodity_id,
            ]);
            return true;
        }
        // 判断浏览记录和本次的时间差
        if ((strtotime($record->created_at) + (60 * 30)) < time()) {
            // 如果事件差够长，达到30分钟以上，更新浏览时间并返回true
            $record->updated_at = time();
            $record->save();
            return true;
        } else {
            // 如果时间不足，更新时间并返回false
            $record->updated_at = time();
            $record->save();
            return false;
        }
    }

    /**
     * 获取用户浏览记录前6位
     *
     * @param integer $user_id
     *
     * @return mixed 记录列表
     */
    public function getHistory($user_id)
    {
        $history = $this->recordRepository
            ->with('commodity')
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();
        return $history;
    }
}
