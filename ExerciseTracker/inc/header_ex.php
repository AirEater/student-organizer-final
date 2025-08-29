<?php
/**
 * ExerciseTracker/inc/header_ex.php
 * - Supplies $greeting / $username expected by the new header.php
 * - Includes your real header.php (exactly)
 * - Adds a robust "Home/Dashboard" routing shim that works from /ExerciseTracker
 */

require_once __DIR__ . '/auth_bridge.php';

/* ---- Variables expected by header.php ---- */
if (!isset($greeting)) {
    @date_default_timezone_set('Asia/Kuala_Lumpur');
    $h = (int) date('G');
    if     ($h < 5)  $greeting = 'Good night';
    elseif ($h < 12) $greeting = 'Good morning';
    elseif ($h < 18) $greeting = 'Good afternoon';
    else             $greeting = 'Good evening';
}
if (!isset($username)) {
    $username =
        ($_SESSION['username'] ?? null) ??
        ($_SESSION['user']['username'] ?? null) ??
        ($_SESSION['user']['name'] ?? null) ??
        ($_SESSION['name'] ?? null) ?? '';
    if ($username === '' && !empty($_SESSION['user']['email'])) {
        $username = strstr($_SESSION['user']['email'], '@', true);
    }
    if ($username === '' || $username === null) {
        $username = 'there';
    }
}

/* ---- Include the real header.php ---- */
$header_candidates = [
    dirname(__DIR__, 2) . '/header.php',                  // /student_organizer/header.php
    dirname(__DIR__)     . '/header.php',                 // /student_organizer/ExerciseTracker/header.php
    dirname(__DIR__, 2) . '/views/templates/header.php',  // legacy
];
foreach ($header_candidates as $p) {
    if (is_file($p)) { require $p; break; }
}

/* ---- Base path for routing (adjust fallback to your actual root) ---- */
$BASE = defined('ROOT_BASE') ? constant('ROOT_BASE') : '/student_organizer';
?>
<script>
(function () {
  var BASE = <?= json_encode($BASE, JSON_UNESCAPED_SLASHES) ?>;
  var DASH = BASE + '/index.php';

  // Map navigateTo() ids used by the header
  var original = window.navigateTo;
  window.navigateTo = function(id){
    id = String(id || '').toLowerCase();
    if (id === 'home_dashboard_page' || id === 'home_dashboard' || id === 'home' || id === 'dashboard') {
      location.href = DASH; return;
    }
    if (typeof original === 'function') return original.apply(this, arguments);
  };

  // Normalize header anchors (index.php or # to dashboard)
  var header = document.querySelector('header, [data-section-id="common_header_web"]') || document;
  header.querySelectorAll('a[href]').forEach(function(a){
    var href = a.getAttribute('href') || '';
    if (/^(https?:)?\/\//i.test(href) || href.startsWith('#') || href.startsWith('mailto:')) return;
    var cleaned = href.replace(/^\.\//, '').replace(/^(\.\.\/)+/, '');
    if (cleaned === 'index.php') { a.setAttribute('href', DASH); return; }
    if ((href === '#' || href === '') && isHomeish(a)) a.setAttribute('href', DASH);
  });

  // Catch icon-only buttons via delegation
  header.addEventListener('click', function (e) {
    var el = e.target.closest('a,button,[role="button"]');
    if (!el) return;
    var href = el.getAttribute('href') || '';
    if (/^(https?:)?\/\//i.test(href)) return;
    if (isHomeish(el)) { e.preventDefault(); location.href = DASH; }
  }, true);

  function isHomeish(el) {
    var txt  = (el.textContent || '').trim().toLowerCase();
    var aria = ((el.getAttribute('aria-label') || '') + ' ' + (el.getAttribute('title') || '')).toLowerCase();
    var cls  = el.className || '';
    var byClass = /\bhome\b/i.test(cls) || /\bdashboard\b/i.test(cls) ||
                  (el.matches?.('.nav-home, .dashboard-link, [data-nav="home"], [data-route="home"]') || false);
    var byWord  = txt === 'home' || txt === 'dashboard' || aria.includes('home') || aria.includes('dashboard');
    var iconish = !!(el.querySelector?.('svg[aria-label*="home" i], svg[title*="home" i], i[class*="home" i]'));
    return byClass || byWord || iconish;
  }
})();
</script>
