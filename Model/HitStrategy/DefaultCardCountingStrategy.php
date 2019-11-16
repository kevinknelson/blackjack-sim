<?php

    namespace Model\HitStrategy {
        use Model\Card;
        use Model\Event\ShoeRefillEvent;
        use Model\Hand;

        class DefaultCardCountingStrategy extends AHitStrategy {
            private $_cardsSeen;

            public function __construct() {
                $this->_cardsSeen   = array();
                $me                 = $this;

                ShoeRefillEvent::instance()->registerListener(function() use($me) {
                    $me->resetCardsSeen();
                });
            }

            public function wantsHit( Card $dealerFaceCard, Hand $hand ) {
                if( $hand->CurrentScore < 17 ) {
                    return true;
                }
                return false;
            }

            public function cardsSeen( Hand $hand ) {
                if( !isset($this->_cardsSeen) ) {
                    $this->_cardsSeen = array();
                }
                $this->_cardsSeen[] = $hand;
                // Default strategy does not count cards
            }

            public function resetCardsSeen() {
                $this->_cardsSeen = array();
            }
        }
    }