@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Modification Température') }}</div>

                <div class="card-body">

                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <div style="display:none" id="alert">
                        <div class="alert alert-danger" role="alert">
                            <div id="form_validation_body" style="display: inline-block">
                            </div>
                            <a class="float-right" onclick="closeAlert()" style="cursor:pointer">X</a>
                        </div>
                    </div>

                    <form id="update" >
                        @csrf
                        <input name="id" type="hidden"value="{{ $temperature->id  }}">
                        @include('temperatures.form' , ['text_btn' => 'Modifier'])
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $( document ).ready(function() {
            $("form#update").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('temperatures.update') }}',
                    type: 'POST',
                    data: formData,
                    success: function(result){
                        if(result.error){
                            $('#form_validation_body').empty();
                            $.map(result.errors,function(val,key){
                                console.log(val);
                                $('#form_validation_body').append('<li>'+val+'</li>');
                            });
                        $('#alert').show();
                        }else{
                            //Display toastr
                            toastr.success("Bien Modifié");
                            var url = "{{ route('temperatures.index') }}";
                            // Redirect after one second
                            setTimeout(() => {   
                                window.location = url
                            }, 1000);
                        }
                    },
                    // cache: false,
                    contentType: false,
                    processData: false
                });
            });

        });

    // hide alert
    function closeAlert() {
        $('#form_validation_body').html('');
        $('#alert').hide();
    }
    </script>
@endsection