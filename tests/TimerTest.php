<?php

namespace Fangorn;

use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase {

    protected function setUp() {
        parent::setUp();

        Timer::setTestMode();
    }

    public function testSimple() {
        $timer = new Timer('2020-01-01 00:00:00');
        assertEquals('1 год 9 месяцев 6 дней 10 часов', $timer->getFormattedString());
    }

    /**
     * @dataProvider yearsCases()
     */
    public function testAddYears(int $givenArgument, string $expectedPhrase) {
        $timer = new Timer();
        $timer->addYears($givenArgument);
        assertEquals($expectedPhrase, $timer->getFormattedString());
    }

    public function yearsCases(): array {
        return [
            '#1' => ['givenArgument'  =>  4,
                     'expectedPhrase' => '4 года'],
            '#2' => ['givenArgument'  => -4,
                     'expectedPhrase' => '4 года'],
            '#3' => ['givenArgument'  =>  1,
                     'expectedPhrase' => '1 год'],
            '#4' => ['givenArgument'  => -1,
                     'expectedPhrase' => '1 год'],
            '#5' => ['givenArgument'  =>  8,
                     'expectedPhrase' => '8 лет'],
            '#6' => ['givenArgument'  => -8,
                     'expectedPhrase' => '8 лет']
        ];
    }

    /**
     * @dataProvider monthsCases()
     */
    public function testAddMonths(int $givenArgument, string $expectedPhrase) {
        $timer = new Timer('now');
        $timer->addMonth($givenArgument);
        assertEquals($expectedPhrase, $timer->getFormattedString());
    }

    public function monthsCases(): array {
        return [
            '#1' => ['givenArgument'  =>  4,
                     'expectedPhrase' => '4 месяца'],
            '#2' => ['givenArgument'  => -4,
                     'expectedPhrase' => '4 месяца'],
            '#3' => ['givenArgument'  =>  1,
                     'expectedPhrase' => '1 месяц'],
            '#4' => ['givenArgument'  => -1,
                     'expectedPhrase' => '1 месяц'],
            '#5' => ['givenArgument'  =>  8,
                     'expectedPhrase' => '8 месяцев'],
            '#6' => ['givenArgument'  => -8,
                     'expectedPhrase' => '8 месяцев'],
            '#7' => ['givenArgument'  => 49,
                     'expectedPhrase' => '4 года 1 месяц'],
            '#8' => ['givenArgument'  => -49,
                     'expectedPhrase' => '4 года 1 месяц'],

        ];
    }

    /**
     * @dataProvider weeksCases()
     */
    public function testAddWeeks(int $givenArgument, string $expectedPhrase) {
        $timer = new Timer('now');
        $timer->addWeeks($givenArgument);
        assertEquals($expectedPhrase, $timer->getFormattedString());
    }

    public function weeksCases(): array {
        return [
            '#1' => ['givenArgument'  =>  4,
                     'expectedPhrase' => '28 дней'],
            '#2' => ['givenArgument'  => -4,
                     'expectedPhrase' => '1 месяц'], // Потому что попали в февааль
            '#3' => ['givenArgument'  =>  1,
                     'expectedPhrase' => '7 дней'],
            '#4' => ['givenArgument'  => -1,
                     'expectedPhrase' => '7 дней'],
            '#5' => ['givenArgument'  =>  3,
                     'expectedPhrase' => '21 день'],
            '#6' => ['givenArgument'  => -3,
                     'expectedPhrase' => '21 день']
        ];
    }

    /**
     * @dataProvider daysCases()
     */
    public function testAddDays(int $givenArgument, string $expectedPhrase) {
        $timer = new Timer('now');
        $timer->addDays($givenArgument);
        assertEquals($expectedPhrase, $timer->getFormattedString());
    }

    public function daysCases(): array {
        return [
            '#1' => ['givenArgument'  =>  4,
                     'expectedPhrase' => '4 дня'],
            '#2' => ['givenArgument'  => -4,
                     'expectedPhrase' => '4 дня'],
            '#3' => ['givenArgument'  =>  1,
                     'expectedPhrase' => '1 день'],
            '#4' => ['givenArgument'  => -1,
                     'expectedPhrase' => '1 день'],
            '#5' => ['givenArgument'  =>  8,
                     'expectedPhrase' => '8 дней'],
            '#6' => ['givenArgument'  => -8,
                     'expectedPhrase' => '8 дней']
        ];
    }
}
