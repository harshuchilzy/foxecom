@props(['collection'])

<div class="swiper-slide">
    <a href="{{ route('collection.view', $collection->defaultUrl->slug) }}"><img class="w-[90%] h-[220px] rounded-[4px] object-cover shadow-xl" src="{{ $collection->thumbnail->getUrl() }}" alt="Big Puff" /></a>
    <a href="{{ route('collection.view', $collection->defaultUrl->slug) }}"><p class="text-left mt-2 text-[28px] font-semibold">{{$collection->translateAttribute('name')}}</p></a>
</div>