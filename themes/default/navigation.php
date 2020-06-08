<div class="navigation-area intro-element">
    <ul class="navigation-ul">
        <?php foreach(Registry::get('pages') as $page): ?>
            <li class="navigation-li">
                <a href="<?php echo '#' . $page->slug; ?>" class="navigation-a section-post">
                    <span class="icon"><i class="fa <?php echo $page->icon; ?>"></i></span>
                    <span class="text"><?php echo $page->title; ?> <i class="fas fa-sort-down"></i></span>
                </a>
            </li>
        <?php endforeach; ?>
        <li class="navigation-li">
            <a href="#services" class="navigation-a section-post">
                <span class="icon"><i class="icon-settings"></i></span>
                <span class="text">Services <i class="fas fa-sort-down"></i></span>
            </a>
        </li>
        <li class="navigation-li">
            <a href="#portfolio" class="navigation-a section-post">
                <!--<span class="icon"><i class="icon-camera"></i></span>-->
                <span class="icon"><i class="icon-home"></i></span>
                <span class="text">Halls <i class="fas fa-sort-down"></i></span>
            </a>
        </li>
        <li class="navigation-li">
            <a href="#contact" class="navigation-a section-post">
                <span class="icon"><i class="icon-envelope"></i></span>
                <span class="text">Contact <i class="fas fa-sort-down"></i></span>
            </a>
        </li>
    </ul>
</div>
