<?php

namespace Fangorn;

use PHPUnit\Framework\TestCase;
use Exception;

class LibraryTest extends TestCase {
    /**
     * @dataProvider correctTimeIntervals()
     */
    public function testCorrectTimeIntervals(array $timeIntervals, int $expectedDuration) {
        assertEquals($expectedDuration, timeIntervalCrossing($timeIntervals));
    }

    public function testNoIntervals() {
        assertEquals(0, timeIntervalCrossing([]));
    }

    /**
     * @dataProvider incorrectTimeIntervals()
     */
    public function testIncorrectTimeIntervals(array $timeIntervals) {
        self::expectException(Exception::class);
        self::expectExceptionMessage('Некорректный временной интервал: начало позже конца');
        timeIntervalCrossing($timeIntervals);
    }

    public function correctTimeIntervals(): array {
        return [
            //  *-----------*
            //           *------*
            '#1' => [
                'timeIntervals' => [
                    ['begin' => '06-11-2018 14:00:00', 'end' => '07-11-2018 03:00:00'],
                    ['begin' => '07-11-2018 02:30:00', 'end' => '07-11-2018 05:00:00'] ],
                'expectedDuration' => 1800 ],
            //  *------*
            //              *-------*
            '#2' => [
                'timeIntervals' => [
                    ['begin' => '21-05-2017 10:00:00', 'end' => '31-10-2017 15:00:00'],
                    ['begin' => '07-01-2018 14:00:00', 'end' => '29-07-2018 05:00:00'] ],
                'expectedDuration' => 0 ],
            //  *-----------------*
            //     *--------------*
            //        *-------*
            '#3' => [
                'timeIntervals' => [
                    ['begin' => '01-01-1996 10:00:00', 'end' => '31-12-2018 23:59:59'],
                    ['begin' => '01-01-2000 10:00:00', 'end' => '31-12-2018 23:59:59'],
                    ['begin' => '16-12-2018 18:30:00', 'end' => '16-12-2018 19:30:00']],
                'expectedDuration' => 3600 ],
            //  *----------------*
            //            *
            '#4' => [
                'timeIntervals' => [
                    ['begin' => '21-05-2017 10:00:00', 'end' => '31-10-2018 15:00:00'],
                    ['begin' => '07-01-2018 14:00:00', 'end' => '07-01-2018 14:00:00'] ],
                'expectedDuration' => 0 ],
            //  *--------------------------*
            //     *-------*
            //                 *------*
            '#5' => [
                'timeIntervals' => [
                    ['begin' => '05-08-2017 10:00:00', 'end' => '17-06-2018 23:59:59'],
                    ['begin' => '07-08-2017 10:00:00', 'end' => '13-08-2017 23:59:59'],
                    ['begin' => '01-04-2018 18:30:00', 'end' => '20-07-2018 19:30:00']],
                'expectedDuration' => 0 ],
            //  *--------------------------*
            //     *-------*
            //             *------*
            '#6' => [
                'timeIntervals' => [
                    ['begin' => '05-08-2017 10:00:00', 'end' => '17-06-2018 23:59:59'],
                    ['begin' => '07-08-2017 10:00:00', 'end' => '13-08-2017 23:59:59'],
                    ['begin' => '13-08-2017 23:59:59', 'end' => '20-07-2018 19:30:00']],
                'expectedDuration' => 0 ],
            //           *-----*
            //  *----------------------*
            '#7' => [
                'timeIntervals' => [
                    ['begin' => '30-05-2001 00:00:00', 'end' => '01-09-2001 00:00:00'],
                    ['begin' => '01-09-1997 08-30:00', 'end' => '25-05-2008 14:00:00'] ],
                'expectedDuration' => 94 * 24 * 60 * 60 ],
        ];
    }

    public function incorrectTimeIntervals(): array {
        return [
            '#1' => [
                'timeIntervals' => [
                    ['begin' => '06-11-2018 14:00:00', 'end' => '07-11-2018 03:00:00'],
                    ['begin' => '07-11-2018 05:00:00', 'end' => '07-11-2018 02:30:00'] ]
            ]
        ];
    }
}
