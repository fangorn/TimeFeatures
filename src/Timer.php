<?php

namespace Fangorn;

use DateTime;
use DateInterval;
use DateTimeZone;

class Timer extends DateTime {

    private const TIME_WORD_FORMS = [
        'y' => ['Nominative' => 'год',     'Genitive Singular' => 'года',    'Genitive Plural' => 'лет'],
        'm' => ['Nominative' => 'месяц',   'Genitive Singular' => 'месяца',  'Genitive Plural' => 'месяцев'],
        'd' => ['Nominative' => 'день',    'Genitive Singular' => 'дня',     'Genitive Plural' => 'дней'],
        'h' => ['Nominative' => 'час',     'Genitive Singular' => 'часа',    'Genitive Plural' => 'часов'],
        'i' => ['Nominative' => 'минута',  'Genitive Singular' => 'минуты',  'Genitive Plural' => 'минут'],
        's' => ['Nominative' => 'секунда', 'Genitive Singular' => 'секунды', 'Genitive Plural' => 'секунд']
    ];

    public function __construct(string $dateTimeString, string $timeZoneString = NULL) {
        if (!empty($timeZoneString)) {
            $timeZone = new DateTimeZone($timeZoneString);
            parent::__construct($dateTimeString, $timeZone);
        } else {
            parent::__construct($dateTimeString);
        }
    }

    public function addWeeks(int $weeksToAdd): void {
        $dateInterval = new DateInterval('P' . $weeksToAdd . 'W');
        $this->add($dateInterval);
    }

    public function getFormattedString(): string {
        $dateInterval = $this->diff(new DateTime('now'));
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
        $numberEnds_11_12_13_14 = $number % 100 === 11 || $number % 100 === 12 ||
                                  $number % 100 === 13 || $number % 100 === 14;
        if ($numberEnds_11_12_13_14) {
            return 'Genitive Plural';
        }
        $numberEnds_1_Except_11 = $number % 10 === 1;
        if ($numberEnds_1_Except_11) {
            return 'Nominative';
        }
        $numberEnds_2_3_4_Except_12_13_14 = $number % 10 === 2 ||
            $number % 10 === 3 || $number % 10 === 4;
        if ($numberEnds_2_3_4_Except_12_13_14) {
            return 'Genitive Singular';
        }
        return 'Genitive Plural';
    }
}
