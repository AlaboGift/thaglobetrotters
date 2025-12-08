<div class="course-box course-design list-course d-flex">
    <div class="product">
        <div class="product-img">
            <a href="{{ url('product/' . $product['slug']) }}">
                <img class="img-fluid" loading="lazy" style="height: 190px; width: 100%;" alt=""
                    src="{{ $product->thumbnail() }}">
            </a>
            <div class="price combo">
                @if ($product['price'] == 0)
                    <h3>Free</h3>
                @else
                    @if ($product['discounted_price'] > 0)
                        <h3 class="text-warning">{{ currency($product['discounted_price']) }}</h3>
                    @else
                        <h3 class="text-warning">{{ currency($product['price']) }}</h3>
                    @endif
                @endif
            </div>
        </div>
        <div class="product-content">
            <div class="head-course-title">
                <h3 class="title"><a href="{{ url('product/' . $product['slug']) }}">{{ $product['title'] }}</a>
                </h3>
                <div class="all-btn all-category d-flex align-items-center">
                    @if ($product->purchased())
                        <a href="{{ url('lesson/' . $product['slug']) }}" class="btn btn-primary cart-btn">
                            Access
                        </a>
                    @else
                        @if ($product['price'] == 0)
                            :

                            <a href="{{ url('free-product/' . $product['slug']) }}" class="btn btn-primary cart-btn">
                                Get for free
                            </a>
                        @else
                            <a href="{{ url('buy-product/' . $product['slug']) }}" class="btn btn-primary cart-btn">
                                <i class="fas fa-shopping-bag"></i>
                                Buy Now
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <div class="course-info border-bottom-0 pb-0 d-flex align-items-center">
                <div class="rating-img d-flex align-items-center">
                    <img loading="lazy" src="{{ asset('public/home-assets/img/icon/people.svg') }}" alt="">
                    <p>
                        {{ $product->students()->count() }}
                        {{ \Str::plural('User', $product->students()->count() ?? 0) }}
                        enrolled
                    </p>
                </div>
                <div class="course-view d-flex align-items-center">
                    <img loading="lazy" src="{{ asset('public/home-assets/img/icon/icon-01.svg') }}" alt="">
                    <p>{{ $product['product_type'] }}</p>
                </div>
            </div>
            @php
                $total_rating = $product->ratings()->sum('rating');
                $number_of_ratings = $product->ratings()->count();
                $average_ceil_rating = $number_of_ratings ? ceil($total_rating / $number_of_ratings) : 0;
                $total_ratings = $number_of_ratings;
            @endphp
            <div class="rating">
                <i class="fas fa-star {{ $average_ceil_rating >= 1 ? 'filled' : '' }}"></i>
                <i class="fas fa-star {{ $average_ceil_rating >= 2 ? 'filled' : '' }}"></i>
                <i class="fas fa-star {{ $average_ceil_rating >= 3 ? 'filled' : '' }}"></i>
                <i class="fas fa-star {{ $average_ceil_rating >= 4 ? 'filled' : '' }}"></i>
                <i class="fas fa-star {{ $average_ceil_rating >= 5 ? 'filled' : '' }}"></i>
                <span class="d-inline-block average-rating"><span>{{ number_format($average_ceil_rating, 1) }}</span>
                    ({{ number_format($total_ratings) }}) </span>
            </div>
            <div class="course-group d-flex mb-0">
                <div class="course-group-img d-flex">
                    <a href="{{ url('creator/' . $product->creator->id) }}"><img loading="lazy"
                            src="{{ $product->creator->getImage() }}" alt="" class="img-fluid" height="50"
                            width="50"></a>
                    <div class="course-name">
                        <h4><a
                                href="{{ url('creator/' . $product->creator->id) }}">{{ $product->creator->getName() }}</a>
                        </h4>
                        <p>Creator</p>
                    </div>
                </div>
                <div class="course-share d-flex align-items-center justify-content-center">
                    <a href="#rate"><i
                            class="fa-regular fa-heart {{ in_array($product['id'], []) ? 'heart-active' : '' }} "
                            role="button" id="{{ $product['id'] }}" onclick="handleWishList(this)"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
