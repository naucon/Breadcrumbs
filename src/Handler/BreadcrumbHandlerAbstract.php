<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs\Handler;

use Naucon\Breadcrumbs\BreadcrumbCollection;
use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerInterface;
use Naucon\Breadcrumbs\Handler\Exception\BreadcrumbHandlerException;

/**
 * Abstract Breadcrumb Handler Class
 *
 * @abstract
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
abstract class BreadcrumbHandlerAbstract implements BreadcrumbHandlerInterface
{
    /**
     * @var     BreadcrumbCollection
     */
    protected $breadcrumbCollection = null;


    /**
     * @access      protected
     * @return      BreadcrumbCollection
     */
    protected function getBreadcrumbCollection()
    {
        if (is_null($this->breadcrumbCollection)) {
            $this->breadcrumbCollection = new BreadcrumbCollection();
        }
        return $this->breadcrumbCollection;
    }

    /**
     * @return      IteratorInterface
     */
    public function getIterator()
    {
        return $this->getBreadcrumbCollection()->getIterator();
    }

    /**
     * @return      IteratorInterface
     */
    public function getReverseIterator()
    {
        return $this->getBreadcrumbCollection()->getReverseIterator();
    }

    /**
     * add breadcrumb
     *
     * @param       BreadcrumbsInterface
     * @return      BreadcrumbsInterface
     */
    public function add(BreadcrumbInterface $breadcrumb)
    {
        $this->getBreadcrumbCollection()->add($breadcrumb);
    }

    /**
     * @return      amount of breadcrumbs
     */
    public function count()
    {
        return $this->getBreadcrumbCollection()->count();
    }

    /**
     * clear breadcrumb
     *
     * @return      void
     */
    public function clear()
    {
        $this->getBreadcrumbCollection()->clear();
    }
}