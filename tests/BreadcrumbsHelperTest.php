<?php
/*
 * Copyright 2008 Sven Sanzenbacher
 *
 * This file is part of the naucon package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Naucon\Breadcrumbs\Tests;

use Naucon\Breadcrumbs\Breadcrumbs;
use Naucon\Breadcrumbs\Helper\BreadcrumbsHelper;

class BreadcrumbsHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return      Breadcrumbs
     */
    public function testInitBreadcrumbs()
    {
        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->add('home', '/home/');
        $breadcrumbs->add('profile', '/profile/');
        $breadcrumbs->add('address');
        return $breadcrumbs;
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRender(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);

        $string = '<a href="/home/">home</a><a href="/profile/">profile</a>address';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithSeparator(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setSeparator(' / ');

        $string = '<a href="/home/">home</a> / <a href="/profile/">profile</a> / address';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithSpanTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('span');

        $string = '<span><a href="/home/">home</a></span><span><a href="/profile/">profile</a></span><span>address</span>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithDivTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('div');

        $string = '<div><a href="/home/">home</a></div><div><a href="/profile/">profile</a></div><div>address</div>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithListItemTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('li');

        $string = '<li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithUnorderedListTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('ul');

        $string = '<ul><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithOrderedListTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('ol');

        $string = '<ol><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithUnorderedListTagAndAttributes(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('ul');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ul id="breadcrumb" class="breadcrumbs"><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderWithOrderedListTagAndAttributes(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setTag('ol');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ol id="breadcrumb" class="breadcrumbs"><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li>address</li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverse(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);

        $string = 'address<a href="/profile/">profile</a><a href="/home/">home</a>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithSeparator(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setSeparator(' / ');
        $breadcrumbsHelper->setReverse(true);

        $string = 'address / <a href="/profile/">profile</a> / <a href="/home/">home</a>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithSpanTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('span');

        $string = '<span>address</span><span><a href="/profile/">profile</a></span><span><a href="/home/">home</a></span>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithDivTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('div');

        $string = '<div>address</div><div><a href="/profile/">profile</a></div><div><a href="/home/">home</a></div>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithListItemTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('li');

        $string = '<li>address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithUnorderedListTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ul');

        $string = '<ul><li>address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithOrderedListTag(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ol');

        $string = '<ol><li>address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithUnorderedListTagAndAttributes(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ul');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ul id="breadcrumb" class="breadcrumbs"><li>address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    /**
     * @depends     testInitBreadcrumbs
     * @param       Breadcrumbs
     * @return      void
     */
    public function testRenderReverseWithOrderedListTagAndAttributes(Breadcrumbs $breadcrumbs)
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ol');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ol id="breadcrumb" class="breadcrumbs"><li>address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }
}
