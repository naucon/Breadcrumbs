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

use Naucon\Breadcrumbs\BreadcrumbsInterface;
use Naucon\Breadcrumbs\Breadcrumb;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerNull;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerInterface;
use Naucon\Breadcrumbs\Exception\BreadcrumbsException;

/**
 * Breadcrumbs Class
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 *
 * @example BreadcrumbsExample.php
 */
class Breadcrumbs implements BreadcrumbsInterface
{
    /**
     * @var     BreadcrumbHandlerInterface
     */
    protected $breadcrumbHandler = null;


    /**
     * Constructor
     */
    public function __construct()
    {
    }


    /**
     * @access    protected
     * @return    BreadcrumbHandlerInterface
     */
    protected function getBreadcrumbHandler()
    {
        if (is_null($this->breadcrumbHandler)) {
            $this->breadcrumbHandler = new BreadcrumbHandlerNull();
        }
        return $this->breadcrumbHandler;
    }

    /**
     * @param     BreadcrumbHandlerInterface
     * @return    void
     */
    public function setBreadcrumbHandler(BreadcrumbHandlerInterface $breadcrumbHandler)
    {
        $this->breadcrumbHandler = $breadcrumbHandler;
    }

    /**
     * @return      IteratorInterface
     */
    public function getIterator()
    {
        return $this->getBreadcrumbHandler()->getIterator();
    }

    /**
     * @return      IteratorInterface
     */
    public function getReverseIterator()
    {
        return $this->getBreadcrumbHandler()->getReverseIterator();
    }

    /**
     * add breadcrumb
     *
     * @param       string      breadcrumb title
     * @param       string      optional breadcrumb url
     * @return      BreadcrumbsInterface
     */
    public function add($title, $url = null)
    {
        $this->getBreadcrumbHandler()->add(new Breadcrumb($title, $url));
        return $this;
    }

    /**
     * @return      amount of breadcrumbs
     */
    public function count()
    {
        return $this->getBreadcrumbHandler()->count();
    }

    /**
     * clear breadcrumb
     *
     * @return      void
     */
    public function clear()
    {
        $this->getBreadcrumbHandler()->clear();
    }
}