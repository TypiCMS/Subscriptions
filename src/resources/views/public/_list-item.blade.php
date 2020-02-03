<li class="subscription-list-item">
    <a class="subscription-list-item-link" href="{{ $subscription->uri() }}" title="{{ $subscription->title }}">
        <span class="subscription-list-item-title">{!! $subscription->title !!}</span>
        <span class="subscription-list-item-image-wrapper">
            <img class="subscription-list-item-image" src="{!! $subscription->present()->image(null, 200) !!}" alt="">
        </span>
    </a>
</li>
