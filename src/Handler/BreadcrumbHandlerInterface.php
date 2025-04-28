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
use Naucon\Utility\IteratorInterface;
use Naucon\Utility\IteratorAwareInterface;

/**
 * Breadcrumb Handler Interface
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
interface BreadcrumbHandlerInterface extends IteratorAwareInterface
{
    /**
     * @return      IteratorInterface
     */
    public function getIterator(): IteratorInterface;

    /**
     * @return      IteratorInterface
     */
    public function getReverseIterator();

    /**
     * add breadcrumb
     *
     * @param       BreadcrumbInterface        $breadcrumb
     * @return      void
     */
    public function add(BreadcrumbInterface $breadcrumb);

    /**
     * @return      int         amount of breadcrumbs
     */
    public function count(): int;

    /**
     * clear breadcrumb
     *
     * @return      void
     */
    public function clear();
}