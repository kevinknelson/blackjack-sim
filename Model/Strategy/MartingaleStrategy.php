<?php

    namespace Model\Strategy {
        use Model\Card;
        use Model\Enum\HandResult;
        use Model\Hand;

        class MartingaleStrategy extends AStrategy {
            public function getBetAmount( HandResult $previousResult, $previousAmount, $moneyLeft ) {
                if( $moneyLeft <= $this->_minBet ) {
                    echo("<li>BANKRUPT: Balance below minimum bet</li>");
                    exit;
                }

                if( empty($previousAmount) ) {
                    $previousAmount     = $this->_minBet;
                    $previousResult     = HandResult::Push();
                }

                $amountToBet        = $this->_minBet;
                if( $previousResult->Value == HandResult::Push ) {
                    $amountToBet    = $moneyLeft > $previousAmount ? $previousAmount : $moneyLeft;
                }
                if( $previousResult->Value == HandResult::Loss ) {
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