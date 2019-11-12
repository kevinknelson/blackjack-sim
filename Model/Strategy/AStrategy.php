<?php

    namespace Model\Strategy {
        use Model\Card;
        use Model\Enum\HandResult;
        use Model\Hand;

        abstract class AStrategy {
            protected $_minBet;
            protected $_maxBet;

            public function __construct( $minBet, $maxBet ) {
                $this->_minBet = $minBet;
                $this->_maxBet = $maxBet;
            }
            /**
             * @param HandResult $previousResult
             * @param float $previousBetAmount
             * @param float $moneyLeft
             * @return float
             */
            public abstract function getBetAmount( HandResult $previousResult, $previousBetAmount, $moneyLeft );

            /**
             * @param Card $dealerFaceCard
             * @param Hand $hand
             * @return bool
             */
            public abstract function wantsHit( Card $dealerFaceCard, Hand $hand );
        }
    }