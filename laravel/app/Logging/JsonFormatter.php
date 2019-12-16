<?php
namespace App\Logging;

use Monolog\Formatter\JsonFormatter as BaseJsonFormatter;

class JsonFormatter extends BaseJsonFormatter
{
    public function format(array $record)
    {
        // 这个就是最终要记录的数组，最后转成Json并记录进日志
        $newRecord = [
            'time' => $record['datetime']->format('Y-m-d H:i:s'),
            'message' => $record['message'],
        ];

        if (!empty($record['context'])) {
            $newRecord = array_merge($newRecord, $record['context']);
        }
        //$json = 'aaa,bbb,ccc';  // 这是最终返回的记录串，可以按自己的需求改
        $json = $this->toJson($this->normalize($newRecord), true) . ($this->appendNewline ? "\n" : '');

        return $json;
    }
}
