<?php
/**
 * Copyright 2015 Zikula Foundation.
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 * @subpackage Zikula_Exception
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * ParameterBag is a container for key/value pairs.
 * @deprecated as of Core 1.4.0
 */
class Zikula_Bag_ParameterBag extends \Symfony\Component\HttpFoundation\ParameterBag
{
    /**
     * Filter key.
     * @deprecated as of Core 1.4.0
     * @see \Symfony\Component\HttpFoundation\ParameterBag::filter
     *
     * @param string $key     Key.
     * @param mixed  $default Default = null.
     * @param bool   $deep    Default = false.
     * @param int    $filter  FILTER_* constant.
     * @param mixed  $options Filter options.
     *
     * @see http://php.net/manual/en/function.filter-var.php
     *
     * @return mixed
     */
    public function filter($key, $default = null, $deep = false, $filter = FILTER_DEFAULT, $options = array())
    {
        if (func_num_args() > 2) {
            if (is_bool(func_get_arg(2))) {
                // usage is compatible with normal ParameterBag
                $deep = func_get_arg(2);
                $filter = (func_num_args() >= 4) && (func_get_arg(3) !== false) ? func_get_arg(3) : FILTER_DEFAULT;
                $options = (func_num_args() == 5) && (func_get_arg(4) !== false) ? func_get_arg(4) : array();
            } else {
                // using old signature - third param exists and is a constant, not a bool
                LogUtil::log('The method signature for filter() has changed. See \Symfony\Component\HttpFoundation\ParameterBag::filter().', E_USER_DEPRECATED);
                $filter = (func_num_args() >= 3) && (func_get_arg(2) !== false) ? func_get_arg(2) : FILTER_DEFAULT;
                $options = (func_num_args() >= 4) && (func_get_arg(3) !== false) ? func_get_arg(3) : array();
            }
        }

        return parent::filter($key, $default, $filter, $options, $deep);
    }
}
