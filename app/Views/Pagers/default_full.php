<?php $pager->setSurroundCount(2) ?>

<!-- Template Pager Kustom dengan Tailwind CSS (Mengganti default_full bawaan) -->
<nav class="flex justify-center items-center space-x-2" aria-label="Page navigation">
    <ul class="flex items-center space-x-2">

        <!-- Tombol "First" -->
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getFirst() ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150" 
                   aria-label="<?= lang('Pager.first') ?>">
                   <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
        <?php endif ?>

        <!-- Tombol "Previous" -->
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getPrevious() ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150" 
                   aria-label="<?= lang('Pager.previous') ?>">
                   <i class="fas fa-arrow-left mr-1"></i> 
                   <?= lang('Pager.previous') ?>
                </a>
            </li>
        <?php endif ?>

        <!-- Link Halaman Numerik -->
        <?php foreach ($pager->links() as $link): ?>
            <li <?= $link['active'] ? 'class="active"' : '' ?>>
                <a href="<?= $link['uri'] ?>"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition duration-150
                          <?= $link['active'] ? 'bg-orange-600 text-white shadow-md' : 'text-gray-700 bg-white border border-gray-300 hover:bg-gray-100' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- Tombol "Next" -->
        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150" 
                   aria-label="<?= lang('Pager.next') ?>">
                   <?= lang('Pager.next') ?>
                   <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </li>
        <?php endif ?>
        
        <!-- Tombol "Last" -->
        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getLast() ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition duration-150" 
                   aria-label="<?= lang('Pager.last') ?>">
                   <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
<!-- Akhir Template Pager Kustom -->