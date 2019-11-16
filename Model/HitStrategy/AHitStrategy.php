<?php

    namespace Model\HitStrategy {
        use Model\Card;
        use Model\Hand;

        abstract class AHitStrategy {

            /**
             * @param Card $dealerFaceCard
             * @param Hand $hand
             * @return bool
             */
            public abstract function wantsHit( Card $dealerFaceCard, Hand $hand );

            public abstract function cardsSeen( Hand $hand );
        }
    }