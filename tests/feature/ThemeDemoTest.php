<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class ThemeDemoTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testThemeDemoPageRenders(): void
    {
        $result = $this->get('theme-demo');

        $result->assertStatus(200);
        $result->assertSee('Theme demo', 'title');
        $result->assertSee('bootstrap-custom.css');
    }

    public function testThemeDemoShowsGradientsAndComponents(): void
    {
        $result = $this->get('theme-demo');

        foreach (['bg-fluent-bloom', 'bg-fluent-dusk', 'bg-fluent-acrylic', 'btn-primary', 'modal', 'accordion', 'nav-tabs'] as $marker) {
            $this->assertStringContainsString($marker, $result->getBody());
        }
    }
}
