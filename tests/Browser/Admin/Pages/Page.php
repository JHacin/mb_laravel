<?php

namespace Tests\Browser\Admin\Pages;

use Tests\Browser\Client\Pages\Page as BasePage;

abstract class Page extends BasePage
{
    /**
     * @param string $url
     * @return string
     */
    protected function prefixUrl(string $url): string
    {
        return '/' . config('backpack.base.route_prefix') . '/' . $url;
    }

    public static function siteElements(): array
    {
        return [
            '@crud-table-body' => '#crudTable > tbody',
            '@data-table-open-row-details' => 'td.dtr-control',
            '@data-table-row-details-modal' => '.dtr-bs-modal.show',
            '@data-table-filter-clear-visible' => '#remove_filters_button:not(.invisible)',
            '@data-table-search-input' => '#crudTable_filter input[type="search"]',
            '@crud-form-submit-button' => '#saveActions button[type="submit"]',
            '@crud-create-button' => 'a.crud-create-button',
            '@crud-clear-filters-link' => '#crudTable_reset_button'
        ];
    }
}
