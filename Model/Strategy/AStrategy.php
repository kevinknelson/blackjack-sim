<?php

    namespace Model\Strategy {
        use Model\Card;
        use Model\Enum\HandResult;
        use Model\Hand;

        abstract class AStrategy {
            protected $_minBet;
            protected $_maxBet;

            protected $_quitMinimum;
            protected $_quitMaximum;

            public function __construct( $minBet, $maxBet, $quitMinimum=null, $quitMaximum=null ) {
                $this->_minBet      = $minBet;
                $this->_maxBet      = $maxBet;
                $this->_quitMinimum = $quitMinimum;
                $this->_quitMaximum = $quitMaximum;
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