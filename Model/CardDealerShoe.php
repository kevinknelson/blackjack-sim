<?php

    namespace Model {

        use Model\Event\ShoeRefillEvent;

        class CardDealerShoe extends CardDeck {
            private $_numberOfDecks;

            public function __construct( $numberOfDecks ) {
                $this->_numberOfDecks   = $numberOfDecks;
                $this->fillShoe();
            }
            private function fillShoe() {
                $this->_cards           = array();
                for( $i=0; $i < $this->_numberOfDecks; $i++ ) {
                    $deck = new CardDeck();
                    $this->_cards = array_merge($this->_cards, $deck->Cards);
                }
                shuffle($this->_cards);
            }
            public function deal() {
                $result     = parent::deal();
                if( count($this->_cards) < 104 ) {
                    $this->fillShoe();
                    ShoeRefillEvent::instance()->trigger();
                }
                return $result;
            }
        }
    }