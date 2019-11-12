<?php

    namespace Model {
        use Model\Enum\CardFace;
        use Model\Enum\CardSuit;
        use System\APropertiedObject;

        /**
         * Class CardDeck
         * @package Model
         *
         * @property-read Card[] Cards
         */
        class CardDeck extends APropertiedObject {
            protected $_cards;

            #region GETTER/SETTERS
            protected function get_Cards() {
                if( !isset($this->_cards) ) {
                    $this->_cards    = array();
                    foreach( CardSuit::getEnumArray() AS $suit ) {
                        foreach( CardFace::getEnumArray() AS $cardFace ) {
                            $this->_cards[]  = new Card($suit, $cardFace);
                        }
                    }
                    shuffle($this->_cards);
                }
                return $this->_cards;
            }
            #endregion


            public function deal() {
                return array_shift($this->_cards);
            }
        }
    }