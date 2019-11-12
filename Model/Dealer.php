<?php

    namespace Model {

        use Model\Strategy\DealerStrategy;

        class Dealer extends APlayer {
            /** @var CardDealerShoe  */
            private $_shoe;
            /** @var Player[] */
            private $_players;

            public function __construct( CardDealerShoe $shoe ) {
                $this->_shoe        = $shoe;
                $this->_playerName  = "Dealer";
                $this->_strategy    = new DealerStrategy(0,999999999);
                $this->resetHand();
            }
            public function addPlayer( Player $player ) {
                $this->_players[]     = $player;
            }

            public function resetHand() {
                $this->_hand            = new Hand();
                $this->_isHandComplete  = false;
            }

            public function runHand() {
                // deal 1st card
                foreach( $this->_players AS $player ) {
                    $player->Hand->addCard($this->_shoe->deal());
                }
                $this->Hand->addCard($this->_shoe->deal());

                // deal 2nd card
                foreach( $this->_players AS $player ) {
                    $player->Hand->addCard($this->_shoe->deal());
                }
                $this->Hand->addCard($this->_shoe->deal());

                foreach( $this->_players AS $player ) {
                    if( $player->Hand->IsBlackjack ) {
                        $bet            = $player->BetAmount * 1.5;
                        $player->giveWin($bet, "<span class='label label-success'>PLAYER BLACKJACK</span>");
                    }
                }
                if( $this->Hand->IsBlackjack ) {
                    foreach( $this->_players AS $player ) {
                        if( $player->IsInPlay ) {
                            $player->takeLoss("<span class='label label-danger'>DEALER BLACKJACK</span>");
                        }
                    }
                }
                foreach( $this->_players AS $player ) {
                    if( $player->IsInPlay ) {
                        while( $player->wantsHit($this->Hand->DealerUpCard) ) {
                            $player->Hand->addCard($this->_shoe->deal());
                        }
                        if( $player->Hand->IsBust ) {
                            $player->takeLoss("<span class='label label-danger'>BUST</span>");
                        }
                    }
                }
                while( $this->wantsHit($this->Hand->DealerUpCard) ) {
                    $this->Hand->addCard($this->_shoe->deal());
                }

                if( $this->Hand->IsBust ) {
                    foreach( $this->_players AS $player ) {
                        if( $player->IsInPlay ) {
                            $player->giveWin($player->BetAmount,"<span class='label label-success'>DEALER BUST</span>");
                        }
                    }
                }
                else {
                    foreach( $this->_players AS $player ) {
                        if( $player->IsInPlay ) {
                            if( $player->Hand->CurrentScore == $this->Hand->CurrentScore ) {
                                $player->push();
                            }
                            elseif( $player->Hand->CurrentScore > $this->Hand->CurrentScore ) {
                                $player->giveWin($player->BetAmount,"<span class='label label-success'>PLAYER WINS {$player->Hand->CurrentScore} over {$this->Hand->CurrentScore}</span>");
                            }
                            else {
                                $player->takeLoss("<span class='label label-danger'>DEALER WINS {$this->Hand->CurrentScore} over {$player->Hand->CurrentScore}</span>");
                            }
                        }
                    }
                }
                $this->resetHand();
                foreach( $this->_players AS $player ) {
                    $player->resetHand();
                }
            }
        }
    }