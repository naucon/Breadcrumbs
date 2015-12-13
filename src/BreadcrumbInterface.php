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

/**
 * Breadcrumb Interface
 *
 * @package     Breadcrumbs
 * @author      Sven Sanzenbacher
 */
interface BreadcrumbInterface
{
    /**
     * @return      breadcrumb title
     */
    public function getTitle();

    /**
     * @param       string      breadcrumb title
     * @return      void
     */
    public function setTitle($title);

    /**
     * @return      string		breadcrumb url
     */
    public function getUrl();

    /**
     * @param		string		breadcrumb url
     * @return      void
     */
    public function setUrl($url);
}