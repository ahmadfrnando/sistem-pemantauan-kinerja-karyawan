@unless ($breadcrumbs->isEmpty())
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        @foreach ($breadcrumbs as $breadcrumb)

        @if ($breadcrumb->url && !$loop->last)
        <li class="breadcrumb-item text-sm"><a href="{{ $breadcrumb->url }}" class="opacity-5 text-dark">{{ $breadcrumb->title }}</a></li>
        @else
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">{{ $breadcrumb->title }}</li>
        @endif
        @endforeach
    </ol>
    <h6 class="font-weight-bold text-dark mb-0">{{ $breadcrumbs->last()->title }}</h6>
</nav>
@endunless