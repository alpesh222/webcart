@if(count($sections_above_side_banners) > 0)
    @foreach($sections_above_side_banners as $section)
        <div class="jumbotron left-side-jumbotron left-side-top-jumbotron" id="section-id-{{$section->id}}">
            <div class="section-above-side-banners {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
        <hr>
    @endforeach
@endif