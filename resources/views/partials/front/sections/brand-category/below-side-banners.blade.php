@if(count($sections_below_side_banners) > 0)
    @foreach($sections_below_side_banners as $section)
        <div class="jumbotron right-side-jumbotron right-side-bottom-jumbotron" id="section-id-{{$section->id}}">
            <div class="section-below-side-banners {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
        <hr>
    @endforeach
@endif