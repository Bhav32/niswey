<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/datatables.min.css')}}"> 
        <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
        <style>
            .container{
                max-width: 88%;
            }
            .mg-10{
                margin-right: 10px;
            }
        </style>
        <title>Niswey</title>
    </head>

    <body>
        <div class="container my-5">
            <h2 class="fs-5 fw-bold text-center">Welcome To Niswey contact details</h2>
            <div class="row">
                <div class="d-flex my-2">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                        Import Contacts
                    </button>
                </div>
            </div>
        </div>

        <div class="container">
         @include('flash.message')

            <table id="datatable" aria-describedby="datatable" class="display table" style="width:100%">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <!-- Modal for Import Contacts -->
        <div class="modal fade" id="exampleModal" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Import Contacts</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="contact/import" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" id="file" name="file" class="form-control" style="padding: 3px;">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Crud Operations -->
        <div class="modal fade" id="crudForm" tabindex="-1" role="dialog" aria-labelledby="crudFormLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                </div>
            </div>
        </div>
        
        <!-- Scripts -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="{{asset('assets/js/datatables.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
        
        <script>
            $(document).ready(function() {
                toastr.options.timeOut = 10000;
            });
            
            (function($) {
                toastr.options = {
                    positionClass : 'toast-bottom-right',
                }
            })(jQuery);

            setTimeout(function() {
                $('#message').fadeOut('slow');
            }, 2000); 

            var editor;
            var table = $('#datatable').DataTable({
                'ajax': '{!! route("contact.datatable") !!}',
                "ordering": false,
                columns:[
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'first_name'},
                    { data: 'last_name'},
                    { data: 'phone_no'},
                    //{ data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                select: true,
                dom: 'Bfrtip',
                buttons: {
                    dom: {
                        container:{
                            className: 'dt-buttons bt-container'
                        },
                        button: {
                            className: 'btn btn-primary btn-icon m-1',
                        }
                    },buttons: [
                        {
                            text: '<i class="fas fa-plus"></i> &nbsp New',
                            action: function ( e, dt, node, config ) {
                                $.ajax({
                                    url: "{{ route('contact.create') }}",
                                    type: 'GET',
                                    success: function(result) {
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                    }
                                });
                            }
                        },
                        {
                            text: '<i class="fas fa-pen"></i> &nbsp Edit',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                $.ajax({
                                    url: "contact/"+row_data.id+"/edit",
                                    type: 'GET',
                                    success: function(result) {
                                       console.log(result);
                                       $("#crudForm .modal-content").html(result);
                                       $('#crudForm').modal('show');
                                       
                                    }
                                });
                            },
                            enabled: false
                        },
                        {
                            text: '<i class="fas fa-trash-alt"></i> &nbsp Delete',
                            action: function ( e, dt, node, config ) {
                                var row_data = dt.row( { selected: true } ).data();
                                confirmDelete("contact/"+row_data.id, dt);
                            },
                            enabled:false
                        }
                    ]
                }
            });

            table.on( 'select deselect', function () {
                var selectedRows = table.rows( { selected: true } ).count();
                table.button( 1 ).enable( selectedRows === 1 );
                table.button( 2 ).enable( selectedRows === 1 );
            });


            function confirmDelete(url, dt){
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    closeOnEsc: true,
                    closeOnClickOutside: true,
                    className: '',
                    buttons: {
                        cancel: {
                            text: "Cancel",
                            value: 'cancel',
                            visible: true,
                            className: "btn btn-info",
                            closeModal: true,
                        },
                        catch: {
                            text: "Delete",
                            value: "ok",
                            className: "btn btn-danger",
                        },
                    }
                }).then(function (value) {
                    switch(value){
                        case "ok":
                            $.ajax({
                                url: url,
                                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                                type: 'DELETE',
                                success: function(result) {
                                    if(result == 'success'){
                                        console.log(result);
                                        dt.row( { selected: true } ).remove().draw( false );
                                        toastr.success("Deleted successfully");
                                    }else{
                                        toastr.error("Failed to delete");
                                    }
                                },
                                error: function(response){
                                    console.log(response.responseJSON);
                                    toastr.error(response.responseJSON);
                                }
                            });
                        default:
                            return true;
                    }
                    
                }, function (dismiss) {
                });
            }

        </script>
    </body>
</html>
