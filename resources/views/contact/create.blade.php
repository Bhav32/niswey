<form method="post" action="{{ route('contact.store') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Contact</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- Form Input -->
           
            <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                {!! Form::label('first_name', 'First name') !!}
                {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'First Name']) !!}
                @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
            </div>

            <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                {!! Form::label('last_name', 'Last name') !!}
                {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Last Name']) !!}
                @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
            </div>

            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('phone_no', 'Contact Number') !!}
                {!! Form::tel('phone_no', null, ['class' => 'form-control', 'minlength'=> '10', 'pattern' => '[0-9]{10}', 'required' => 'required', 'placeholder' => 'Eg - 9637203938']) !!}
                @if ($errors->has('phone_no')) <p class="help-block">{{ $errors->first('phone_no') }}</p> @endif
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            <!-- Submit Form Button -->
            {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-primary ladda-button example-button m-1', 'data-style' => 'expand-right']) !!}
        </div>
    </div>
{!! Form::close() !!}