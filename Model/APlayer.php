<?php

    namespace Model {
        use Model\HitStrategy\AHitStrategy;
        use Model\Strategy\AStrategy;
        use System\APropertiedObject;

        /**
         * Class APlayer
         * @package Model
         *
         * @property-read Hand Hand
         * @property-read string PlayerName
         */
        abstract class APlayer extends APropertiedObject {
            /** @var AStrategy */
            protected $_strategy;
            /** @var AHitStrategy */
            protected $_hitStrategy;
            /** @var bool */
            protected $_isHandComplete;
            /** @var Hand */
            protected $_hand;

            /** @var string */
            protected $_playerName;

            #region GETTER/SETTERS
            protected function get_Hand() {
                return $this->_hand;
            }
            protected function get_PlayerName() {
                return $this->_playerName;
            }
            #endregion

            public abstract function resetHand();

            public function wantsHit(Card $dealerFaceCard) {
                return $this->_hitStrategy->wantsHit($dealerFaceCard, $this->_hand);
            }
            public function seesHand( Hand $hand ) {
                $this->_hitStrategy->cardsSeen($hand);
            }
        }
    }