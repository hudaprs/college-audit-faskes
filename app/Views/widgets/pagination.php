<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php if ($pager->hasPrevious()): ?>
        <li class="page-item">
            <a class="page-link" href="<?= base_url($pager->getFirst()) ?>" aria-label="First">
                <span aria-hidden="true">First</span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= base_url($pager->getPrevious()) ?>"
                aria-label="<?= lang('Pager.previous') ?>">
                <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
        </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
        <li <?= $link['active'] ? 'class="active page-item"' : 'class="page-item"' ?>>
            <a href="<?= base_url($link['uri']) ?>" class="page-link">
                <?= $link['title'] ?>
            </a>
        </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
        <li class="page-item">
            <a class="page-link" href="<?= base_url($pager->getNext()) ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= base_url($pager->getLast()) ?>" aria-label="<?= lang('Pager.last') ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        </li>
        <?php endif ?>
    </ul>
</nav>