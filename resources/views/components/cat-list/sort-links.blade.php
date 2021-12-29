<h6 class="font-semibold">Razvrsti po:</h6>
<div class="flex items-baseline">
    <span class="mr-2">
        <x-cat-list.sort-link-toggle query="sponsorship_count" label="številu botrov" />
    </span>
    <span class="mr-1">
        <x-cat-list.sort-link-arrow query="sponsorship_count" direction="asc" />
    </span>
    <x-cat-list.sort-link-arrow query="sponsorship_count" direction="desc" />
</div>
<div class="flex items-baseline">
    <span class="mr-2">
        <x-cat-list.sort-link-toggle query="age" label="starosti" />
    </span>
    <span class="mr-1">
        <x-cat-list.sort-link-arrow query="age" direction="asc" />
    </span>
    <x-cat-list.sort-link-arrow query="age" direction="desc" />
</div>
<div class="flex items-baseline">
    <span class="mr-2">
        <x-cat-list.sort-link-toggle query="id" label="datumu objave" />
    </span>
    <span class="mr-1">
        <x-cat-list.sort-link-arrow query="id" direction="asc" />
    </span>
    <x-cat-list.sort-link-arrow query="id" direction="desc" />
</div>
