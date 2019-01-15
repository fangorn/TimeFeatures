<?php

namespace Fangorn;

//class Cases extends \SplEnum {
class Cases {
    const Nominative        = 1;
    const Genitive_Singular = 2;
    const Genitive_Plural   = 3;

    const __default = self::Nominative;
}
