<?php

    namespace Model\Enum {
        use System\AEnum;

        /**
         * Class CardSuit
         *
         * @method static CardSuit Diamonds()
         * @method static CardSuit Clubs()
         * @method static CardSuit Hearts()
         * @method static CardSuit Spades()
         */
        class CardSuit extends AEnum {
            const Diamonds   = 1;
            const Clubs      = 2;
            const Hearts     = 3;
            const Spades     = 4;
        }
    }