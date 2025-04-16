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

use Naucon\Breadcrumbs\Breadcrumb;
use Naucon\Breadcrumbs\BreadcrumbInterface;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerInterface;
use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerSession;
use PHPUnit\Framework\TestCase;

class BreadcrumbHandlerSessionTest extends TestCase
{
    public static $sessionData = [];

    /**
     * @param BreadcrumbHandlerSession $breadcrumbHandler
     */
    private $breadcrumbHandler;

    public function setUp():void
    {
        $_SESSION = self::$sessionData;
        $this->breadcrumbHandler = new BreadcrumbHandlerSession();
        $this->prepareBreadcrumbs();
    }

    public function tearDown(): void
    {
        $this->breadcrumbHandler->clear();
        self::$sessionData = $_SESSION;
    }

    public function prepareBreadcrumbs(): void
    {
        $this->breadcrumbHandler->add(new Breadcrumb('home', '/home/'));
        $this->breadcrumbHandler->add(new Breadcrumb('profile', '/profile/'));
        $this->breadcrumbHandler->add(new Breadcrumb('address'));
    }

    public function testCount(): void
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        echo $this->breadcrumbHandler->count();
        $this->assertEquals(3, $this->breadcrumbHandler->count());
        $this->assertCount(3, $_SESSION[$expectedSessionNamespace]);
    }

    public function testIterator(): void
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $breadcrumbIterator = $this->breadcrumbHandler->getIterator();

        $expectedBreadcrumbs = [];
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

        $this->assertEquals($expectedBreadcrumbs, $_SESSION[$expectedSessionNamespace]);
    }

    public function testReverseIterator(): void
    {
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $breadcrumbIterator = $this->breadcrumbHandler->getReverseIterator();

        $expectedBreadcrumbs = [];
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
        $expectedSessionNamespace = '__NcBreadcrumbStorage';

        $this->assertEquals(3, $this->breadcrumbHandler->count());
        $this->assertCount(3, $_SESSION[$expectedSessionNamespace]);

        $this->breadcrumbHandler->clear();

        $this->assertEquals(0, $this->breadcrumbHandler->count());
        $this->assertCount(0, $_SESSION[$expectedSessionNamespace]);
    }
}
