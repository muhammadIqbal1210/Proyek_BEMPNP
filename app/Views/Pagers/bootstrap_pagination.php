<?php $pager->setSurroundCount(2); ?>

<?php if ($pager->hasPrevious() || $pager->hasNext() || count($pager->links()) > 1): ?>
<nav aria-label="Pagination">
    <ul class="pagination pagination-sm mb-0">
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <?php if ($pager->hasPrevious()): ?>
                <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="First">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            <?php else: ?>
                <span class="page-link" style="opacity: 0.5; cursor: default;">
                    <span aria-hidden="true">&laquo;</span>
                </span>
            <?php endif; ?>
        </li>
        <li class="page-item <?= $pager->hasPrevious() ? '' : 'disabled' ?>">
            <?php if ($pager->hasPrevious()): ?>
                <a class="page-link" href="<?= $pager->getPrevious() ?>">Previous</a>
            <?php else: ?>
                <span class="page-link" style="opacity: 0.5; cursor: default;">Previous</span>
            <?php endif; ?>
        </li>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach; ?>

        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <?php if ($pager->hasNext()): ?>
                <a class="page-link" href="<?= $pager->getNext() ?>">Next</a>
            <?php else: ?>
                <span class="page-link" style="opacity: 0.5; cursor: default;">Next</span>
            <?php endif; ?>
        </li>
        <li class="page-item <?= $pager->hasNext() ? '' : 'disabled' ?>">
            <?php if ($pager->hasNext()): ?>
                <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Last">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            <?php else: ?>
                <span class="page-link" style="opacity: 0.5; cursor: default;">
                    <span aria-hidden="true">&raquo;</span>
                </span>
            <?php endif; ?>
        </li>
    </ul>
</nav>
<?php endif; ?>
