<?php

    namespace Model\Enum {

        use System\AEnum;

        /**
         * Class CardFace
         *
         * @method static CardFace Ace()
         * @method static CardFace Two()
         * @method static CardFace Three()
         * @method static CardFace Four()
         * @method static CardFace Five()
         * @method static CardFace Six()
         * @method static CardFace Seven()
         * @method static CardFace Eight()
         * @method static CardFace Nine()
         * @method static CardFace Ten()
         * @method static CardFace Jack()
         * @method static CardFace Queen()
         * @method static CardFace King()
         */
        class CardFace extends AEnum {
            const Ace   = 1;
            const Two   = 2;
            const Three = 3;
            const Four  = 4;
            const Five  = 5;
            const Six   = 6;
            const Seven = 7;
            const Eight = 8;
            const Nine  = 9;
            const Ten   = 10;
            const Jack  = 11;
            const Queen = 12;
            const King  = 13;
        }
    }