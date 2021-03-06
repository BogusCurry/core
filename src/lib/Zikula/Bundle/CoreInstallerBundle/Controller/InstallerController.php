<?php
/**
 * Copyright Zikula Foundation 2014 - Zikula CoreInstaller bundle.
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Zikula\Bundle\CoreInstallerBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Zikula\Component\Wizard\FormHandlerInterface;
use Zikula\Component\Wizard\Wizard;
use Zikula\Component\Wizard\WizardCompleteInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class InstallerController
 * @package Zikula\Bundle\CoreInstallerBundle\Controller
 */
class InstallerController extends AbstractController
{
    /**
     * @param Request $request
     * @param string $stage
     * @return Response
     */
    public function installAction(Request $request, $stage)
    {
        // already installed?
        if (($stage != 'complete') && ($this->container->getParameter('installed') == true)) {
            $stage = 'installed';
        }

        // notinstalled but requesting installed stage?
        if (($this->container->getParameter('installed') == false) && ($stage == 'installed')) {
            $stage = 'notinstalled';
        }

        // check php
        $ini_warnings = $this->util->initPhp();
        if (count($ini_warnings) > 0) {
            $request->getSession()->getFlashBag()->add('warning', implode('<hr>', $ini_warnings));
        }

        // begin the wizard
        $wizard = new Wizard($this->container, realpath(__DIR__ . '/../Resources/config/install_stages.yml'));
        $currentStage = $wizard->getCurrentStage($stage);
        if ($currentStage instanceof WizardCompleteInterface) {
            return $currentStage->getResponse($request);
        }
        $templateParams = $this->util->getTemplateGlobals($currentStage);
        $templateParams['headertemplate'] = '@ZikulaCoreInstaller/installheader.html.twig';
        if ($wizard->isHalted()) {
            $request->getSession()->getFlashBag()->add('danger', $wizard->getWarning());

            return $this->templatingService->renderResponse('ZikulaCoreInstallerBundle::error.html.twig', $templateParams);
        }

        // handle the form
        if ($currentStage instanceof FormHandlerInterface) {
            $form = $this->form->create($currentStage->getFormType());
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $currentStage->handleFormResult($form);
                $url = $this->router->generate('install', array('stage' => $wizard->getNextStage()->getName()), RouterInterface::ABSOLUTE_URL);

                return new RedirectResponse($url);
            }
            $templateParams['form'] = $form->createView();
        }

        return $this->templatingService->renderResponse($currentStage->getTemplateName(), $templateParams);
    }
}
