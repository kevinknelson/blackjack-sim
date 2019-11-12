<?php

    namespace System\Exception {
        class ReadOnlyPropertyException extends \Exception {
            public function __construct( $propertyName, $code=0, \Exception $previous=null ) {
                parent::__construct("Attempted to write to read-only property: '{$propertyName}'",$code);
            }
        }
    }