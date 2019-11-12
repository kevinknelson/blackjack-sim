<?php

    namespace Model {

        use Model\Enum\HandResult;
        use Model\Strategy\AStrategy;

        /**
         * Class Player
         * @package Model
         *
         * @property-read bool IsInPlay
         * @property-read float BetAmount
         */
        class Player extends APlayer {
            /** @var float */
            protected $_betAmount;
            /** @var float */
            protected $_previousBetAmount;
            /** @var HandResult */
            protected $_previousHandResult;
            /** @var float */
            protected $_money;

            public function get_IsInPlay() {
                return !$this->_isHandComplete;
            }
            protected function get_BetAmount() {
                return $this->_betAmount;
            }

            public function __construct( AStrategy $strategy, $playerName, $startingMoney ) {
                $this->_strategy            = $strategy;
                $this->_playerName          = $playerName;
                $this->_money               = $startingMoney;
                $this->_previousHandResult  = HandResult::Win();
                $this->resetHand();
            }


            public function resetHand() {
                $this->_previousBetAmount     = $this->_betAmount;

                if( $this->_strategy != null ) {
                    $this->_betAmount   = $this->_strategy->getBetAmount($this->_previousHandResult, $this->_previousBetAmount, $this->_money);
                }

                $this->_hand            = new Hand();
                $this->_isHandComplete  = false;
            }
            public function giveWin( $amount, $msg='' ) {
                $this->_previousHandResult  = HandResult::Win();
                $this->_isHandComplete      = true;
                $this->_money              += $amount;
                echo("<li>{$msg}{$this->_playerName} <span class='label label-success'>won</span> $".number_format($amount,2)." (Remaining: $".number_format($this->_money,2).")" );
                return $amount;
            }
            public function takeLoss( $msg ) {
                $this->_previousHandResult  = HandResult::Loss();
                $this->_isHandComplete      = true;
                $this->_money              -= $this->_betAmount;
                echo("<li>{$msg}{$this->_playerName} <span class='label label-warning'>lost</span> $".number_format($this->_betAmount,2)." (Remaining: $".number_format($this->_money,2).")" );
                return $this->_betAmount;
            }
            public function push() {
                $this->_previousHandResult  = HandResult::Push();
                $this->_isHandComplete      = true;
            }
        }
    }