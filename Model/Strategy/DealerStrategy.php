<?php

    namespace Model\Strategy {
        use Model\Card;
        use Model\Enum\HandResult;
        use Model\Hand;

        class DealerStrategy extends AStrategy {
            public function getBetAmount( HandResult $previousResult, $previousAmount, $moneyLeft ) {
                return null;
            }

            public function wantsHit( Card $dealerFaceCard, Hand $hand ) {
                if( $hand->CurrentScore < 17 ) {
                    return true;
                }
                return false;
            }
        }
    }