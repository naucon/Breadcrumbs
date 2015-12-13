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

use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Utility\IterableInterface;

/**
 * Breadcrumb Handler Interface
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
interface BreadcrumbHandlerInterface extends IterableInterface
{
    /**
     * @return      IteratorInterface
     */
    public function getIterator();

    /**
     * @return      IteratorInterface
     */
    public function getReverseIterator();

    /**
     * add breadcrumb
     *
     * @param       BreadcrumbsInterface
     * @return      BreadcrumbsInterface
     */
    public function add(BreadcrumbInterface $breadcrumb);

    /**
     * @return      amount of breadcrumbs
     */
    public function count();

    /**
     * clear breadcrumb
     *
     * @return      void
     */
    public function clear();
}