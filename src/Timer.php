<?php

namespace Fangorn;

use DateTime;
use DateInterval;
use DateTimeZone;

class Timer extends DateTime {

    // TODO: Сделать константы для падежей
    private const TIME_WORD_FORMS = [
        'y' => ['Nominative' => 'год',     'Genitive Singular' => 'года',    'Genitive Plural' => 'лет'],
        'm' => ['Nominative' => 'месяц',   'Genitive Singular' => 'месяца',  'Genitive Plural' => 'месяцев'],
        'd' => ['Nominative' => 'день',    'Genitive Singular' => 'дня',     'Genitive Plural' => 'дней'],
        'h' => ['Nominative' => 'час',     'Genitive Singular' => 'часа',    'Genitive Plural' => 'часов'],
        'i' => ['Nominative' => 'минута',  'Genitive Singular' => 'минуты',  'Genitive Plural' => 'минут'],
        's' => ['Nominative' => 'секунда', 'Genitive Singular' => 'секунды', 'Genitive Plural' => 'секунд']
    ];

    public function __construct(string $dateTimeString = 'now', string $timeZoneString = NULL) {
        if ($dateTimeString === 'now') {
            $dateTimeString = self::getCurrentDateTime();
        }

        if (!empty($timeZoneString)) {
            $timeZone = new DateTimeZone($timeZoneString);
            parent::__construct($dateTimeString, $timeZone);
        } else {
            parent::__construct($dateTimeString);
        }
    }

    public function addYears(int $yearsToAdd): void {
        $dateInterval = new DateInterval('P' . abs($yearsToAdd) . 'Y');
        $yearsToAdd > 0 ?
            $this->add($dateInterval) :
            $this->sub($dateInterval);
    }

    public function addMonth(int $monthsToAdd): void {
        $dateInterval = new DateInterval('P' . abs($monthsToAdd) . 'M');
        $monthsToAdd > 0 ?
            $this->add($dateInterval) :
            $this->sub($dateInterval);
    }

    public function addWeeks(int $weeksToAdd): void {
        $dateInterval = new DateInterval('P' . abs($weeksToAdd) . 'W');
        $weeksToAdd > 0 ?
            $this->add($dateInterval) :
            $this->sub($dateInterval);
    }

    public function addDays(int $daysToAdd): void {
        $dateInterval = new DateInterval('P' . abs($daysToAdd) . 'D');
        $daysToAdd > 0 ?
            $this->add($dateInterval) :
            $this->sub($dateInterval);
    }

    public function getFormattedString(): string {
        $dateInterval = $this->diff(new DateTime(self::getCurrentDateTime()));
        $result = '';

        foreach ($this::TIME_WORD_FORMS as $timeIntervalCode => $timeIntervalForms) {
            $interval = $dateInterval->format('%' . $timeIntervalCode);
            if ($interval > 0) {
                $case = $this->getWordFormByNumber($interval);
                $result .= $interval . ' ' . $timeIntervalForms[$case] . ' ';
            }
        }
        return trim($result);
    }

    private function getWordFormByNumber(int $number): string {
        // Последние две цифры: 11, 12, 13, 14
        if (in_array($number % 100, [11, 12, 13, 14])) {
            return 'Genitive Plural';
        }

        // Последняя цифра — 1
        if ($number % 10 === 1) {
            return 'Nominative';
        }

        // Последняя цифра: 2, 3, 4
        if (in_array($number % 10, [2, 3, 4])) {
            return 'Genitive Singular';
        }

        return 'Genitive Plural';
    }

    /** @var string|null */
    private static $currentDateTime;

    public static function setTestMode() {
        self::$currentDateTime = '2018-03-25T14:00:00+03:00';
    }

    private static function getCurrentDateTime() {
        return self::$currentDateTime ?? 'now';
    }
}
