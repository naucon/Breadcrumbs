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
use Naucon\Breadcrumbs\BreadcrumbsInterface;
use PHPUnit\Framework\TestCase;

class BreadcrumbsTest extends TestCase
{
    /**
     * @param Breadcrumbs $breadcrumbs
     */
    private $breadcrumbs;

    /**
     * @param Breadcrumbs $fluentInterfaceBreadcrumbs
     */
    private $fluentInterfaceBreadcrumbs;

    public function setup(): void
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

    public function testCount(): void
    {
        $this->assertEquals(3, $this->breadcrumbs->count());
    }

    public function testIterator(): void
    {
        $breadcrumbIterator = $this->breadcrumbs->getIterator();

        $expectedBreadcrumbs = array();
        $expectedBreadcrumbs[0]['title'] = 'home';
        $expectedBreadcrumbs[0]['url'] = '/home/';
        $expectedBreadcrumbs[1]['title'] = 'profile';
        $expectedBreadcrumbs[1]['url'] = '/profile/';
        $expectedBreadcrumbs[2]['title'] = 'address';
        $expectedBreadcrumbs[2]['url'] = null;

        $i = 0;
        foreach ($breadcrumbIterator as $key => $breadcrumb) {
            $this->assertInstanceOf('Naucon\Breadcrumbs\BreadcrumbInterface', $breadcrumb);
            $this->assertEquals($expectedBreadcrumbs[$i]['title'], $breadcrumb->getTitle());
            $this->assertEquals($expectedBreadcrumbs[$i]['url'], $breadcrumb->getUrl());
            $i++;
        }
        $this->assertEquals(3, $i);
    }

    public function testReverseIterator(): void
    {
        $breadcrumbIterator = $this->breadcrumbs->getReverseIterator();

        $expectedBreadcrumbs = array();
        $expectedBreadcrumbs[0]['title'] = 'address';
        $expectedBreadcrumbs[0]['url'] = null;
        $expectedBreadcrumbs[1]['title'] = 'profile';
        $expectedBreadcrumbs[1]['url'] = '/profile/';
        $expectedBreadcrumbs[2]['title'] = 'home';
        $expectedBreadcrumbs[2]['url'] = '/home/';

        $i = 0;
        foreach ($breadcrumbIterator as $key => $breadcrumb) {
            $this->assertInstanceOf('Naucon\Breadcrumbs\BreadcrumbInterface', $breadcrumb);
            $this->assertEquals($expectedBreadcrumbs[$i]['title'], $breadcrumb->getTitle());
            $this->assertEquals($expectedBreadcrumbs[$i]['url'], $breadcrumb->getUrl());
            $i++;
        }
        $this->assertEquals(3, $i);
    }

    public function testClear(): void
    {
        $this->assertEquals(3, $this->breadcrumbs->count());

        $this->breadcrumbs->clear();

        $this->assertEquals(0, $this->breadcrumbs->count());
    }

    public function prepareBreadcrumbsWithFluentInterface(): void
    {
        $this->fluentInterfaceBreadcrumbs = new Breadcrumbs();

        $this->fluentInterfaceBreadcrumbs->add('home', '/home/')
            ->add('profile', '/profile/')
            ->add('address');
    }

    public function testCountWithFluentInterface(): void
    {
        $this->prepareBreadcrumbsWithFluentInterface();
        $this->assertEquals(3, $this->fluentInterfaceBreadcrumbs->count());
        $this->fluentInterfaceBreadcrumbs->clear();
    }

    public function testIteratorWithFluentInterface(): void
    {
        $this->prepareBreadcrumbsWithFluentInterface();
        $breadcrumbIterator = $this->fluentInterfaceBreadcrumbs->getIterator();

        $expectedBreadcrumbs = array();
        $expectedBreadcrumbs[0]['title'] = 'home';
        $expectedBreadcrumbs[0]['url'] = '/home/';
        $expectedBreadcrumbs[1]['title'] = 'profile';
        $expectedBreadcrumbs[1]['url'] = '/profile/';
        $expectedBreadcrumbs[2]['title'] = 'address';
        $expectedBreadcrumbs[2]['url'] = null;

        $i = 0;
        foreach ($breadcrumbIterator as $key => $breadcrumb) {
            $this->assertInstanceOf('Naucon\Breadcrumbs\BreadcrumbInterface', $breadcrumb);
            $this->assertEquals($expectedBreadcrumbs[$key]['title'], $breadcrumb->getTitle());
            $this->assertEquals($expectedBreadcrumbs[$key]['url'], $breadcrumb->getUrl());
            $i++;
        }
        $this->assertEquals(3, $i);
        $this->fluentInterfaceBreadcrumbs->clear();
    }
}
