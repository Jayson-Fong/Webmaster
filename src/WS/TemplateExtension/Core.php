<?php

namespace WS\TemplateExtension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use WS\App;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 * @copyright Jayson Fong 2022
 */
class Core extends AbstractExtension
{

    protected array $configuration;

    public function getFunctions(): array
    {
        $this->configuration = App::getInstance()->configuration();

        return [
            new TwigFunction('templateDir', [$this, 'renderTemplateDir']),
            new TwigFunction('asset', [$this, 'renderAsset']),
            new TwigFunction('buildLink', [$this, 'renderBuildLink'])
        ];
    }

    public function renderTemplateDir(string $category, string $templateName): string
    {
        return $category . DIRECTORY_SEPARATOR . $templateName . '.twig.html';
    }

    public function renderAsset(string $asset, bool $keepFresh = false): string
    {
        return sprintf('%s/assets/%s?%d', $this->configuration['template']['baseUrl'],
            ltrim($asset, '/'), $keepFresh ? time() : '');
    }

    public function renderBuildLink(string $link, array $query = []): string
    {
        if (empty($query))
        {
            return sprintf('%s/%s', $this->configuration['template']['baseUrl'], ltrim($link, '/'));
        }
        return sprintf('%s/%s?', $this->configuration['template']['baseUrl'],
            ltrim($link, '/'), http_build_query($query));
    }

}