<?php

    namespace Model {

        use Model\Enum\CardFace;
        use System\APropertiedObject;

        /**
         * Class Hand
         * @package Model
         *
         * @property-read bool IsSoftHand
         * @property-read int CurrentScore
         * @property-read Card DealerUpCard
         * @property-read Card IsBlackjack
         * @property-read Card IsBust
         */
        class Hand extends APropertiedObject {
            private $_cards;
            private $_acesAtElevenCount;
            private $_score;


            #region GETTERS/SETTERS
            public function get_IsSoftHand() {
                return $this->_acesAtElevenCount > 0;
            }
            public function get_CurrentScore() {
                return $this->_score;
            }
            public function get_DealerUpCard() {
                if( isset($this->_cards[1]) ) {
                    return $this->_cards[1];
                }
                return null;
            }
            public function get_IsBlackjack() {
                return count($this->_cards) == 2 && $this->_score == 21;
            }
            public function get_IsBust() {
                return $this->_score > 21;
            }
            #endregion


            public function __construct() {
                $this->_cards               = array();
                $this->_acesAtElevenCount   = 0;
                $this->_score               = 0;
            }
            public function addCard( Card $card ) {
                $this->_cards[] = $card;
                $this->calculateScore();
            }

            private function calculateScore() {
                $this->_acesAtElevenCount   = 0;
                $this->_score               = 0;

                foreach( $this->_cards AS $card ) {
                    $this->_acesAtElevenCount  += $card->is(CardFace::Ace());
                    $this->_score              += $card->DefaultFaceValue;
                }

                while( $this->_score > 21 && $this->IsSoftHand ) {
                    $this->_acesAtElevenCount--;
                    $this->_score      = $this->_score - 10;
                }
            }
        }
    }