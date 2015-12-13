<?php
    use Naucon\Breadcrumbs\Breadcrumbs;
    $breadcrumbs = new Breadcrumbs();
    $breadcrumbs->add('home', '/home/');
    $breadcrumbs->add('profile', '/profile/');
    $breadcrumbs->add('address');


    foreach ($breadcrumbs as $breadcrumb)
    {
        if ($breadcrumb->hasUrl()) {
            echo '<a href="' . $breadcrumb->getUrl() . '">' . $breadcrumb->getTitle() . '</a>';
        } else {
            echo $breadcrumb->getTitle();
        }
        echo '&nbsp;';
    }

    echo '<br/>' . PHP_EOL;


    use Naucon\Breadcrumbs\Helper\BreadcrumbsHelper;
    $breadcrumbsHelper = new BreadcrumbsHelper($breadcrumbs);
    echo $breadcrumbsHelper->render();

echo '<br/>' . PHP_EOL;

    // with separator
    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();

echo '<br/>' . PHP_EOL;

    // with span tag and separator
    $breadcrumbsHelper->setTag('span');
    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();

echo '<br/>' . PHP_EOL;

    // with div tag and separator
    $breadcrumbsHelper->setTag('div');
    $breadcrumbsHelper->setSeparator(' / ');
    echo $breadcrumbsHelper->render();

echo '<br/>' . PHP_EOL;
$breadcrumbsHelper->setSeparator();

    // with ul tag
    $breadcrumbsHelper->setTag('ul');
    $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));
    echo $breadcrumbsHelper->render();

echo '<br/>' . PHP_EOL;

    $breadcrumbsHelper->setTag('ol');
    $breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));
    echo $breadcrumbsHelper->render();

echo '<br/>' . PHP_EOL;
$breadcrumbsHelper->setReverse();

$breadcrumbsHelper->setTag('ol');
$breadcrumbsHelper->setOptions(array('id' => 'breadcrumb', 'class' => 'breadcrumbs'));
echo $breadcrumbsHelper->render();
