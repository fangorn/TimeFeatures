<?php

function timeIntervalCrossing(array $intervals): int {
    if (empty($intervals)) {
        return  0;
    }

    $timestampIntervals = [];
    foreach ($intervals as $interval) {
        $begin = strtotime($interval['begin']);
        $end   = strtotime($interval['end']);
        if ($begin > $end) {
            throw new Exception('Некорректный временной интервал: начало позже конца');
        }
        $timestampIntervals[] = [$begin, $end];
    }

    [$resultBegin, $resultEnd] = $timestampIntervals[0];

    for ($i = 1; $i < count($timestampIntervals) && $resultEnd - $resultBegin > 0; $i++) {
        [$begin, $end] = $timestampIntervals[$i];
        if (($begin > $resultEnd) || ($end < $resultBegin)) {
            return 0;
        }

        $resultBegin = max($resultBegin, $begin);
        $resultEnd   = min($resultEnd, $end);
    }

    return $resultEnd - $resultBegin;
}

