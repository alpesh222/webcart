<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            <a data-toggle="collapse" href="#collapse1">
                <div><strong>SEO</strong></div>
            </a>
        </div>
        <div id="collapse1" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
                    {!! Form::label('meta_title','Meta Title:') !!}
                    {!! Form::text('meta_title', null, ['class'=>'form-control', 'placeholder'=>'Enter meta title']) !!}
                </div>

                <div class="form-group{{ $errors->has('meta_desc') ? ' has-error' : '' }}">
                    {!! Form::label('meta_desc','Meta Description:') !!}
                    {!! Form::text('meta_desc', null, ['class'=>'form-control', 'placeholder'=>'Enter meta description']) !!}
                </div>

                <div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : '' }}">
                    {!! Form::label('meta_keywords','Meta Keywords:') !!}
                    {!! Form::text('meta_keywords', null, ['class'=>'form-control', 'placeholder'=>'Enter meta keywords']) !!}
                </div>
            </div>
        </div>
    </div>
</div>