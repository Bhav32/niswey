<form method="post" action="{{ route('contact.update', $contact->id) }}" enctype="multipart/form-data">
 @method('put')
    {{ csrf_field() }}
    <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title" id="crudFormLabel">Contact</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            
        </div>
        <div class="modal-body">
            <!-- First Name Form Input -->
            <div class="form-group @if ($errors->has('first_name')) has-error @endif">
                {!! Form::label('first_name', 'First name') !!}
                {!! Form::text('first_name', $contact->first_name, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
            </div>

            <div class="form-group @if ($errors->has('last_name')) has-error @endif">
                {!! Form::label('last_name', 'Last name') !!}
                {!! Form::text('last_name', $contact->last_name, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
            </div>

            <div class="form-group @if ($errors->has('name')) has-error @endif">
                {!! Form::label('phone_no', 'Contact Number') !!}
                {!! Form::text('phone_no', $contact->phone_no, ['class' => 'form-control', 'placeholder' => 'Phone Number']) !!}
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