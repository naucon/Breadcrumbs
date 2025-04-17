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

use PHPUnit\Framework\TestCase;

class BreadcrumbsHelperTest extends TestCase
{
    /**
     * @param Breadcrumbs $breadcrumbs
     */
    private $breadcrumbs;

    public function setUp(): void
    {
        $this->breadcrumbs = new Breadcrumbs();
        $this->prepareBreadcrumbs();
    }

    public function tearDown(): void
    {
        $this->breadcrumbs->clear();
    }

    public function prepareBreadcrumbs(): void
    {
        $this->breadcrumbs->add('home', '/home/');
        $this->breadcrumbs->add('profile', '/profile/');
        $this->breadcrumbs->add('address');
    }

    public function testRender(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);

        $string = '<a href="/home/">home</a><a href="/profile/">profile</a>address';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithSeparator(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setSeparator(' / ');
        $test = $breadcrumbsHelper->isReverse();

        $string = '<a href="/home/">home</a> / <a href="/profile/">profile</a> / address';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithSpanTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('span');

        $string = '<span><a href="/home/">home</a></span><span><a href="/profile/">profile</a></span><span aria-current="page">address</span>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithDivTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('div');

        $string = '<div><a href="/home/">home</a></div><div><a href="/profile/">profile</a></div><div aria-current="page">address</div>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithListItemTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('li');

        $string = '<li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li aria-current="page">address</li>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithUnorderedListTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('ul');

        $string = '<ul><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li aria-current="page">address</li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithOrderedListTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('ol');

        $string = '<ol><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li aria-current="page">address</li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithUnorderedListTagAndAttributes(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('ul');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ul id="breadcrumb" class="breadcrumbs"><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li aria-current="page">address</li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithOrderedListTagAndAttributes(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setTag('ol');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ol id="breadcrumb" class="breadcrumbs"><li><a href="/home/">home</a></li><li><a href="/profile/">profile</a></li><li aria-current="page">address</li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverse(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);

        $string = 'address<a href="/profile/">profile</a><a href="/home/">home</a>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithSeparator(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setSeparator(' / ');
        $breadcrumbsHelper->setReverse(true);

        $string = 'address / <a href="/profile/">profile</a> / <a href="/home/">home</a>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithSpanTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('span');

        $string = '<span aria-current="page">address</span><span><a href="/profile/">profile</a></span><span><a href="/home/">home</a></span>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithDivTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('div');

        $string = '<div aria-current="page">address</div><div><a href="/profile/">profile</a></div><div><a href="/home/">home</a></div>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithListItemTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('li');

        $string = '<li aria-current="page">address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithUnorderedListTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ul');

        $string = '<ul><li aria-current="page">address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithOrderedListTag(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ol');

        $string = '<ol><li aria-current="page">address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithUnorderedListTagAndAttributes(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ul');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ul id="breadcrumb" class="breadcrumbs"><li aria-current="page">address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ul>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithOrderedListTagAndAttributes(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setTag('ol');
        $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));

        $string = '<ol id="breadcrumb" class="breadcrumbs"><li aria-current="page">address</li><li><a href="/profile/">profile</a></li><li><a href="/home/">home</a></li></ol>';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderWithoutLinks(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setSkipLinks(true);
        $breadcrumbsHelper->setSeparator(' / ');

        $string = 'home / profile / address';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }

    public function testRenderReverseWithoutLinks(): void
    {
        $breadcrumbsHelper = new BreadcrumbsHelper($this->breadcrumbs);
        $breadcrumbsHelper->setReverse(true);
        $breadcrumbsHelper->setSkipLinks(true);
        $breadcrumbsHelper->setSeparator(' / ');

        $string = 'address / profile / home';
        $this->assertEquals($string, $breadcrumbsHelper->render());
    }
}
