<?php

namespace Zikula\Bundle\CoreBundle\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Zikula\Core\Theme\Engine;

class ZikulaVersionDataCollector extends DataCollector
{
    /**
     * @var Engine
     */
    private $themeEngine;

    /**
     * ZikulaVersionDataCollector constructor.
     * @param $themeEngine
     */
    public function __construct(Engine $themeEngine)
    {
        $this->themeEngine = $themeEngine;
    }

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = [
            'version' => \Zikula_Core::VERSION_NUM,
            'ghZikulaCoreUrl' => 'https://www.github.com/zikula/core',
            'ghZikulaDocsUrl' => 'https://www.github.com/zikula/zikula-docs',
            'ghZikulaBootstrapDocsUrl' => 'http://zikula.github.io/bootstrap-docs'
            ];
        if (null !== $this->themeEngine->getTheme()) {
            $this->data['themeEngine'] = [
                'theme' => $this->themeEngine->getTheme()->getName(),
                'realm' => $this->themeEngine->getRealm(),
                'annotation' => $this->themeEngine->getAnnotationValue(),
            ];
        }
    }

    public function getVersion()
    {
        return $this->data['version'];
    }

    public function getGhZikulaCoreUrl()
    {
        return $this->data['ghZikulaCoreUrl'];
    }

    public function getGhZikulaDocsUrl()
    {
        return $this->data['ghZikulaDocsUrl'];
    }

    public function getGhZikulaBootstrapDocsUrl()
    {
        return $this->data['ghZikulaBootstrapDocsUrl'];
    }

    public function getThemeEngine()
    {
        return $this->data['themeEngine'];
    }

    public function getName()
    {
        return 'zikula_version';
    }
}
