<?php
$themeColours = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
$greys = ['100', '200', '300', '400', '500', '600', '700', '800', '900'];
$gradients = [
    'mist' => false,
    'bloom' => false,
    'aurora' => false,
    'sunrise' => false,
    'brand' => true,
    'dusk' => true,
    'ocean' => true,
];
$shadows = ['2', '4', '8', '16', '28', '64'];
$sections = [
    'colours' => 'Colours',
    'gradients' => 'Gradients',
    'elevation' => 'Elevation',
    'typography' => 'Typography',
    'buttons' => 'Buttons',
    'forms' => 'Forms',
    'navigation' => 'Navigation',
    'content' => 'Content',
    'feedback' => 'Feedback',
    'overlays' => 'Overlays',
    'tables' => 'Tables',
];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>Theme demo</title>
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap-custom.css">
    <link rel="stylesheet" href="/assets/css/vendor/bootstrap-icons.css">
    <style>
        body { scroll-padding-top: 5rem; }
        .demo-section { scroll-margin-top: 5rem; }
        .demo-swatch { height: 4rem; }
        .demo-gradient { min-height: 10rem; }
        .demo-toc { top: 5rem; }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#demo-toc" data-bs-smooth-scroll="true" tabindex="0">

<nav class="navbar navbar-expand-lg bg-fluent-acrylic border-0 border-bottom sticky-top">
    <div class="container-xl">
        <a class="navbar-brand fw-semibold" href="#">
            <i class="bi bi-palette2 text-primary me-2"></i>Theme demo
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#demo-navbar" aria-controls="demo-navbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="demo-navbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Articles</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Projects</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Open source</a></li>
                        <li><a class="dropdown-item" href="#">Client work</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Archive</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Disabled</a></li>
            </ul>
            <form class="d-flex" role="search" onsubmit="return false;">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<header class="bg-fluent-bloom border-bottom">
    <div class="container-xl py-5">
        <p class="text-body-secondary fw-semibold mb-2">Fluent 2 for Bootstrap 5.3</p>
        <h1 class="display-4 mb-3">Theme demo</h1>
        <p class="lead col-lg-8 mb-4">Every Bootstrap component rendered with the custom theme, for visually debugging colours, spacing, elevation and states.</p>
        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary btn-lg" href="#buttons">Get started</a>
            <a class="btn btn-outline-secondary btn-lg" href="#gradients">View gradients</a>
        </div>
    </div>
</header>

