<?php

    namespace Model\Strategy {
        use Model\Card;
        use Model\Enum\HandResult;
        use Model\Hand;

        class ReverseMartingaleStrategy extends AStrategy {
            public function getBetAmount( HandResult $previousResult, $previousAmount, $moneyLeft ) {
                if( isset($this->_quitMinimum) && $moneyLeft <= $this->_quitMinimum ) {
                    echo("\r\n<li><span class='label label-danger'>LOST TOO MUCH</span> Quitting because I've lost as much as I'm willing.</li>");
                    return 0;
                }
                if( isset($this->_quitMaximum) && $moneyLeft >= $this->_quitMaximum ) {
                    echo("\r\n<li><span class='label label-success'>REACHED GOAL</span> Quitting because I've lost as much as I'm willing.</li>");
                    return 0;
                }
                if( $moneyLeft <= $this->_minBet ) {
                    echo("\r\n<li><span class='label label-default'>BANKRUPT</span> Balance below minimum bet.</li>");
                    return 0;
                }

                if( empty($previousAmount) ) {
                    $previousAmount     = $this->_minBet;
                    $previousResult     = HandResult::Push();
                }

                $amountToBet        = $this->_minBet;
                if( $previousResult->Value == HandResult::Push ) {
                    $amountToBet    = $moneyLeft > $previousAmount ? $previousAmount : $moneyLeft;
                }
                if( $previousResult->Value == HandResult::Win ) {
                    $double         = $previousAmount * 2;
                    $amountToBet    = $moneyLeft > $double ? $double : $moneyLeft;
                }
                return min($amountToBet, $this->_maxBet);
            }

            public function wantsHit( Card $dealerFaceCard, Hand $hand ) {
                if( $hand->CurrentScore < 17 || $hand->IsSoftHand && $hand->CurrentScore < 18 ) {
                    return true;
                }
                return false;
            }
        }
    }