@if(count($sections_below_deal_slider) > 0)
    @foreach($sections_below_deal_slider as $section)
        <div class="jumbotron jumbotron-below-deal-slider" id="section-id-{{$section->id}}">
            <div class="section-below-deal-slider {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
    @endforeach
@endif