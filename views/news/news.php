<body>
    <section class="header"></section>
    <div class="container">
        <div class="news-container">
            <div class="news-header">
                <h1>Новости</h1>
            </div>
            <div class="news-body">
<?php
if(!empty($news)):
    foreach ($news as $new):
?>
                <div class="new-content">
                    <div class="new-header">
                        <div class="new-date"><?=date('d.m.Y',$new['idate'])?> </div>
                        <div class="new-title">
                            <a href="<?=App::get('base')?>/view/<?=$new['id']?>" ><?= $new['title']?> </a>
                        </div>
                    </div>
                    <div class="new-body">
                        <p><?= $new['announce']?></p>
                    </div>
                </div>
<?php
    endforeach;
endif;
?>
            </div>
        </div>
        <div class="pagination">
            <div class="pagination-header">
                <h3>Страницы:</h3>
            </div>
<?php
    if(empty($totalPageCount)):
        $totalPageCount = 1;
    endif;
    for($counter = 1;$counter<=$totalPageCount;$counter++):
?>
            <div class="box<?= $counter == $page? ' selected': '' ?>" >
                <a href="/news/<?=$counter?>"><p><?= $counter ?></p></a>
            </div>
<?php
    endfor;
?>            
        </div>
    </div>
</body>