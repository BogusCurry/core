<?php

namespace Zikula\Core\Theme\Asset;

use Zikula\Core\Theme\AssetBag;

/**
 * Class CssResolver
 * @package Zikula\Core\Theme\Asset
 *
 * This class compiles all css page assets into proper html code for inclusion into a page header
 */
class CssResolver implements ResolverInterface
{
    private $bag;

    public function __construct(AssetBag $bag)
    {
        $this->bag = $bag;
    }

    public function compile()
    {
        $headers = '';
        foreach ($this->bag->all() as $asset) {
            $headers .= '<link rel="stylesheet" href="'.$asset.'" type="text/css">'."\n";
        }

        return $headers;
    }

    public function getBag()
    {
        return $this->bag;
    }
}
