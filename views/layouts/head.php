<!doctype html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="<?= App::get('base') ?>/css/main.css">
        <link rel="stylesheet" href="<?= $service_css ?>">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
        <?php if(!empty($service_js)): ?><script src="<?= $service_js ?>" ></script> <?php endif;?>
    </head>    