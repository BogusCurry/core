<?php
/**
 * Copyright Zikula Foundation 2015 - Zikula Application Framework
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 * 
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package Zikula
 * @subpackage Zikula_Translate
 *             Please see the NOTICE file distributed with this source code for further
 *             information regarding copyright and licensing.
 */

namespace Zikula\Core\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Common\Translator\TranslatorTrait;
use Zikula\Core\AbstractBundle;
use Zikula\ExtensionsModule\ExtensionVariablesTrait;

abstract class AbstractController extends Controller
{
    use TranslatorTrait;
    use ExtensionVariablesTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * Constructor.
     *
     * @param AbstractBundle $bundle
     *            A AbstractBundle instance
     * @throws \InvalidArgumentException
     */
    public function __construct(AbstractBundle $bundle)
    {
        $this->name = $bundle->getName();
        $this->extensionName = $this->name; // for ExtensionVariablesTrait
        $this->variableApi = $bundle->getContainer()->get('zikula_extensions_module.api.variable'); // for ExtensionVariablesTrait
        $this->setTranslator($bundle->getContainer()->get('translator'));
        $this->translator->setDomain($bundle->getTranslationDomain());
        $this->boot($bundle);
    }

    /**
     * boot the controller
     * 
     * @param AbstractBundle $bundle            
     */
    public function boot(AbstractBundle $bundle)
    {
        // load optional bootstrap
        $bootstrap = $bundle->getPath() . "/bootstrap.php";
        if (file_exists($bootstrap)) {
            include_once $bootstrap;
        }
        // load any plugins
        // @todo adjust this when Namespaced plugins are implemented
        \PluginUtil::loadPlugins($bundle->getPath() . "/plugins", "ModulePlugin_{$this->name}");
    }

    /**
     * Returns a rendered view.
     * 
     * @param string $view
     *            The view name
     * @param array $parameters
     *            An array of parameters to pass to the view
     * @return string The rendered view
     */
    public function renderView($view, array $parameters = array())
    {
        $parameters = $this->decorateTranslator($parameters);

        return parent::renderView($view, $parameters);
    }

    /**
     * Renders a view.
     * 
     * @param string $view
     *            The view name
     * @param array $parameters
     *            An array of parameters to pass to the view
     * @param Response $response
     *            A response instance
     * @return Response A Response instance
     */
    public function render($view, array $parameters = array(), Response $response = null)
    {
        $parameters = $this->decorateTranslator($parameters);

        return parent::render($view, $parameters, $response);
    }

    /**
     * Streams a view.
     * 
     * @param string $view
     *            The view name
     * @param array $parameters
     *            An array of parameters to pass to the view
     * @param StreamedResponse $response
     *            A response instance
     * @return StreamedResponse A StreamedResponse instance
     */
    public function stream($view, array $parameters = array(), StreamedResponse $response = null)
    {
        $parameters = $this->decorateTranslator($parameters);

        return parent::stream($view, $parameters, $response);
    }

    /**
     * Decorate translator.
     *
     * @param array $parameters
     *            An array of parameters to pass to the view
     * @return array An array including translator parameters to pass to the view
     */
    protected function decorateTranslator(array $parameters)
    {
        $parameters['domain'] = $this->translator->getDomain();

        return $parameters;
    }

    /**
     * Returns a NotFoundHttpException.
     * This will result in a 404 response code. Usage example:
     * throw $this->createNotFoundException();
     * 
     * @param string $message
     *            A message.
     * @param \Exception $previous
     *            The previous exception.
     * @return NotFoundHttpException
     */
    public function createNotFoundException($message = null, \Exception $previous = null)
    {
        $message = null === $message ? __('Page not found') : $message;

        return new NotFoundHttpException($message, $previous);
    }

    /**
     * Returns a AccessDeniedException.
     * This will result in a 403 response code. Usage example:
     * throw $this->createAccessDeniedException();
     * 
     * @param string $message
     *            A message.
     * @param \Exception $previous
     *            The previous exception.
     * @return AccessDeniedException
     */
    public function createAccessDeniedException($message = null, \Exception $previous = null)
    {
        $message = null === $message ? __('Access denied') : $message;

        return new AccessDeniedException($message, $previous);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    /**
     * Convenience shortcut to check if user has requested permissions.
     * @param null $component
     * @param null $instance
     * @param null $level
     * @param null $user
     * @return bool
     */
    public function hasPermission($component = null, $instance = null, $level = null, $user = null)
    {
        return $this->container->get('zikula_permissions_module.api.permission')->hasPermission($component, $instance, $level, $user);
    }
}
