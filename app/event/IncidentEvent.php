<?php
declare (strict_types = 1);

namespace app\event;

/**
 * 事件类
 * Class IncidentEvent
 * @package app\event
 */
class IncidentEvent
{
    public $combo;

    public function __construct(string $combo)
    {
        $this->combo = $combo;
        dd($this->combo);
    }
}
