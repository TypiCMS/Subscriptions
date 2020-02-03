<ul class="subscription-list-list">
    @foreach ($items as $subscription)
    @include('subscriptions::public._list-item')
    @endforeach
</ul>
