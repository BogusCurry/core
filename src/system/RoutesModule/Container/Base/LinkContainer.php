<?php
/**
 * Routes.
 *
 * @copyright Zikula contributors (Zikula)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Zikula contributors <support@zikula.org>.
 * @link http://www.zikula.org
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.7.0 (http://modulestudio.de).
 */

namespace Zikula\RoutesModule\Container\Base;

use ModUtil;
use SecurityUtil;
use ServiceUtil;
use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\Translator;
use Zikula\Core\LinkContainer\LinkContainerInterface;

/**
 * This is the link container service implementation class.
 */
class LinkContainer implements LinkContainerInterface
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * Constructor.
     * Initialises member vars.
     *
     * @param Translator      $translator Translator service instance.
     * @param Routerinterface $router     The router service.
     */
    public function __construct($translator, RouterInterface $router)
    {
        $this->translator = $translator;
        $this->router = $router;
    }

    /**
     * Returns available header links.
     *
     * @return array Array of header links.
     */
    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $links = array();
        $serviceManager = ServiceUtil::getManager();
        $request = $serviceManager->get('request');

        $controllerHelper = $serviceManager->get('zikularoutesmodule.controller_helper');
        $utilArgs = array('api' => 'ajax', 'action' => 'getLinks');
        $allowedObjectTypes = $controllerHelper->getObjectTypes('api', $utilArgs);

        $currentLegacyType = $request->query->filter('lct', 'user', false, FILTER_SANITIZE_STRING);
        $permLevel = in_array('admin', array($type, $currentLegacyType)) ? ACCESS_ADMIN : ACCESS_READ;

        
        if (in_array('admin', array($type, $currentLegacyType))) {
            
            if (in_array('route', $allowedObjectTypes)
                && SecurityUtil::checkPermission($this->getBundleName() . ':Route:', '::', $permLevel)) {
                $links[] = array('url' => $this->router->generate('zikularoutesmodule_route_view', array('lct' => 'admin')),
                                 'text' => $this->translator->__('Routes'),
                                 'title' => $this->translator->__('Route list'));
            }
        }

        return $links;
    }

    public function getBundleName()
    {
        return 'ZikulaRoutesModule';
    }
}
