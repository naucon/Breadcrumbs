<?php
    // start session
    session_start();

    use Naucon\Breadcrumbs\Breadcrumbs;
    use Naucon\Breadcrumbs\Handler\BreadcrumbHandlerSession;
    $breadcrumbs = new Breadcrumbs();
    $breadcrumbs->setBreadcrumbHandler(new BreadcrumbHandlerSession());

    if ($breadcrumbs->count() > 4) {
        $breadcrumbs->clear();
    }

    $breadcrumbs->add(date('H:i:s'), '/home/');


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

    // close session
    session_write_close();