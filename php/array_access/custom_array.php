<?php
class CustomArray implements ArrayAccess{
    private $array = array();
    private $default_value = null;

    public function offsetExists($offset)
    {
        return(isset($array));
    }

    public function offsetGet($offset)
    {
        return(isset($this->array[$offset])?$this->array[$offset]:$this->default_value);
    }

    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }
}
