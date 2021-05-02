@if(count($sections_above_side_banners) > 0)
    @foreach($sections_above_side_banners as $section)
        <div class="jumbotron right-side-jumbotron right-side-top-jumbotron" id="section-id-{{$section->id}}">
            <div class="section-above-side-banners {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
        @if(!$loop->last)
			<hr>
        @endif
    @endforeach
@endif