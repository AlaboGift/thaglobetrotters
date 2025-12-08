<div class="card-text">
    <span class="rating d-flex align-items-center gap-4 my-2">
        <div class="mr-4 rating">
            @php
                $total_rating = $package->reviews->sum('rating');
                $number_of_ratings = $package->reviews->count();
                $average_ceil_rating = $number_of_ratings ? ceil($total_rating / $number_of_ratings) : 0;
                $total_ratings = $number_of_ratings;
            @endphp
            <i class="bx {{ $average_ceil_rating >= 0 ? 'bxs-star' : 'bx-star' }}"></i>
            <i class="bx {{ $average_ceil_rating >= 2 ? 'bxs-star' : 'bx-star' }}"></i>
            <i class="bx {{ $average_ceil_rating >= 3 ? 'bxs-star' : 'bx-star' }}"></i>
            <i class="bx {{ $average_ceil_rating >= 4 ? 'bxs-star' : 'bx-star' }}"></i>
            <i class="bx {{ $average_ceil_rating >= 5 ? 'bxs-star' : 'bx-star' }}"></i>
        </div>
        <p class="text-muted m-0">{{ number_format($average_ceil_rating, 1) }}</span>
                ({{ number_format($total_ratings) }})</p>
    </span>
</div>