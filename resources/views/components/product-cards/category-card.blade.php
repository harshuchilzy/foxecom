@props(['collection'])

<div class="swiper-slide">
    <a href="{{ route('collection.view', $collection->defaultUrl->slug) }}"><img class="w-[250px] h-[150px] lg:w-[100%] lg:h-[220px] rounded-[8px] object-cover shadow-xl" src="{{ $collection->thumbnail?->getUrl('small') }}" alt="{{$collection->translateAttribute('name')}}" /></a>
    <a href="{{ route('collection.view', $collection->defaultUrl->slug) }}"><p class="text-left mt-2 text-[28px] font-semibold">{{$collection->translateAttribute('name')}}</p></a>
</div>
