@if(count($sections_below_main_slider) > 0)
    @foreach($sections_below_main_slider as $section)
        <div class="jumbotron" id="section-id-{{$section->id}}">
            <div class="section-below-main-slider {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
    @endforeach
@endif