<body>
    <section class="header"></section>
    <div class="container">
        <div class="news-container">
            <div class="news-header">
                <h1><?= $new['title'] ?></h1>
            </div>
            <div class="news-body">
<?php
if(!empty($new['content'])):
?>
                <div class="new-content">
                    <p>
                        <?= $new['content'] ?>
                    </p>
                </div>
<?php
endif;
?>
            </div>
        </div>
        <div class="news-ponter">
                <h3><a href="/news/1">Все новости>></a></h3>
        </div>
    </div>
</body>