<div class="container-xl py-5">
    <div class="row g-5">
        <aside class="col-lg-2 d-none d-lg-block">
            <nav id="demo-toc" class="nav flex-column position-sticky demo-toc">
                <?php foreach ($sections as $id => $label): ?>
                    <a class="nav-link py-1 px-2" href="#<?= esc($id, 'attr') ?>"><?= esc($label) ?></a>
                <?php endforeach ?>
            </nav>
        </aside>

        <main class="col-lg-10">

            <!-- Colours -->
            <section id="colours" class="demo-section mb-5">
                <h2 class="mb-4">Colours</h2>
                <h3 class="h6 text-body-secondary">Theme colours</h3>
                <div class="row row-cols-2 row-cols-sm-4 row-cols-xl-8 g-3 mb-4">
                    <?php foreach ($themeColours as $colour): ?>
                        <div class="col">
                            <div class="demo-swatch rounded-3 border bg-<?= $colour ?>"></div>
                            <div class="small mt-1"><?= $colour ?></div>
                        </div>
                    <?php endforeach ?>
                </div>
                <h3 class="h6 text-body-secondary">Subtle backgrounds and emphasis text</h3>
                <div class="row row-cols-2 row-cols-sm-4 g-3 mb-4">
                    <?php foreach (array_slice($themeColours, 0, 6) as $colour): ?>
                        <div class="col">
                            <div class="p-3 rounded-3 border border-<?= $colour ?>-subtle bg-<?= $colour ?>-subtle text-<?= $colour ?>-emphasis small fw-semibold"><?= $colour ?></div>
                        </div>
                    <?php endforeach ?>
                </div>
                <h3 class="h6 text-body-secondary">Neutral ramp</h3>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php foreach ($greys as $grey): ?>
                        <div class="text-center">
                            <div class="demo-swatch rounded-3 border" style="width: 4rem; background: var(--bs-gray-<?= $grey ?>);"></div>
                            <div class="small mt-1"><?= $grey ?></div>
                        </div>
                    <?php endforeach ?>
                </div>
                <h3 class="h6 text-body-secondary">Text utilities</h3>
                <p class="mb-1"><span class="text-body">Body</span> · <span class="text-body-secondary">Secondary</span> · <span class="text-body-tertiary">Tertiary</span> · <span class="text-primary">Primary</span> · <span class="text-success">Success</span> · <span class="text-danger">Danger</span> · <span class="text-warning">Warning</span> · <span class="text-info">Info</span></p>
            </section>

            <!-- Gradients -->
            <section id="gradients" class="demo-section mb-5">
                <h2 class="mb-2">Gradients</h2>
                <p class="text-body-secondary">Use <code>.bg-fluent-{name}</code> classes or the <code>--fluent-gradient-{name}</code> custom properties. Dark gradients switch their text to white automatically.</p>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-3 g-3 mb-4">
                    <?php foreach ($gradients as $name => $isDark): ?>
                        <div class="col">
                            <div class="demo-gradient bg-fluent-<?= $name ?> rounded-3 border p-4 d-flex flex-column justify-content-end">
                                <h3 class="h5 mb-1"><?= ucfirst($name) ?></h3>
                                <p class="small mb-0 text-body-secondary"><code class="<?= $isDark ? 'text-white' : '' ?>">.bg-fluent-<?= $name ?></code> <?= $isDark ? 'with a <a href="#gradients">link</a>' : '' ?></p>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
                <h3 class="h6 text-body-secondary">Acrylic surfaces</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-fluent-bloom rounded-3 p-4 p-md-5">
                            <div class="bg-fluent-acrylic rounded-3 p-4 shadow-fluent-8">
                                <h3 class="h5">Acrylic over bloom</h3>
                                <p class="mb-3">A translucent, blurred surface for content over gradients.</p>
                                <button class="btn btn-primary" type="button">Action</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-fluent-dusk rounded-3 p-4 p-md-5">
                            <div class="bg-fluent-acrylic rounded-3 p-4 shadow-fluent-16 text-body">
                                <h3 class="h5">Acrylic over dusk</h3>
                                <p class="mb-3">The same surface on a dark gradient.</p>
                                <button class="btn btn-outline-secondary" type="button">Action</button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Elevation -->
            <section id="elevation" class="demo-section mb-5">
                <h2 class="mb-4">Elevation and radius</h2>
                <div class="bg-body-tertiary rounded-3 p-4">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-6 g-4 mb-4">
                        <?php foreach ($shadows as $shadow): ?>
                            <div class="col">
                                <div class="bg-white rounded-3 p-3 text-center shadow-fluent-<?= $shadow ?>">
                                    <div class="fw-semibold">Shadow <?= $shadow ?></div>
                                    <code class="small">.shadow-fluent-<?= $shadow ?></code>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="d-flex flex-wrap gap-3">
                        <?php foreach (['rounded-0', 'rounded-1', 'rounded', 'rounded-2', 'rounded-3', 'rounded-4', 'rounded-pill'] as $radius): ?>
                            <div class="bg-white border p-3 small <?= $radius ?>"><?= $radius ?></div>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>

            <!-- Typography -->
            <section id="typography" class="demo-section mb-5">
                <h2 class="mb-4">Typography</h2>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <h1>Heading 1</h1>
                        <h2>Heading 2</h2>
                        <h3>Heading 3</h3>
                        <h4>Heading 4</h4>
                        <h5>Heading 5</h5>
                        <h6>Heading 6</h6>
                        <h3>Heading with <small class="text-body-secondary">muted text</small></h3>
                    </div>
                    <div class="col-lg-6">
                        <?php foreach (range(1, 6) as $size): ?>
                            <p class="display-<?= $size ?> mb-1 text-truncate">Display <?= $size ?></p>
                        <?php endforeach ?>
                    </div>
                </div>
                <hr class="my-4">
                <p class="lead">This is a lead paragraph. It stands out from regular paragraphs and introduces the content below.</p>
                <p>Body copy sits at 16px for comfortable reading. It includes a <a href="#">standard link</a>, <strong>strong text</strong>, <em>emphasised text</em>, <mark>highlighted text</mark>, <del>deleted text</del>, <ins>inserted text</ins>, <small>small text</small>, <abbr title="Cascading Style Sheets">CSS</abbr> as an abbreviation, inline <code>code</code> and a keyboard shortcut <kbd>Ctrl</kbd> + <kbd>K</kbd>.</p>
                <div class="row g-4">
                    <div class="col-md-4">
                        <ul>
                            <li>Unordered list item</li>
                            <li>Another item
                                <ul><li>Nested item</li></ul>
                            </li>
                            <li>Final item</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ol>
                            <li>Ordered list item</li>
                            <li>Second item</li>
                            <li>Third item</li>
                        </ol>
                    </div>
                    <div class="col-md-4">
                        <dl class="row mb-0">
                            <dt class="col-5">Term</dt>
                            <dd class="col-7">Definition</dd>
                            <dt class="col-5">Another</dt>
                            <dd class="col-7">Its definition</dd>
                        </dl>
                    </div>
                </div>
                <figure class="my-4">
                    <blockquote>
                        <p>Design is not just what it looks like and feels like. Design is how it works.</p>
                    </blockquote>
                    <figcaption class="blockquote-footer mt-2">Steve Jobs, <cite title="The New York Times">The New York Times</cite></figcaption>
                </figure>
                <pre class="bg-body-tertiary border rounded-3 p-3"><code>&lt;div class="card bg-fluent-bloom"&gt;
    &lt;div class="card-body"&gt;Hello&lt;/div&gt;
