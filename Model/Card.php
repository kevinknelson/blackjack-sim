<?php

    namespace Model {
        use Model\Enum\CardFace;
        use Model\Enum\CardSuit;
        use System\APropertiedObject;

        /**
         * Class Card
         *
         * @property-read int DefaultFaceValue
         */
        class Card extends APropertiedObject {
            public $Suit;
            public $Face;

            public function __construct( CardSuit $suit, CardFace $face ) {
                $this->Suit = $suit;
                $this->Face = $face;
            }
            public function toString() {
                return "{$this->Face->Description} of {$this->Suit->Description}";
            }
            public function is( CardFace $face ) {
                return $this->Face->Value == $face->Value;
            }
            public function get_DefaultFaceValue() {
                switch( $this->Face->Value ) {
                    case CardFace::Ace      : return 11;
                    case CardFace::Jack     : return 10;
                    case CardFace::Queen    : return 10;
                    case CardFace::King     : return 10;
                    default                 : return $this->Face->Value;
                }
            }
        }
    }
