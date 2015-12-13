<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs;

use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Breadcrumbs\Exception\BreadcrumbCollectionException;
use Naucon\Utility\CollectionAbstract;
use Naucon\Utility\IteratorDecoratorReverse;

/**
 * Breadcrumb Collection Class
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
class BreadcrumbCollection extends CollectionAbstract
{
    /**
     * @param     BreadcrumbInterface
     * @return    void
     */
    public function add($element)
    {
        if ($element instanceof BreadcrumbInterface) {
            $this->_items[] = $element;
            $this->_iterator = null;
        } else {
            throw new BreadcrumbCollectionException('Given element is not a instance of BreadcrumbInterface.', E_WARNING);
        }
    }

    /**
     * @param    array            elements
     * @return    void
     */
    public function addAll(array $elements)
    {
        if (is_array($elements)) {
            foreach ($elements as $element) {
                if ($element instanceof BreadcrumbInterface) {
                    $this->_items[] = $element;
                } else {
                    throw new BreadcrumbCollectionException('Given array contains one or more elements hat are not a instance of BreadcrumbInterface.', E_WARNING);
                }
            }
            $this->_iterator = null;
        } else {
            throw new BreadcrumbCollectionException('Given array can not added to collection, because it is no array.', E_NOTICE);
        }
    }

    /**
     * @return    IteratorInterface
     */
    public function getReverseIterator()
    {
        $reverseIterator = new IteratorDecoratorReverse($this->getIterator());
        return $reverseIterator;
    }
}