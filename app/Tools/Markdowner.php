<?php

namespace App\Tools;

use Parsedown;
use League\HTMLToMarkdown\HtmlConverter;

class Markdowner
{
    protected $htmlConverter;

    protected $markdownConverter;

    public function __construct()
    {
        $this->htmlConverter = new HtmlConverter();

        $this->markdownConverter = new Parsedown();
    }

    /**
     * 将 HTML 转换为 Markdown
     */
    public function convertHtmlToMarkdown($html)
    {
        return $this->htmlConverter->convert($html);
    }

    /**
     * 将 Markdown 转换为 HTML
     */
    public function convertMarkdownToHtml($markdown)
    {
        return $this->markdownConverter
                    ->setBreaksEnabled(true) // 允许自动换行
                    ->text($markdown);
    }
}
