<?php
/**
 * ReelShelf — original, rights-conscious movie discovery catalogue.
 * Requires PHP 8.0+. No database or third-party PHP packages are required.
 * Replace the demo records below only with content and artwork you own or license.
 */
declare(strict_types=1);

function e(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$catalog = [
    [
        'slug'=>'the-last-orbit','title'=>'The Last Orbit','year'=>2026,'kind'=>'Movie','genres'=>['Sci-Fi','Adventure'],
        'language'=>'English','quality'=>'4K','runtime'=>'1h 58m','rating'=>'8.4','featured'=>true,
        'poster'=>'assets/posters/last-orbit.svg','accent'=>'violet','tagline'=>'One signal. One final journey.',
        'synopsis'=>'When a forgotten beacon begins transmitting from beyond the mapped frontier, a lone navigation crew follows the signal and discovers a mystery that challenges everything they know about home.'
    ],
    [
        'slug'=>'paper-moons','title'=>'Paper Moons','year'=>2025,'kind'=>'Movie','genres'=>['Drama','Romance'],
        'language'=>'English','quality'=>'HD','runtime'=>'1h 46m','rating'=>'7.9','featured'=>false,
        'poster'=>'assets/posters/paper-moons.svg','accent'=>'rose','tagline'=>'Some memories never fade.',
        'synopsis'=>'Two childhood friends return to their coastal hometown for one summer and find that the people they became are not quite the people they expected to be.'
    ],
    [
        'slug'=>'the-quiet-city','title'=>'The Quiet City','year'=>2026,'kind'=>'Series','genres'=>['Mystery','Thriller'],
        'language'=>'English','quality'=>'4K','runtime'=>'8 Episodes','rating'=>'8.1','featured'=>false,
        'poster'=>'assets/posters/quiet-city.svg','accent'=>'teal','tagline'=>'Every street keeps a secret.',
        'synopsis'=>'A sound archivist discovers that recordings from an apparently ordinary city contain conversations that have not happened yet.'
    ],
    [
        'slug'=>'monsoon-road','title'=>'Monsoon Road','year'=>2025,'kind'=>'Movie','genres'=>['Drama','South Asian'],
        'language'=>'Urdu','quality'=>'HD','runtime'=>'2h 03m','rating'=>'8.0','featured'=>false,
        'poster'=>'assets/posters/monsoon-road.svg','accent'=>'amber','tagline'=>'The long way home.',
        'synopsis'=>'During a season of heavy rain, a young mechanic sets out across the countryside to reunite a divided family before their village festival.'
    ],
    [
        'slug'=>'small-giants','title'=>'Small Giants','year'=>2024,'kind'=>'Animation','genres'=>['Animation','Family','Adventure'],
        'language'=>'English','quality'=>'HD','runtime'=>'1h 32m','rating'=>'7.7','featured'=>false,
        'poster'=>'assets/posters/small-giants.svg','accent'=>'lime','tagline'=>'Big courage comes in small packages.',
        'synopsis'=>'Three tiny inventors build an unlikely flying machine to help their forest community prepare for the first winter in a hundred years.'
    ],
    [
        'slug'=>'blue-hour','title'=>'Blue Hour','year'=>2025,'kind'=>'Movie','genres'=>['Crime','Mystery'],
        'language'=>'English','quality'=>'HD','runtime'=>'1h 51m','rating'=>'7.6','featured'=>false,
        'poster'=>'assets/posters/blue-hour.svg','accent'=>'blue','tagline'=>'The truth arrives after dark.',
        'synopsis'=>'A night-shift radio host receives a call that links an old missing-person case to a new mystery unfolding across the city.'
    ],
    [
        'slug'=>'earth-in-miniature','title'=>'Earth in Miniature','year'=>2024,'kind'=>'Documentary','genres'=>['Documentary','Nature'],
        'language'=>'English','quality'=>'4K','runtime'=>'52 min','rating'=>'9.0','featured'=>false,
        'poster'=>'assets/posters/earth-miniature.svg','accent'=>'green','tagline'=>'A bigger world, seen up close.',
        'synopsis'=>'A macro journey into overlooked ecosystems reveals the intricate lives of insects, mosses, and the small creatures beneath our feet.'
    ],
    [
        'slug'=>'second-sun','title'=>'Second Sun','year'=>2026,'kind'=>'Series','genres'=>['Sci-Fi','Drama'],
        'language'=>'English','quality'=>'HD','runtime'=>'6 Episodes','rating'=>'8.2','featured'=>false,
        'poster'=>'assets/posters/second-sun.svg','accent'=>'orange','tagline'=>'Tomorrow has already begun.',
        'synopsis'=>'After a second star appears in the sky, a group of researchers must explain the impossible while the world adapts to a new dawn.'
    ],
    [
        'slug'=>'lantern-season','title'=>'Lantern Season','year'=>2023,'kind'=>'Short Film','genres'=>['Drama','Family'],
        'language'=>'Urdu','quality'=>'HD','runtime'=>'24 min','rating'=>'8.3','featured'=>false,
        'poster'=>'assets/posters/lantern-season.svg','accent'=>'gold','tagline'=>'A little light changes everything.',
        'synopsis'=>'A child and her grandfather revive a forgotten neighbourhood tradition, one handmade lantern at a time.'
    ],
    [
        'slug'=>'static-between-us','title'=>'Static Between Us','year'=>2025,'kind'=>'Series','genres'=>['Thriller','Drama'],
        'language'=>'English','quality'=>'HD','runtime'=>'5 Episodes','rating'=>'7.8','featured'=>false,
        'poster'=>'assets/posters/static-between-us.svg','accent'=>'red','tagline'=>'Listen carefully.',
        'synopsis'=>'Two podcast producers investigate an anonymous recording that seems to predict small events before they happen.'
    ],
    [
        'slug'=>'wild-water','title'=>'Wild Water','year'=>2024,'kind'=>'Documentary','genres'=>['Documentary','Nature'],
        'language'=>'English','quality'=>'4K','runtime'=>'1h 04m','rating'=>'8.6','featured'=>false,
        'poster'=>'assets/posters/wild-water.svg','accent'=>'cyan','tagline'=>'Follow the current.',
        'synopsis'=>'From mountain springs to open ocean, this documentary follows the people and wildlife whose lives are shaped by water.'
    ],
    [
        'slug'=>'the-clockmakers-map','title'=>'The Clockmaker’s Map','year'=>2023,'kind'=>'Animation','genres'=>['Animation','Fantasy','Adventure'],
        'language'=>'English','quality'=>'HD','runtime'=>'1h 27m','rating'=>'7.9','featured'=>false,
        'poster'=>'assets/posters/clockmakers-map.svg','accent'=>'purple','tagline'=>'Time has a hidden side.',
        'synopsis'=>'A curious apprentice finds a map hidden inside a broken clock and sets off to repair the hours that have gone missing from her town.'
    ],
];

$allCategories = ['All','Movie','Series','Animation','Documentary','Short Film'];
$allGenres = ['Sci-Fi','Adventure','Drama','Romance','Mystery','Thriller','South Asian','Family','Crime','Nature','Fantasy'];
$allowedFilters = array_merge($allCategories, $allGenres);
$category = trim((string)($_GET['category'] ?? 'All'));
if (!in_array($category, $allowedFilters, true)) $category = 'All';
$query = trim((string)($_GET['q'] ?? ''));
$slug = preg_replace('/[^a-z0-9-]/', '', strtolower((string)($_GET['movie'] ?? '')));
$detail = null;
if ($slug !== '') {
    foreach ($catalog as $item) if ($item['slug'] === $slug) { $detail = $item; break; }
}

$results = array_values(array_filter($catalog, static function(array $item) use ($category, $query): bool {
    $categoryMatch = $category === 'All' || $item['kind'] === $category || in_array($category, $item['genres'], true);
    $haystack = strtolower($item['title'].' '.$item['kind'].' '.implode(' ', $item['genres']).' '.$item['language'].' '.$item['year']);
    $queryMatch = $query === '' || str_contains($haystack, strtolower($query));
    return $categoryMatch && $queryMatch;
}));

$featured = $catalog[0];
$pageTitle = $detail ? $detail['title'].' — ReelShelf' : ($category !== 'All' ? $category.' — ReelShelf' : 'Discover films and series — ReelShelf');
$pageDescription = $detail ? $detail['synopsis'] : 'Discover original film and series listings, browse by category, and find official viewing options with ReelShelf.';
function justWatchUrl(string $title): string {
    return 'https://www.justwatch.com/pk/search?q='.rawurlencode($title);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta name="theme-color" content="#101114">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="site-shell">
  <div class="notice-bar"><span class="notice-dot"></span> Discover stories worth staying up for <span class="notice-separator">/</span> <span class="notice-muted">Demo catalogue · original sample artwork</span></div>
  <header class="site-header">
    <a class="brand" href="index.php" aria-label="ReelShelf homepage"><span class="brand-mark">R</span><span>reel<span class="brand-accent">shelf</span><small>YOUR NEXT STORY STARTS HERE</small></span></a>
    <button class="menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">☰</button>
    <nav class="main-nav" aria-label="Main navigation">
      <a class="<?= $category==='All' && !$detail ? 'active' : '' ?>" href="index.php">Discover</a>
      <a href="index.php?category=Movie">Movies</a>
      <a href="index.php?category=Series">Series</a>
      <a href="index.php?category=Animation">Animation</a>
      <a href="index.php?category=Documentary">Documentaries</a>
    </nav>
    <form class="header-search" action="index.php" method="get" role="search">
      <?php if ($category !== 'All'): ?><input type="hidden" name="category" value="<?= e($category) ?>"><?php endif; ?>
      <label class="sr-only" for="site-search">Search titles, genres or languages</label>
      <span class="search-icon">⌕</span><input id="site-search" name="q" type="search" placeholder="Search titles..." value="<?= e($query) ?>">
      <button type="submit" aria-label="Search">↵</button>
    </form>
  </header>

  <?php if ($detail): ?>
    <main>
      <div class="breadcrumbs"><a href="index.php">Discover</a><span>›</span><span><?= e($detail['title']) ?></span></div>
      <section class="detail-layout">
        <div class="detail-poster"><img src="<?= e($detail['poster']) ?>" alt="Original artwork for <?= e($detail['title']) ?>"><span class="poster-badge"><?= e($detail['quality']) ?></span></div>
        <div class="detail-copy">
          <div class="eyebrow">REELSHELF PICK <span class="eyebrow-line"></span></div>
          <h1><?= e($detail['title']) ?></h1>
          <p class="detail-tagline"><?= e($detail['tagline']) ?></p>
          <div class="metadata"><span><?= e($detail['year']) ?></span><i></i><span><?= e($detail['kind']) ?></span><i></i><span><?= e($detail['runtime']) ?></span><i></i><span><?= e($detail['language']) ?></span></div>
          <div class="detail-rating"><span class="star">★</span><strong><?= e($detail['rating']) ?></strong><span class="rating-caption">sample editorial score</span></div>
          <p class="detail-synopsis"><?= e($detail['synopsis']) ?></p>
          <div class="genre-list"><?php foreach ($detail['genres'] as $genre): ?><a href="index.php?category=<?= rawurlencode($genre) ?>"><?= e($genre) ?></a><?php endforeach; ?></div>
          <a class="primary-button" href="<?= e(justWatchUrl($detail['title'])) ?>" target="_blank" rel="noopener noreferrer">Find official viewing options <span>↗</span></a>
          <p class="legal-note">Availability varies by country. ReelShelf does not host video files or provide unauthorized downloads.</p>
        </div>
      </section>
      <section class="section-block related-block"><div class="section-heading"><div><span class="eyebrow">KEEP EXPLORING</span><h2>You might also like</h2></div><a class="text-link" href="index.php">View all titles <span>→</span></a></div>
        <div class="poster-grid compact-grid">
          <?php $count=0; foreach ($catalog as $item): if ($item['slug']===$detail['slug']) continue; if ($count>=4) break; $count++; ?>
          <a class="movie-card" href="index.php?movie=<?= e($item['slug']) ?>"><div class="poster-wrap"><img loading="lazy" src="<?= e($item['poster']) ?>" alt="Original artwork for <?= e($item['title']) ?>"><span class="quality-badge"><?= e($item['quality']) ?></span><span class="poster-hover">View details <b>↗</b></span></div><div class="movie-info"><div class="movie-subline"><span><?= e($item['year']) ?></span><span><?= e($item['kind']) ?></span></div><h3><?= e($item['title']) ?></h3><div class="movie-genres"><?= e(implode(' · ', array_slice($item['genres'],0,2))) ?></div></div></a>
          <?php endforeach; ?>
        </div>
      </section>
    </main>
  <?php else: ?>
    <main>
      <?php if ($query === '' && $category === 'All'): ?>
      <section class="hero">
        <div class="hero-art"><img src="<?= e($featured['poster']) ?>" alt="Original artwork for <?= e($featured['title']) ?>"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <div class="hero-kicker"><span class="kicker-dot"></span> FEATURED STORY <span class="kicker-rule"></span> <?= e($featured['year']) ?></div>
          <h1><?= e($featured['title']) ?></h1>
          <p class="hero-tagline"><?= e($featured['tagline']) ?></p>
          <div class="hero-meta"><span class="hero-rating">★ <?= e($featured['rating']) ?></span><span><?= e($featured['kind']) ?></span><span><?= e($featured['runtime']) ?></span><span class="quality-pill"><?= e($featured['quality']) ?></span></div>
          <p class="hero-description"><?= e($featured['synopsis']) ?></p>
          <div class="hero-actions"><a class="primary-button" href="index.php?movie=<?= e($featured['slug']) ?>">Explore title <span>→</span></a><a class="secondary-button" href="<?= e(justWatchUrl($featured['title'])) ?>" target="_blank" rel="noopener noreferrer">Official viewing options <span>↗</span></a></div>
        </div>
        <div class="hero-index"><span>01</span><span class="index-line"></span><span>12</span><small>CURATED DEMOS</small></div>
        <div class="hero-bottom-label">STORIES THAT STAY WITH YOU</div>
      </section>
      <?php endif; ?>

      <section class="section-block catalog-block">
        <div class="section-heading"><div><span class="eyebrow"><?= $query !== '' ? 'SEARCH RESULTS' : ($category==='All' ? 'HANDPICKED FOR YOU' : 'BROWSE COLLECTION') ?></span><h2><?= $query !== '' ? 'Results for “'.e($query).'”' : ($category==='All' ? 'Explore the shelf' : e($category)) ?></h2><p class="section-subtitle">Distinct stories, thoughtful picks, and something new to discover.</p></div><div class="result-count"><strong><?= count($results) ?></strong><span><?= count($results)===1?'TITLE':'TITLES' ?></span></div></div>
        <div class="filter-row" aria-label="Filter titles">
          <?php foreach ($allCategories as $cat): ?><a class="filter-chip <?= $category===$cat?'selected':'' ?>" href="index.php?category=<?= rawurlencode($cat) ?><?= $query!==''?'&q='.rawurlencode($query):'' ?>"><?= e($cat==='All'?'All titles':($cat==='Short Film'?'Short films':($cat==='Documentary'?'Documentaries':($cat==='Movie'?'Movies':$cat)))) ?></a><?php endforeach; ?>
        </div>
        <?php if ($results): ?>
        <div class="poster-grid">
          <?php foreach ($results as $index => $item): ?>
          <a class="movie-card" href="index.php?movie=<?= e($item['slug']) ?>">
            <div class="poster-wrap"><img loading="lazy" src="<?= e($item['poster']) ?>" alt="Original artwork for <?= e($item['title']) ?>"><span class="quality-badge"><?= e($item['quality']) ?></span><?php if ($item['featured']): ?><span class="featured-badge">EDITOR'S PICK</span><?php endif; ?><span class="poster-hover">View details <b>↗</b></span></div>
            <div class="movie-info"><div class="movie-subline"><span><?= e($item['year']) ?></span><span><?= e($item['kind']) ?></span></div><h3><?= e($item['title']) ?></h3><div class="movie-genres"><?= e(implode(' · ', array_slice($item['genres'],0,2))) ?></div><div class="card-bottom"><span><?= e($item['language']) ?></span><span class="card-rating"><b>★</b> <?= e($item['rating']) ?></span></div></div>
          </a>
          <?php endforeach; ?>
        </div>
        <?php else: ?>
          <div class="empty-state"><div class="empty-icon">⌕</div><h3>No titles found</h3><p>Try a different title, language, or category.</p><a class="secondary-button" href="index.php">Clear filters <span>↗</span></a></div>
        <?php endif; ?>
        <div class="catalog-footnote"><span class="footnote-icon">✦</span><span>All titles and poster artwork on this starter site are fictional demo content. Add only media you have permission to promote.</span></div>
      </section>
    </main>
  <?php endif; ?>
  <footer class="site-footer"><div class="footer-top"><a class="brand footer-brand" href="index.php"><span class="brand-mark">R</span><span>reel<span class="brand-accent">shelf</span><small>YOUR NEXT STORY STARTS HERE</small></span></a><p>A discovery catalogue for curious viewers.</p><a href="mailto:hello@example.com" class="footer-contact">Contact <span>↗</span></a></div><div class="footer-bottom"><span>© <?= date('Y') ?> ReelShelf. Original demo project.</span><span>Built for licensed catalogues and official viewing links.</span><a href="index.php">Back to top ↑</a></div></footer>
</div>
<script src="assets/app.js"></script>
</body>
</html>
