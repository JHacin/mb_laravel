@push('body-start-scripts')
    <div id="fb-root"></div>
    <script
        async
        defer
        crossorigin="anonymous"
        src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v10.0&appId={{ config('services.facebook.app_id') }}&autoLogAppEvents=1"
        nonce="B9h6Xkyi"
    ></script>
@endpush

<div
    class="fb-page"
    data-href="{{ config('links.facebook_page') }}"
    data-tabs="timeline"
    data-width=""
    data-height=""
    data-small-header="true"
    data-adapt-container-width="true"
    data-hide-cover="false"
    data-show-facepile="true"
>
    <blockquote cite="{{ config('links.facebook_page') }}" class="fb-xfbml-parse-ignore">
        <a href="{{ config('links.facebook_page') }}">Mačji boter</a>
    </blockquote>
</div>
