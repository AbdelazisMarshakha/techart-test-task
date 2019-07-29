<div class="over404">
    <div class="darkOverlay"></div>
    <header>
        <h1 class="glitch" data-text="500">500</h1>
        <h6 class="glitch" data-text="500"><?php if(!empty($error)){ try {print $error->getMessage().' osn line '.$error->getLine().' in '.$error->getFile();} catch (ErrorException $e){ print 'Неизвестная ошибка';} }else{print 'Неизвестная ошибка';} ?></h6>
    </header>
</div>

