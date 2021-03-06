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

namespace Zikula\RoutesModule\Form\Plugin\Base;

use FormUtil;
use PageUtil;
use SecurityUtil;
use ServiceUtil;
use ThemeUtil;
use Zikula_Form_Plugin_TextInput;
use Zikula_Form_View;
use Zikula_View;

/**
 * Item selector plugin base class.
 */
class ItemSelector extends Zikula_Form_Plugin_TextInput
{
    /**
     * The treated object type.
     *
     * @var string
     */
    public $objectType = '';

    /**
     * Identifier of selected object.
     *
     * @var integer
     */
    public $selectedItemId = 0;

    /**
     * Get filename of this file.
     * The information is used to re-establish the plugins on postback.
     *
     * @return string
     */
    public function getFilename()
    {
        return __FILE__;
    }

    /**
     * Create event handler.
     *
     * @param Zikula_Form_View $view    Reference to Zikula_Form_View object.
     * @param array            &$params Parameters passed from the Smarty plugin function.
     *
     * @see    Zikula_Form_AbstractPlugin
     * @return void
     */
    public function create(Zikula_Form_View $view, &$params)
    {
        $params['maxLength'] = 11;
        /*$params['width'] = '8em';*/

        // let parent plugin do the work in detail
        parent::create($view, $params);
    }

    /**
     * Helper method to determine css class.
     *
     * @see    Zikula_Form_Plugin_TextInput
     *
     * @return string the list of css classes to apply
     */
    protected function getStyleClass()
    {
        $class = parent::getStyleClass();

        return str_replace('z-form-text', 'z-form-itemlist ' . strtolower($this->objectType), $class);
    }

    /**
     * Render event handler.
     *
     * @param Zikula_Form_View $view Reference to Zikula_Form_View object.
     *
     * @return string The rendered output
     */
    public function render(Zikula_Form_View $view)
    {
        static $firstTime = true;
        if ($firstTime) {
            PageUtil::addVar('javascript', 'jquery');
            PageUtil::addVar('javascript', 'web/bootstrap-media-lightbox/bootstrap-media-lightbox.min.js');
            PageUtil::addVar('stylesheet', 'web/bootstrap-media-lightbox/bootstrap-media-lightbox.css');
            PageUtil::addVar('javascript', '@ZikulaRoutesModule/Resources/public/js/ZikulaRoutesModule.Finder.js');
            PageUtil::addVar('stylesheet', '@ZikulaRoutesModule/Resources/public/css/style.css');
        }
        $firstTime = false;

        if (!SecurityUtil::checkPermission('ZikulaRoutesModule:' . ucfirst($this->objectType) . ':', '::', ACCESS_COMMENT)) {
            return false;
        }

        $this->selectedItemId = $this->text;

        $serviceManager = ServiceUtil::getManager();
        $repository = $serviceManager->get('zikularoutesmodule.' . $this->objectType . '_factory')->getRepository();

        $sort = $repository->getDefaultSortingField();
        $sdir = 'asc';

        // convenience vars to make code clearer
        $where = '';
        $sortParam = $sort . ' ' . $sdir;

        $entities = $repository->selectWhere($where, $sortParam);

        $view = Zikula_View::getInstance('ZikulaRoutesModule', false);
        $view->assign('objectType', $this->objectType)
             ->assign('items', $entities)
             ->assign('selectedId', $this->selectedItemId);

        return $view->fetch('External/' . ucfirst($this->objectType) . '/select.tpl');
    }

    /**
     * Decode event handler.
     *
     * @param Zikula_Form_View $view Zikula_Form_View object.
     *
     * @return void
     */
    public function decode(Zikula_Form_View $view)
    {
        parent::decode($view);
        $this->objectType = FormUtil::getPassedValue('ZikulaRoutesModule_objecttype', 'route', 'POST');
        $this->selectedItemId = $this->text;
    }
}
