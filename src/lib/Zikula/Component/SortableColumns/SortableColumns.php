<?php
/**
 * Copyright Zikula Foundation 2015 - Zikula Application Framework
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @package HookDispatcher
 *
 * Please see the NOTICE file distributed with this source code for further
 * information regarding copyright and licensing.
 */

namespace Zikula\Component\SortableColumns;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SortableColumns
 * @package Zikula\Component\SortableColumns
 *
 * SortableColumns is a zikula component to help manage data table column headings that can be clicked to sort the data.
 * The collection is an ArrayCollection of Zikula\Component\SortableColumns\Column objects.
 * Use the ::generateSortableColumns method to create an array of attributes (url, css class) indexed by column name
 * which can be used in the generation of table headings/links.
 */
class SortableColumns
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * The route name string to generate urls for column headers
     * @var string
     */
    private $routeName;
    /**
     * A collection of Columns to manage
     * @var ArrayCollection
     */
    private $columnCollection;
    /**
     * The default column (if unset, the first column add is used)
     * @var Column
     */
    private $defaultColumn;
    /**
     * The column used to sort the data
     * @var Column
     */
    private $sortColumn;
    /**
     * The direction to sorted (constant from Column class)
     * @var string
     */
    private $sortDirection = Column::DIRECTION_ASCENDING;
    /**
     * The name of the html field that holds the selected orderBy field (default: `sort-field`)
     * @var string
     */
    private $sortFieldName;
    /**
     * The name of the html field that holds the selected orderBy direction (default: `sort-direction`)
     * @var string
     */
    private $directionFieldName;
    /**
     * Additional url parameters that must be included in the generated urls
     * @var array
     */
    private $additionalUrlParameters = array();

    public function __construct(RouterInterface $router, $routeName, $sortFieldName = 'sort-field', $directionFieldName = 'sort-direction')
    {
        $this->router = $router;
        $this->routeName = $routeName;
        $this->sortFieldName = $sortFieldName;
        $this->directionFieldName = $directionFieldName;
        $this->columnCollection = new ArrayCollection();
    }

    /**
     * Create an array of column definitions indexed by column name
     * <code>
     *   ['a' =>
     *     ['url' => '/foo?sort-direction=ASC&sort-field=a',
     *      'class' => 'z-order-unsorted'
     *     ],
     *   ]
     * </code>
     *
     * @return array
     */
    public function generateSortableColumns()
    {
        $resultArray = array();
        /** @var Column $column */
        foreach ($this->columnCollection as $column) {
            $this->additionalUrlParameters[$this->directionFieldName] = $column->isSortColumn() ? $column->getReverseSortDirection() : $column->getCurrentSortDirection();
            $this->additionalUrlParameters[$this->sortFieldName] = $column->getName();
            $resultArray[$column->getName()] = array(
                'url' => $this->router->generate($this->routeName, $this->additionalUrlParameters),
                'class' => $column->getCssClassString(),
            );
        }

        return $resultArray;
    }

    /**
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        $this->columnCollection->set($column->getName(), $column);
    }

    /**
     * @param $name
     */
    public function removeColumn($name)
    {
        $this->columnCollection->remove($name);
    }

    /**
     * @param $name
     * @return Column
     */
    public function getColumn($name)
    {
        return $this->columnCollection->get($name);
    }

    /**
     * Set the column to sort by and the sort direction.
     *
     * @param Column|null $sortColumn
     * @param null $sortDirection
     */
    public function setOrderBy(Column $sortColumn = null, $sortDirection = null)
    {
        $sortDirection = !empty($sortDirection) ? $sortDirection : Column::DIRECTION_ASCENDING;
        $sortColumn = !empty($sortColumn) ? $sortColumn : $this->getDefaultColumn();
        $this->setSortDirection($sortDirection);
        $this->setSortColumn($sortColumn);
    }

    /**
     * @return Column
     */
    public function getSortColumn()
    {
        if (isset($this->sortColumn)) {
            return $this->sortColumn;
        } else {
            return $this->getDefaultColumn();
        }
    }

    /**
     * @param Column $sortColumn
     */
    private function setSortColumn(Column $sortColumn)
    {
        if ($this->columnCollection->contains($sortColumn)) {
            $this->sortColumn = $sortColumn;
            $sortColumn->setIsSortColumn(true);
            $sortColumn->setCurrentSortDirection($this->getSortDirection());
        }
    }

    /**
     * @return string
     */
    public function getSortDirection()
    {
        return $this->sortDirection;
    }

    /**
     * @param string $sortDirection
     */
    private function setSortDirection($sortDirection)
    {
        if (in_array($sortDirection, array(Column::DIRECTION_ASCENDING, Column::DIRECTION_DESCENDING))) {
            $this->sortDirection = $sortDirection;
        }
    }

    /**
     * @return Column
     */
    public function getDefaultColumn()
    {
        if (!empty($this->defaultColumn)) {
            return $this->defaultColumn;
        } else {
            return $this->columnCollection->first();
        }
    }

    /**
     * @param Column $defaultColumn
     */
    public function setDefaultColumn(Column $defaultColumn)
    {
        $this->defaultColumn = $defaultColumn;
    }

    /**
     * @return array
     */
    public function getAdditionalUrlParameters()
    {
        return $this->additionalUrlParameters;
    }

    /**
     * @param array $additionalUrlParameters
     */
    public function setAdditionalUrlParameters(array $additionalUrlParameters = array())
    {
        $this->additionalUrlParameters = $additionalUrlParameters;
    }
}
