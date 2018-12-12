<?php

namespace Fangorn;
use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase {
    public function testTimeDifference() {
        $timer = new Timer('now');
        $timer->addWeeks(2);
        assertEquals('14 дней', $timer->getFormattedString());
    }
}
