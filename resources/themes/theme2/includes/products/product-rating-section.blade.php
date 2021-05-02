<div class="star-rating" role="img" >
    @if($product->reviews() && count($product->reviews->where('approved', 1)) > 0)
        @php
            $total_rating   = $product->reviews->where('approved', 1)->where('rating', '!=', null)->sum('rating');
            $total_reviews  = count($product->reviews->where('approved', 1)->where('rating', '!=', null));
            $rating_avg     = $total_rating / $total_reviews;
            $empty_stars    = 5 - $rating_avg;
        @endphp
    @else
        @php
            $rating_avg   = 0;
            $empty_stars  = 5 - $rating_avg;
        @endphp
    @endif
    @for($i=1; $i <= $rating_avg; $i++)
        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
    @endfor
    @for($i=1; $i <= $empty_stars; $i++)
        <span class="float-right"><i class="text-warning fa fa-star-o"></i></span>
    @endfor
</div>