&lt;/div&gt;</code></pre>
            </section>

            <!-- Buttons -->
            <section id="buttons" class="demo-section mb-5">
                <h2 class="mb-4">Buttons</h2>
                <h3 class="h6 text-body-secondary">Solid</h3>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <?php foreach ($themeColours as $colour): ?>
                        <button type="button" class="btn btn-<?= $colour ?>"><?= ucfirst($colour) ?></button>
                    <?php endforeach ?>
                    <button type="button" class="btn btn-link">Link</button>
                </div>
                <h3 class="h6 text-body-secondary">Outline (<code>.btn-outline-secondary</code> is the Fluent default button)</h3>
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <?php foreach ($themeColours as $colour): ?>
                        <button type="button" class="btn btn-outline-<?= $colour ?>"><?= ucfirst($colour) ?></button>
                    <?php endforeach ?>
                </div>
                <h3 class="h6 text-body-secondary">Sizes, states and icons</h3>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <button type="button" class="btn btn-primary btn-lg">Large</button>
                    <button type="button" class="btn btn-primary">Medium</button>
                    <button type="button" class="btn btn-primary btn-sm">Small</button>
                    <button type="button" class="btn btn-primary" disabled>Disabled</button>
                    <button type="button" class="btn btn-outline-secondary" disabled>Disabled</button>
                    <button type="button" class="btn btn-primary active" aria-pressed="true">Active</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-download me-1"></i>Download</button>
                    <button type="button" class="btn btn-outline-secondary" aria-label="Settings"><i class="bi bi-gear"></i></button>
                    <button type="button" class="btn btn-primary" disabled><span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>Saving</button>
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <h3 class="h6 text-body-secondary">Groups and toggles</h3>
                <div class="d-flex flex-wrap gap-3">
                    <div class="btn-group" role="group" aria-label="Basic group">
                        <button type="button" class="btn btn-outline-secondary">Left</button>
                        <button type="button" class="btn btn-outline-secondary">Middle</button>
                        <button type="button" class="btn btn-outline-secondary">Right</button>
                    </div>
                    <div class="btn-group" role="group" aria-label="Radio toggle group">
                        <input type="radio" class="btn-check" name="view" id="view-list" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="view-list"><i class="bi bi-list-ul"></i> List</label>
                        <input type="radio" class="btn-check" name="view" id="view-grid" autocomplete="off">
                        <label class="btn btn-outline-primary" for="view-grid"><i class="bi bi-grid"></i> Grid</label>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Split action</button>
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Forms -->
            <section id="forms" class="demo-section mb-5">
                <h2 class="mb-4">Forms</h2>
                <form class="card" onsubmit="return false;">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="demo-name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="demo-name" placeholder="Jane Smith">
                            </div>
                            <div class="col-md-6">
                                <label for="demo-email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="demo-email" placeholder="name@example.com">
                                </div>
                                <div class="form-text">We will never share your email.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="demo-topic" class="form-label">Topic</label>
                                <select class="form-select" id="demo-topic">
                                    <option selected>Choose a topic</option>
                                    <option>Web development</option>
                                    <option>Design</option>
                                    <option>Linux</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="demo-budget" class="form-label">Budget</label>
                                <div class="input-group">
                                    <span class="input-group-text">£</span>
                                    <input type="number" class="form-control" id="demo-budget" placeholder="1000">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="demo-message" class="form-label">Message</label>
                                <textarea class="form-control" id="demo-message" rows="3" placeholder="How can I help?"></textarea>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="demo-floating" placeholder="Company">
                                    <label for="demo-floating">Floating label</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="demo-file" class="form-label">Attachment</label>
                                <input class="form-control" type="file" id="demo-file">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control form-control-sm mb-2" type="text" placeholder="Small input" aria-label="Small input">
                                <input class="form-control mb-2" type="text" placeholder="Default input" aria-label="Default input">
                                <input class="form-control form-control-lg" type="text" placeholder="Large input" aria-label="Large input">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control mb-2" type="text" value="Disabled input" aria-label="Disabled input" disabled>
                                <input class="form-control mb-2" type="text" value="Readonly input" aria-label="Readonly input" readonly>
                                <input type="text" readonly class="form-control-plaintext" value="Plain text" aria-label="Plain text">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control is-valid mb-2" type="text" value="Valid input" aria-label="Valid input">
                                <input class="form-control is-invalid" type="text" value="Invalid input" aria-label="Invalid input">
                                <div class="invalid-feedback d-block">Please correct this field.</div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check-1" checked>
                                    <label class="form-check-label" for="check-1">Checked checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check-2">
                                    <label class="form-check-label" for="check-2">Unchecked checkbox</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check-3" disabled>
                                    <label class="form-check-label" for="check-3">Disabled checkbox</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radios" id="radio-1" checked>
                                    <label class="form-check-label" for="radio-1">Selected radio</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radios" id="radio-2">
                                    <label class="form-check-label" for="radio-2">Unselected radio</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radios" id="radio-3" disabled>
                                    <label class="form-check-label" for="radio-3">Disabled radio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-1" checked>
                                    <label class="form-check-label" for="switch-1">Notifications on</label>
                                </div>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switch-2">
                                    <label class="form-check-label" for="switch-2">Newsletter off</label>
                                </div>
                                <label for="demo-range" class="form-label mt-2">Range</label>
                                <input type="range" class="form-range" id="demo-range">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </section>

            <!-- Navigation -->
            <section id="navigation" class="demo-section mb-5">
                <h2 class="mb-4">Navigation</h2>
                <h3 class="h6 text-body-secondary">Tabs (Fluent TabList)</h3>
                <ul class="nav nav-tabs mb-3" id="demo-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-overview" data-bs-toggle="tab" data-bs-target="#pane-overview" type="button" role="tab" aria-controls="pane-overview" aria-selected="true">Overview</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-details" data-bs-toggle="tab" data-bs-target="#pane-details" type="button" role="tab" aria-controls="pane-details" aria-selected="false">Details</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-history" data-bs-toggle="tab" data-bs-target="#pane-history" type="button" role="tab" aria-controls="pane-history" aria-selected="false">History</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" type="button" disabled>Disabled</button>
                    </li>
                </ul>
                <div class="tab-content mb-4">
                    <div class="tab-pane fade show active" id="pane-overview" role="tabpanel" aria-labelledby="tab-overview" tabindex="0">Overview content.</div>
                    <div class="tab-pane fade" id="pane-details" role="tabpanel" aria-labelledby="tab-details" tabindex="0">Details content.</div>
                    <div class="tab-pane fade" id="pane-history" role="tabpanel" aria-labelledby="tab-history" tabindex="0">History content.</div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Pills</h3>
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Active</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                            <li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Disabled</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Underline</h3>
                        <ul class="nav nav-underline">
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Active</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Breadcrumb</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Articles</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Fluent theming</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Pagination</h3>
                        <nav aria-label="Pagination example">
                            <ul class="pagination flex-wrap">
                                <li class="page-item disabled"><a class="page-link" aria-label="Previous"><i class="bi bi-chevron-left"></i></a></li>
                                <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><i class="bi bi-chevron-right"></i></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>

            <!-- Content -->
            <section id="content" class="demo-section mb-5">
                <h2 class="mb-4">Content</h2>
                <h3 class="h6 text-body-secondary">Cards</h3>
                <div class="row row-cols-1 row-cols-md-3 g-3 mb-4">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title h5">Basic card</h4>
                                <h5 class="card-subtitle h6 mb-2 text-body-secondary">Subtitle</h5>
                                <p class="card-text">Cards use a subtle stroke with Fluent shadow 4 and an 8px radius.</p>
                                <a href="#" class="card-link">Card link</a>
                                <a href="#" class="card-link">Another link</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-header fw-semibold">Header</div>
                            <div class="card-body">
                                <p class="card-text">A card with a header and footer.</p>
                            </div>
                            <div class="card-footer text-body-secondary small">Updated 3 minutes ago</div>
                        </div>
                    </div>
                    <div class="col">
                        <a href="#" class="card card-hover h-100 text-decoration-none">
                            <div class="bg-fluent-aurora rounded-top" style="height: 6rem;"></div>
                            <div class="card-body">
                                <h4 class="card-title h5">Hoverable card</h4>
                                <p class="card-text text-body">Uses <code>.card-hover</code> to lift to shadow 8.</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">List group</h3>
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action active" aria-current="true">Active item</a>
                            <a href="#" class="list-group-item list-group-item-action">Action item</a>
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">With badge <span class="badge text-bg-primary">14</span></a>
                            <a class="list-group-item list-group-item-action disabled" aria-disabled="true">Disabled item</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Accordion</h3>
                        <div class="accordion" id="demo-accordion">
                            <?php foreach (['One', 'Two', 'Three'] as $index => $label): ?>
                                <div class="accordion-item">
                                    <h4 class="accordion-header">
                                        <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#acc-<?= $index ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="acc-<?= $index ?>">
                                            Accordion item <?= $label ?>
                                        </button>
                                    </h4>
                                    <div id="acc-<?= $index ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" data-bs-parent="#demo-accordion">
                                        <div class="accordion-body">Content for accordion item <?= strtolower($label) ?>.</div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <h3 class="h6 text-body-secondary">Badges</h3>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php foreach ($themeColours as $colour): ?>
                        <span class="badge text-bg-<?= $colour ?>"><?= ucfirst($colour) ?></span>
                    <?php endforeach ?>
                    <span class="badge bg-primary-subtle text-primary-emphasis border border-primary-subtle">Subtle</span>
                    <button type="button" class="btn btn-outline-secondary btn-sm">Inbox <span class="badge text-bg-danger ms-1">4</span></button>
                </div>
                <h3 class="h6 text-body-secondary">Large badges (<code>.badge-lg</code>)</h3>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <?php foreach ($themeColours as $colour): ?>
                        <span class="badge badge-lg text-bg-<?= $colour ?>"><?= ucfirst($colour) ?></span>
                    <?php endforeach ?>
                    <span class="badge badge-lg bg-primary-subtle text-primary-emphasis border border-primary-subtle">Subtle</span>
                    <span class="badge badge-lg text-bg-primary"><i class="bi bi-star-fill"></i>Featured</span>
                    <span class="badge badge-lg text-bg-danger">9</span>
                </div>
                <h3 class="h6 text-body-secondary">Carousel</h3>
                <div id="demo-carousel" class="carousel slide rounded-3 overflow-hidden" data-bs-ride="false">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#demo-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#demo-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#demo-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach (['brand', 'dusk', 'ocean'] as $index => $name): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="bg-fluent-<?= $name ?> d-flex align-items-center justify-content-center text-center" style="height: 16rem;">
                                    <div>
                                        <h4 class="h3"><?= ucfirst($name) ?> slide</h4>
                                        <p class="mb-0">Carousel slide using a Fluent gradient.</p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </section>

            <!-- Feedback -->
            <section id="feedback" class="demo-section mb-5">
                <h2 class="mb-4">Feedback</h2>
                <h3 class="h6 text-body-secondary">Alerts (Fluent MessageBar)</h3>
                <?php foreach (['primary' => 'info-circle', 'success' => 'check-circle', 'warning' => 'exclamation-triangle', 'danger' => 'x-circle', 'secondary' => 'bell'] as $colour => $icon): ?>
                    <div class="alert alert-<?= $colour ?> alert-dismissible fade show d-flex align-items-start gap-2" role="alert">
                        <i class="bi bi-<?= $icon ?>-fill mt-1"></i>
                        <div><strong><?= ucfirst($colour) ?>.</strong> A short message with an <a href="#" class="alert-link">alert link</a>.</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endforeach ?>
                <div class="row g-4 mt-1">
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Progress</h3>
                        <div class="progress mb-2" role="progressbar" aria-label="Progress 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                        <div class="progress mb-2" role="progressbar" aria-label="Progress 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-success" style="width: 60%"></div>
                        </div>
                        <div class="progress mb-2" role="progressbar" aria-label="Progress 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="h6 text-body-secondary">Spinners and placeholders</h3>
                        <div class="d-flex gap-3 mb-3">
                            <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading</span></div>
                            <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading</span></div>
                            <div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading</span></div>
                        </div>
                        <p class="placeholder-glow mb-0" aria-hidden="true">
                            <span class="placeholder col-7 rounded"></span>
                            <span class="placeholder col-4 rounded"></span>
                            <span class="placeholder col-6 rounded"></span>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Overlays -->
            <section id="overlays" class="demo-section mb-5">
                <h2 class="mb-4">Overlays</h2>
                <div class="d-flex flex-wrap gap-2 mb-4">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#demo-delete-modal"><i class="bi bi-trash me-1"></i>Delete record</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#demo-offcanvas" aria-controls="demo-offcanvas">Open offcanvas</button>
                    <button type="button" class="btn btn-outline-secondary" id="demo-toast-trigger">Show toast</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="tooltip" data-bs-title="A Fluent style tooltip">Hover for tooltip</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="popover" data-bs-title="Popover title" data-bs-content="Popover body content with Fluent shadow 16.">Click for popover</button>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Dropdown menu</button>
                        <ul class="dropdown-menu">
                            <li><h6 class="dropdown-header">Header</h6></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-pencil me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item active" href="#" aria-current="true"><i class="bi bi-files me-2"></i>Duplicate (active)</a></li>
                            <li><a class="dropdown-item disabled" aria-disabled="true"><i class="bi bi-share me-2"></i>Share (disabled)</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
                <h3 class="h6 text-body-secondary">Static toast</h3>
                <div class="toast show" role="status" aria-live="polite" aria-atomic="true">
                    <div class="toast-header">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <strong class="me-auto">Saved</strong>
                        <small class="text-body-secondary">Just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">Your changes have been saved.</div>
                </div>
            </section>

            <!-- Tables -->
            <section id="tables" class="demo-section mb-5">
                <h2 class="mb-4">Tables</h2>
                <?php
                $rows = [
                    ['Fluent theme', 'Design', 'Published', 'success'],
                    ['CodeIgniter upgrade', 'Development', 'Draft', 'secondary'],
                    ['Server migration', 'Infrastructure', 'In review', 'warning'],
                    ['Legacy API', 'Development', 'Archived', 'danger'],
                ];
                ?>
                <?php foreach (['table-hover' => 'Hover', 'table-striped' => 'Striped', 'table-bordered table-sm' => 'Bordered and small'] as $classes => $label): ?>
                    <h3 class="h6 text-body-secondary"><?= $label ?></h3>
                    <div class="table-responsive mb-4">
                        <table class="table <?= $classes ?> align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Status</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $index => [$title, $category, $status, $colour]): ?>
                                    <tr>
                                        <th scope="row"><?= $index + 1 ?></th>
                                        <td><?= $title ?></td>
                                        <td><?= $category ?></td>
                                        <td><span class="badge bg-<?= $colour ?>-subtle text-<?= $colour ?>-emphasis"><?= $status ?></span></td>
                                        <td class="text-end"><button type="button" class="btn btn-outline-secondary btn-sm" aria-label="Edit <?= $title ?>"><i class="bi bi-pencil"></i></button></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach ?>
            </section>

        </main>
    </div>
</div>

<footer class="bg-fluent-mist border-top">
    <div class="container-xl py-4 small text-body-secondary">Theme demo. Not available in production.</div>
</footer>

<!-- Delete confirmation modal -->
<div class="modal fade" id="demo-delete-modal" tabindex="-1" aria-labelledby="demo-delete-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="demo-delete-modal-label">Delete record?</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">This will permanently delete the record. This action cannot be undone.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="demo-offcanvas" aria-labelledby="demo-offcanvas-label">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h5" id="demo-offcanvas-label">Offcanvas</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>Offcanvas panels suit navigation and filters on smaller screens.</p>
        <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">Item one</a>
            <a href="#" class="list-group-item list-group-item-action">Item two</a>
        </div>
    </div>
</div>

<!-- Toast container -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="demo-toast" class="toast" role="status" aria-live="polite" aria-atomic="true">
        <div class="toast-header">
            <i class="bi bi-info-circle-fill text-primary me-2"></i>
            <strong class="me-auto">Notification</strong>
            <small class="text-body-secondary">Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">This toast was triggered by a button.</div>
    </div>
</div>

<script src="/assets/js/vendor/bootstrap.bundle.min.js"></script>
<script src="/assets/js/theme-demo.js"></script>
</body>
</html>
