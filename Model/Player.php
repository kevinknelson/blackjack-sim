<?php

    namespace Model {

        use Model\Enum\HandResult;
        use Model\HitStrategy\AHitStrategy;
        use Model\Strategy\AStrategy;

        /**
         * Class Player
         * @package Model
         *
         * @property-read bool IsPlaying
         * @property-read bool IsInPlay
         * @property-read float BetAmount
         * @property-read float MoneyLeft
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
            protected $_stopBetting = false;
            protected $_showLog;
            protected $_handsPlayed;

            public function get_IsPlaying() {
                return !$this->_stopBetting;
            }
            public function get_IsInPlay() {
                return !$this->_isHandComplete;
            }
            protected function get_HandsPlayed() {
                return $this->_handsPlayed;
            }
            protected function get_BetAmount() {
                return $this->_betAmount;
            }
            protected function get_MoneyLeft() {
                return $this->_money;
            }

            public function __construct( AStrategy $strategy, AHitStrategy $hitStrategy, $playerName, $startingMoney, $showLog=true ) {
                $this->_strategy            = $strategy;
                $this->_hitStrategy         = $hitStrategy;
                $this->_playerName          = $playerName;
                $this->_money               = $startingMoney;
                $this->_previousHandResult  = HandResult::Win();
                $this->_showLog             = $showLog;
                $this->_handsPlayed         = 0;
                $this->resetHand();
            }


            public function resetHand() {
                $this->_previousBetAmount       = $this->_betAmount;

                if( $this->_strategy != null ) {
                    $this->_betAmount   = $this->_strategy->getBetAmount($this->_previousHandResult, $this->_previousBetAmount, $this->_money);
                    if( $this->_betAmount == 0 ) {
                        $this->_stopBetting     = true;
                        echo("<li>Hands Played: {$this->_handsPlayed}; Money Left: {$this->_money}</li>");
                    }
                }

                $this->_hand            = new Hand();
                $this->_isHandComplete  = false;
            }
            public function giveWin( $amount, $msg='' ) {
                $this->_previousHandResult  = HandResult::Win();
                $this->_isHandComplete      = true;
                $this->_money              += $amount;
                $this->_handsPlayed++;
                if( $this->_showLog ) {
                    echo("\r\n<li>{$msg}{$this->_playerName} <span class='label label-success'>won</span> $".number_format($amount,2)." (Remaining: $".number_format($this->_money,2).")" );
                }
                return $amount;
            }
            public function takeLoss( $msg ) {
                $this->_previousHandResult  = HandResult::Loss();
                $this->_isHandComplete      = true;
                $this->_money              -= $this->_betAmount;
                $this->_handsPlayed++;
                if( $this->_showLog ) {
                    echo("\r\n<li>{$msg}{$this->_playerName} <span class='label label-warning'>lost</span> $".number_format($this->_betAmount,2)." (Remaining: $".number_format($this->_money,2).")" );
                }
                return $this->_betAmount;
            }
            public function push() {
                $this->_previousHandResult  = HandResult::Push();
                $this->_handsPlayed++;
                $this->_isHandComplete      = true;
            }
        }
    }