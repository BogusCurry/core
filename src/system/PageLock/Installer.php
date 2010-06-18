<?php
/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv2.1 (or at your option, any later version).
 * @package Zikula
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

class PageLock_Installer extends Zikula_Installer
{
    /**
     * initialize the module
     */
    public function install()
    {
        if (!DBUtil::createTable('PageLock'))
            return false;

        return true;
    }

    /**
     * upgrades the module
     *
     * This function must consider all the released versions of the module!
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param        string   $oldVersion   version number string to upgrade from
     * @return       mixed    true on success, last valid version string or false if fails
     */
    public function upgrade($oldversion)
    {
        return true;
    }

    /**
     * delete the module
     */
    public function uninstall()
    {
        DBUtil::dropTable('PageLock');

        return true;
    }
}