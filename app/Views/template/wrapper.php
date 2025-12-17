<?= view('template/header') ?>


<!-- MAIN CONTENT CONTAINER -->
<div class="content">
    <!-- HEADER / BREADCRUMB area -->
    <div class="page-header">
        <h1 class="h3 mb-0 text-gray-800"><?= esc($halaman ?? $title) ?></h1>
        <p class="text-muted small mt-1">Anda berada di halaman <?= esc($halaman ?? $title) ?></p>
    </div>

    <!-- RENDER CONTENT UTAMA DI SINI -->
    <?php if (isset($content)): ?>
        <?= view($content) ?>
    <?php endif; ?>
</div>

<?= view('template/footer') ?>