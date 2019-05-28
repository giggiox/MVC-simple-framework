<?php

class Request{
    public function Request($values){
        foreach($values as $key=>$value){
            $this->createProperty($key, $value);
        }
    }
    
    public function createProperty($name, $value){
        $this->{$name} = $value;
    }
    
}