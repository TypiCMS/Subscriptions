{{--
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "",
    "name": "{{ $subscription->title }}",
    "description": "{{ $subscription->summary !== '' ? $subscription->summary : strip_tags($subscription->body) }}",
    "image": [
        "{{ $subscription->present()->image() }}"
    ],
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "{{ $subscription->uri() }}"
    }
}
</script>
--}}
