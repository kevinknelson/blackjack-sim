<?php

    namespace System {
        /**
         * Class AEnum
         * @package System
         *
         * @property-read string Description
         */
        abstract class AEnum extends AValueType {
            protected static $_instances = array();

            protected function get_Description() {
                $reflection     = new \ReflectionClass($this);
                foreach( $reflection->getConstants() AS $key => $value ) {
                    if( strval($value) == strval($this->_value) ) {
                        return empty($key) ? '' : ucwords(str_replace('_',' ',trim(preg_replace('/([A-Z])/',' \\1',$key))));
                    }
                }
                return $this->_value;
            }
            /**
             * @return AEnum[]
             */
            public static function getEnumArray() {
                $instance   = get_called_class();
                if( !isset(self::$_instances[$instance]) ) {
                    $reflection     = new \ReflectionClass($instance);
                    $result         = array();
                    foreach( $reflection->getConstants() AS $key => $value ) {
                        $result[$value] = new $instance($value);
                    }
                    self::$_instances[$instance] = $result;
                }
                return self::$_instances[$instance];
            }

            /**
             * use late static binding and reflection to get specific enum dictionary
             * and check to see if that enum contains the specified value
             * @param $value
             * @return bool
             */
            public static function containsValue( $value ) {
                /**
                 * @var AEnum $called
                 */
                $called     = get_called_class();
                $enumValues = $called::getEnumArray();

                foreach( $enumValues AS $key => $enum ) {
                    if( $key == $value ) {
                        return true;
                    }
                }

                return false;
            }
            public static function __callStatic( $method, $arguments ) {
                $class  = get_called_class();
                return new $class(constant("{$class}::{$method}"));
            }
        }
    }