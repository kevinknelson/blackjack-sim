<?php

    namespace Model\HitStrategy {
        use Model\Card;
        use Model\Hand;

        class DefaultHitStrategy extends AHitStrategy {
            public function wantsHit( Card $dealerFaceCard, Hand $hand ) {
                if( $hand->CurrentScore < 17 ) {
                    return true;
                }
                return false;
            }

            public function cardsSeen( Hand $hand ) {
                // Default strategy does not count cards
            }

            public function resetCardsSeen() {
                // Default strategy does not count cards
            }
        }
    }