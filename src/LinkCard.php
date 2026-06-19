<?php

/**
 * Renders a safe HTML card for a link, with escaped title and domain.
 */
class LinkCardRenderer
{
    private string $defaultDomain;
    private string $defaultKeyword;

    public function __construct(string $domain = 'indexweb-aiyouxi.com.cn', string $keyword = '爱游戏')
    {
        $this->defaultDomain = $domain;
        $this->defaultKeyword = $keyword;
    }

    /**
     * Build an associative array with link card data.
     *
     * @param string $url
     * @param string $title
     * @param string $description
     * @return array
     */
    public function prepareCardData(string $url, string $title = '', string $description = ''): array
    {
        $parsedUrl = parse_url($url);
        $host = $parsedUrl['host'] ?? $this->defaultDomain;
        $scheme = $parsedUrl['scheme'] ?? 'https';

        if (empty($title)) {
            $title = $this->defaultKeyword . ' - 最新资讯';
        }

        if (empty($description)) {
            $description = '关注' . $this->defaultKeyword . '，尽在' . $host;
        }

        return [
            'url'         => $url,
            'host'        => $host,
            'scheme'      => $scheme,
            'title'       => $title,
            'description' => $description,
        ];
    }

    /**
     * Render a link card as escaped HTML.
     *
     * @param array $cardData
     * @return string
     */
    public function renderHtml(array $cardData): string
    {
        $escapedUrl = htmlspecialchars($cardData['url'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedHost = htmlspecialchars($cardData['host'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedTitle = htmlspecialchars($cardData['title'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $escapedDescription = htmlspecialchars($cardData['description'], ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return <<<HTML
<div class="link-card">
    <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer" class="link-card-link">
        <span class="link-card-host">{$escapedHost}</span>
        <span class="link-card-title">{$escapedTitle}</span>
        <span class="link-card-description">{$escapedDescription}</span>
    </a>
</div>
HTML;
    }

    /**
     * Quick helper: create and render a card in one call.
     *
     * @param string $url
     * @param string $title
     * @param string $description
     * @return string
     */
    public function buildCard(string $url, string $title = '', string $description = ''): string
    {
        $data = $this->prepareCardData($url, $title, $description);
        return $this->renderHtml($data);
    }
}

// --- Example usage (can be removed in production) ---
/*
$renderer = new LinkCardRenderer();
$sampleUrl = 'https://indexweb-aiyouxi.com.cn/game/123';
echo $renderer->buildCard($sampleUrl, '爱游戏新作上线', '探索无限可能的游戏世界');
*/