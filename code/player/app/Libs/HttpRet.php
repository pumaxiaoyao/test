<?php
namespace App\Libs;

use ArrayAccess;

/**
 * http ret data from curl request
 * @access public
 */
class HttpRet implements ArrayAccess
{
    private $data;

    public function __construct(array $ret = [])
    {
        $this->data = $ret;
    }

    /**
     * HttpRet::offsetExists()
     *
     * @param mixed $key
     * @return
     */
    public function offsetExists($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * HttpRet::offsetSet()
     *
     * @param mixed $key
     * @param mixed $value
     * @return
     */
    public function offsetSet($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * HttpRet::offsetGet()
     *
     * @param mixed $key
     * @return
     */
    public function offsetGet($key)
    {
        return $this->data[$key];
    }

    /**
     * HttpRet::offsetUnset()
     *
     * @param mixed $key
     * @return
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }
}
