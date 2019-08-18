@include('admins.base')
<html>
    <head>
        <title>
            Categories
        </title>
        <link rel="stylesheet" href="{{asset('plugins/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

    </head>
    <body>
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
                    <script src="{{asset('jquery/jquery-3.4.1.min.js')}}"></script>
                    <script type="text/javascript">
                        $('#category-update').on('submit',function(){
                            // console.log('lol');
                            event.preventDefault();
                            $.ajax({
                                url:'{{route('category.edit')}}',
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
                    </script>
                </div>
            </div>
        </div>
        <div class="container">
            <br>
            <div class="add" style="">
                <form id = "add-new" method="POST" enctype="multipart/form-data">
                    @csrf
                    <td>Nama : </td>
                    <td><input type="text" class="form-control" name="name" style="border-radius: 24px"></td>
                    <br>
                    <button type ="submit" class="btn btn-outline-primary" style="border-radius: 24px"> add </button>
                </form>
            </div>
        </div>
        <div class="container">
            <table class="table table-categories">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>name</td>
                        <td>action</td>
                    </tr>
                </thead>

            </table>
        </div>
        <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
        <!-- <script src="{{asset('jquery/jquery-3.4.1.min.js')}}"></script> -->
        <script src="{{asset('plugins/dataTables.js')}}"></script>
        <script src="{{asset('plugins/dataTables.bootstrap4.js')}}"></script>
        <script type="text/javascript">
            var table_categories = $('.table-categories').DataTable({
                ajax:{
                    url:'{{route('categories.list')}}',
                    dataSrc:''
                },
                columns:[
                    {data:'id'},
                    {data:'name'},
                    {data:'action'},
                ],

            });
        </script>
        <script type="text/javascript">
            $('#add-new').on('submit', function(){
                event.preventDefault();
                $.ajax({
                    url:'{{route('category.save')}}',
                    type:'POST',
                    dataType:'JSON',
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    // {nama:$('.nama').val(),custom_input:$('.code').val(),id_category:$('.select_category').val(),avatar:$('.avatar').val(),_token:'{{csrf_token()}}'},
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
        </script>
        <script type="text/javascript">
            var update_name;
            var id;
            $('.table-categories').on( 'click', 'tr', function () {
                console.log('lol');
                update_name=table_categories.row(this).data().name;
                id=table_categories.row(this).data().id;
                $('.update_name').val(update_name);
                $('.tf_id').val(id);

            });

        </script>
        <script type="text/javascript">
        function destroy(){
            var yesDelete=1;
            $('.table-categories').on( 'click', 'tr', function () {
                id=table_categories.row(this).data().id;
                // $('.btn-destroy').on('click',function(){
                    console.log(yesDelete);
                    if(yesDelete==1){
                        $.ajax({
                            url:'{{route('category.delete')}}',
                            type:'DELETE',
                            dataType:'JSON',
                            data:{id:id,_token:'{{csrf_token()}}'},
                            success:function(data){
                                $('.table-categories').DataTable().ajax.reload();
                                setTimeout(2000);
                            },
                            error:function(data){

                            }

                        });
                        yesDelete=0;
                    }
                // });
            });

        }


        </script>

    </body>


</html>
