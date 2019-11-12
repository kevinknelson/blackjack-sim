<?php

    namespace System {
        /**
         * Class AValueType
         * @package System
         *
         * @property-read mixed Value
         */
        abstract class AValueType extends APropertiedObject {
            protected $_value;

            protected function get_Value() {
                return $this->_value;
            }
            /**
             * @param mixed $value
             */
            public function __construct( $value ) {
                $this->_value = $value;
            }
            public function __toString() {
                return (string) $this->Value;
            }

            /**
             * Method to prevent null-reference exceptions on AValueType objects that may be null
             * @param $var
             * @return mixed
             */
            public static function getValue( $var ) {
                return $var instanceof AValueType ? $var->Value : $var;
            }
        }
    }