@include('admins.base');
<html>
    <head>
        <title>Transactions</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- <link rel="stylesheet" href="{{asset('plugins/dataTables.css')}}"> -->
        <link rel="stylesheet" href="{{asset('plugins/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    </head>
    <body>
        <div class="container">
            <table class="table table-transactions">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>user_id</td>
                        <td>username</td>
                        <td>total balance</td>
                        <td>action</td>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="Edit" id="exampleModalLabel">Item Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="category-update" method="POST" enctype="multipart/form-data">
                             @csrf
                            <input type="text" hidden readonly class="tf_id" name="id">
                            <td>Nama</td>
                            <td>:</td>
                            <td><input type="text" class=" form-control update_name" name="update_name"></td>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 24px">Close</button>
                            <button type="submit" class="btn btn-primary btn-update" style="border-radius: 24px" >Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
        </div>
        <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
        <!-- <script src="{{asset('jquery/jquery-3.4.1.min.js')}}"></script> -->
        <script src="{{asset('plugins/dataTables.js')}}"></script>
        <script src="{{asset('plugins/dataTables.bootstrap4.js')}}"></script>
        <!-- <script src="{{asset('jquery/jquery-3.4.1.min.js')}}"></script> -->
        <!-- <script type="text/javascript">
            $('#category-update').on('submit',function(){
                // console.log('lol');
                 event.preventDefault();
                $.ajax({
                    url:'{{route('transaction.edit')}}',
                    type:'POST',
                    dataType:'JSON',
                    data:new FormData(this),
                    contentType:false,
                    cache:false,
                    processData:false,
                    // {id:$('.tf_id').val(),nama:$('.item_name').val(),custom_input:$('.new_code').val(),id_category:$('.select_category').val(),_token:'{{csrf_token()}}'},
                    success:function(data){
                        $('.table-categories').DataTable().ajax.reload();
                        setTimeout(2000);
                    },
                    error:function(data){
                        // $('.notif').html('<div class="alert alert-danger"><dt>'+data.message+'</dt></div></div>');
                        // alert('lol');
                    }
                });
            });
        </script> -->
        <script>
            $('.table-transactions').DataTable({
                ajax:{
                    url:'{{route('transactions.list')}}',
                    dataSrc:'',
                },
                columns:[
                    {data:'id'},
                    {data:'user_id'},
                    {data:'username'},
                    {data:'total_balance'},
                    {data:'action'},
                ]


            });
        </script>
        <script>
            $('.table-transactions').on('click','tr',function(){

            });
        </script>

    </body>
</html>
