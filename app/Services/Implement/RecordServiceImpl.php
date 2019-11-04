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
        if (!$record) {
            return true;
        }
        if ((strtotime($record->created_at) + (60 * 30)) < time()) {
            $this->recordRepository->create([
                'user_id'      => $user_id,
                'commodity_id' => $commodity_id,
            ]);
            return true;
        } else {
            $record->updated_at = time();
            $record->save();
            return false;
        }
    }
}
