<?php
/**
 * ExerciseTracker/inc/footer_ex.php
 *
 * Purpose: Reuse the project's new footer.php EXACTLY, without altering
 *          ExerciseTracker layout/logic. This file finds and includes the
 *          real footer.php, letting it close the document as designed.
 *
 * Notes:
 * - We do NOT add extra closing tags here. The included footer.php
 *   contains </body></html> (by design) and will close the page.
 * - We search a few common locations so you don’t have to tweak paths.
 */

$__candidates = [
    // 1) Project root (most common if footer.php is placed at top level)
    dirname(__DIR__, 2) . '/footer.php',

    // 2) One level up from ExerciseTracker (if you dropped it beside the module)
    dirname(__DIR__) . '/footer.php',

    // 3) Legacy/template location (if you keep it under views/templates)
    dirname(__DIR__, 2) . '/views/templates/footer.php',
];

$__included = false;
foreach ($__candidates as $__p) {
    if (is_file($__p)) {
        require $__p;   // this should output the exact footer and close </body></html>
        $__included = true;
        break;
    }
}

if (!$__included) {
    // Fallback: avoid breaking the page if footer.php can't be found.
    // We DO NOT close the document here with extra tags to prevent double-closing
    // in environments where header/footer are handled elsewhere.
    trigger_error('ExerciseTracker footer_ex.php: footer.php not found in known locations.', E_USER_WARNING);
}
