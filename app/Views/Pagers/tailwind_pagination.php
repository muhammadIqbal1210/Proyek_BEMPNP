<?php 
$pager->setSurroundCount(2);
?>

<?php
// Build Prev/Next URLs preserving GET params and using pager group
$request = \Config\Services::request();
$get = $request->getGet();
$group = $pagerGroup ?? 'default';
$pageVar = 'page_' . $group;
// PagerRenderer doesn't expose current page; read from GET param instead
$current = (int) ($request->getGet($pageVar) ?? 1);
$pageCount = $pager->getPageCount($group) ?: 1;

function build_page_url($base, $getParams, $pageVar, $page)
{
    $params = $getParams;
    $params[$pageVar] = $page;
    return $base . (count($params) ? '?' . http_build_query($params) : '');
}
?>

<nav aria-label="Page navigation" class="flex justify-center my-8">
    <ul class="inline-flex -space-x-px text-sm font-medium rounded-md border border-gray-200 bg-white shadow-sm items-center">
        
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= build_page_url(current_url(), $get, $pageVar, 1) ?>" class="flex items-center justify-center px-3 h-10 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100 hover:text-gray-700" aria-label="First">
                    &laquo;
                </a>
            </li>
            
            <li>
                <a href="<?= build_page_url(current_url(), $get, $pageVar, max(1, $current - 1)) ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700" aria-label="Previous">
                    Previous
                </a>
            </li>
        <?php else: ?>
            <li>
                <span class="flex items-center justify-center px-3 h-10 ml-0 leading-tight text-gray-300 bg-gray-50 border border-gray-300 rounded-l-md opacity-50 cursor-default">&laquo;</span>
            </li>
            <li>
                <span class="flex items-center justify-center px-4 h-10 leading-tight text-gray-300 bg-gray-50 border border-gray-300 opacity-50 cursor-default">Previous</span>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="flex items-center justify-center px-4 h-10 leading-tight border transition-colors duration-200 <?= $link['active'] ? 'bg-orange-500 text-white border-orange-500 z-10 hover:bg-orange-600' : 'text-orange-500 bg-white border-gray-300 hover:bg-orange-500 hover:text-white' ?>" <?= $link['active'] ? 'aria-current="page"' : '' ?>>
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= build_page_url(current_url(), $get, $pageVar, min($pageCount, $current + 1)) ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700" aria-label="Next">
                    Next
                </a>
            </li>

            <li>
                <a href="<?= build_page_url(current_url(), $get, $pageVar, $pageCount) ?>" class="flex items-center justify-center px-3 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100 hover:text-gray-700" aria-label="Last">
                    &raquo;
                </a>
            </li>
        <?php else: ?>
            <li>
                <span class="flex items-center justify-center px-4 h-10 leading-tight text-gray-300 bg-gray-50 border border-gray-300 opacity-50 cursor-default">Next</span>
            </li>
            <li>
                <span class="flex items-center justify-center px-3 h-10 leading-tight text-gray-300 bg-gray-50 border border-gray-300 rounded-r-md opacity-50 cursor-default">&raquo;</span>
            </li>
        <?php endif ?>
        
    </ul>
</nav>