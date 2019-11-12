<?php

    namespace System\Exception {
        class UndefinedPropertyException extends \Exception {
            public function __construct( $propertyName, $code=0, \Exception $previous=null ) {
                parent::__construct("Attempted to use an undefined property: '{$propertyName}'",$code);
            }
        }
    }