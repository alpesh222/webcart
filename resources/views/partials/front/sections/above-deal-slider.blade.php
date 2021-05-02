@if(count($sections_above_deal_slider) > 0)
    @foreach($sections_above_deal_slider as $section)
        <div class="jumbotron main-side-jumbotron jumbotron-above-deal-slider" id="section-id-{{$section->id}}">
            <div class="section-above-deal-slider {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
    @endforeach
@endif