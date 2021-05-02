@if(count($sections_above_footer) > 0)
    @foreach($sections_above_footer as $section)
        <div class="jumbotron" id="section-id-{{$section->id}}">
            <div class="section-above-footer {{!$section->full_width ? 'container' : ''}}">
                {!! $section->content !!}
            </div>
        </div>
    @endforeach
@endif