@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Nouvelle Température ') }}</div>

                <div class="card-body">

                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <div style="display:none" id="alert">
                        <div class="alert alert-danger" role="alert">
                            <div id="form_validation_body" class="d-inline-block">
                            </div>
                            <a class="float-right" onclick="closeAlert()" style="cursor:pointer">X</a>
                        </div>
                    </div>

                    <form id="store" >
                        @csrf
                        @include('temperatures.form' , ['text_btn' => 'Enregistrer'])
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
            $("form#store").submit(function(e) {
                e.preventDefault();
                // alert("okkk");
                var formData = new FormData(this);
                $.ajax({
                    url: '{{ route('temperatures.store') }}',
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
                            toastr.success("Bien Ajouté");
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