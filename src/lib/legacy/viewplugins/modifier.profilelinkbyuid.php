<?php
/**
 * Copyright Zikula Foundation 2009 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula_View
 * @subpackage Template_Plugins
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

/**
 * Zikula_View modifier to create a link to a users profile from the UID.
 *
 * Example
 *
 *   Simple version, shows the username
 *   {$uid|profilelinkbyuid}
 *   Simple version, shows username, using class="classname"
 *   {$uid|profilelinkbyuid:classname}
 *   Using profile.gif instead of username, no class
 *   {$uid|profilelinkbyuid:'':'images/profile.gif'}
 *
 *   Using language depending image from pnimg. Note that we pass
 *   the pnimg result array to the modifier as-is
 *   {img src='profile.gif' assign=profile}
 *   {$uid|profilelinkbyuid:'classname':$profile}
 *
 * @param string  $uid       The users uid.
 * @param string  $class     The class name for the link (optional).
 * @param mixed   $image     The image to show instead of the username (optional).
 *                              May be an array as created by pnimg.
 * @param integer $maxLength If set then user names are truncated to x chars.
 *
 * @return string The output.
 */
function smarty_modifier_profilelinkbyuid($uid, $class = '', $image = '', $maxLength = 0)
{
    if (empty($uid) || (int)$uid < 1) {
        return $uid;
    }

    $uid        = (float)$uid;

    $profileModule = System::getVar('profilemodule', '');

    if ($uid && ($uid > 1) && !empty($profileModule) && ModUtil::available($profileModule)) {
        $userDisplayName = ModUtil::apiFunc($profileModule, 'user', 'getUserDisplayName', array('uid' => $uid));

        if (empty($userDisplayName)) {
            $userDisplayName = UserUtil::getVar('uname', $uid);
        }

        if (!empty($class)) {
            $class = ' class="' . DataUtil::formatForDisplay($class) . '"';
        }

        if (!empty($image)) {
            $userDisplayName = DataUtil::formatForDisplay($userDisplayName);
            if (is_array($image)) {
                // if it is an array we assume that it is an pnimg array
                $show = '<img src="' . DataUtil::formatForDisplay($image['src']) . '" alt="' . DataUtil::formatForDisplay($image['alt']) . '" width="' . DataUtil::formatForDisplay($image['width']) . '" height="' . DataUtil::formatForDisplay($image['height']) . '" />';
            } else {
                $show = '<img src="' . DataUtil::formatForDisplay($image) . '" alt="' . $userDisplayName . '" />';
            }
        } elseif ($maxLength > 0) {
            // truncate the user name to $maxLength chars
            $length     = strlen($userDisplayName);
            $truncEnd   = ($maxLength > $length) ? $length : $maxLength;
            $show  = DataUtil::formatForDisplay(substr($userDisplayName, 0, $truncEnd));
        } else {
            $show = DataUtil::formatForDisplay($userDisplayName);
        }

        $profileLink = '<a' . $class . ' title="' . DataUtil::formatForDisplay(__('Profile')) . ': ' . $userDisplayName . '" href="' . DataUtil::formatForDisplay(ModUtil::url($profileModule, 'user', 'view', array('uid' => $uid), null, null, true)) . '">' . $show . '</a>';
    } elseif (!empty($image)) {
        $profileLink = ''; // image for anonymous user should be "empty"
    } else {
        $uname    = UserUtil::getVar('uname', $uid);
        $profileLink = DataUtil::formatForDisplay($uname);
    }

    return $profileLink;
}
