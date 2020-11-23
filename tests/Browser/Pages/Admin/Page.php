<?php

namespace Tests\Browser\Pages\Admin;

use Tests\Browser\Pages\Page as BasePage;

abstract class Page extends BasePage
{
    /**
     * @param string $url
     * @return string
     */
    protected function prefixUrl(string $url)
    {
        return '/' . config('backpack.base.route_prefix') . '/' . $url;
    }

    /**
     * @inheritDoc
     */
    public static function siteElements()
    {
        return [
            '@crud-table-body' => '#crudTable > tbody',
            '@data-table-open-row-details' => 'td.dtr-control',
            '@data-table-row-details-modal' => '.dtr-bs-modal.show',
            '@data-table-filter-clear-visible' => '#remove_filters_button:not(.invisible)',
            '@data-table-search-input' => '#crudTable_filter input[type="search"]',
            '@crud-form-submit-button' => '#saveActions button[type="submit"]',
        ];
    }
}
