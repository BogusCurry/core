<?php
/**
 * Copyright 2010 Zikula Foundation.
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 * @subpackage Zikula_Controller
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Abstract AJAX controller.
 */
abstract class Zikula_Controller_AbstractAjax extends Zikula_AbstractController
{
    /**
     * {@inheritdoc}
     */
    protected function configureView()
    {
        // View is generally not required so override this.
    }

    /**
     * Check the CSRF token.
     *
     * Checks will fall back to $token check if automatic checking fails.
     *
     * @param string $token Token, default null.
     *
     * @throws AccessDeniedException If the CSFR token fails.
     *
     * @return void
     */
    public function checkAjaxToken($token = null)
    {
        $headerToken = isset($_SERVER['HTTP_X_ZIKULA_AJAX_TOKEN']) ? $_SERVER['HTTP_X_ZIKULA_AJAX_TOKEN'] : null;

        if ($headerToken == session_id()) {
            return;
        }

        try {
            $this->checkCsrfToken($token);
        } catch (AccessDeniedException $e) {
        }

        throw new AccessDeniedException(__('Ajax security checks failed.'));
    }
}
