<?php

    namespace Model\Enum {
        use System\AEnum;

        /**
         * Class HandResult
         * @package Model\Enum
         *
         * @method static HandResult Loss()
         * @method static HandResult Push()
         * @method static HandResult Win()
         */
        class HandResult extends AEnum {
            const Loss  = -1;
            const Push  = 0;
            const Win   = 1;
        }
    }