@include('admins.base')
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- <link rel="stylesheet" href="{{asset('plugins/dataTables.css')}}"> -->
        <link rel="stylesheet" href="{{asset('plugins/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    </head>
    <body>
    <div class="container" >
        <div class="add" style="display: none">
            <form id="add-new" method="POST" enctype="multipart/form-data">
             @csrf
            <td>Nama</td>
            <td>:</td>
            <td><input class="form-control nama" type="text" name="name" style="border-radius:24px"></td>
            <td>Price</td>
            <td>:</td>
            <td><input class="form-control nama" type="text" name="price" style="border-radius:24px"></td>
            <td>Weight (kg)</td>
            <td>:</td>
            <td><input class="form-control nama" type="text" name="weight" style="border-radius:24px"></td>
            <td>Stock</td>
            <td>:</td>
            <td><input class="form-control nama" type="text" name="stock" style="border-radius:24px"></td>
            <td> Photo :</td>
            <td>
                <div class="custom-file">
                   <label for="Photo" class="custom-file-label">photo</label>
                       <input type="file" class="custom-file-input photo" name="photo" id="photo">
                    </div>
             </td>
            <td> Categories : </td>
            <td>
                <select multiple class="form-control select_category" style="border-radius:24px" name="update-categories">
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
                </select>
           </td>
           <br>
            <button type="submit" class="btn btn-outline-primary btn-save" style="border-radius:24px">Add</button>
            </form>
            <br>
            <br>
        </div>
    </div>
    <div class="container">
    <div class="card-body">
            <button class="btn btn-outline-primary btn-show" style="display:block">Add More</button>
            <button class="btn btn-outline-primary btn-hide" style="display:none">Hide</button>
            <br>
            <table class="table table-items">
                <thead>
                    <tr>
                        <td>id</td>
                        <td>name</td>
                        <td>price</td>
                        <td>weight</td>
                        <td>stock</td>
                        <td>photo</td>
                        <td>Categories</td>
                        <td>Action</td>
                    </tr>
                </thead>
            </table>
        </div>
        <script>
                $('.btn-show').on('click',function(){
                    // alert('lol');
                    $('.add').css('display','block');
                    $('.btn-show').css('display','none');
                    $('.btn-hide').css('display','block');
                })
                $('.btn-hide').on('click',function(){
                    // alert('lol');
                    $('.add').css('display','none');
                    $('.btn-show').css('display','block');
                    $('.btn-hide').css('display','none');
                })

        </script>

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
                        <form id="item-update" method="POST" enctype="multipart/form-data">
                         @csrf
                        <input type="text" hidden readonly class="tf_id" name="id">
                        <td>Nama</td>
                        <td>:</td>
                        <td><input type="text" class=" form-control update_name" name="update_name"></td>
                        <td>Price :</td>
                        <td><input type="text" class=" form-control update_price" name="update_price"></td>
                        <td>Weight(kg) :</td>
                        <td><input type="text" class=" form-control update_weight" name="update_weight"></td>
                        <td>Stock :</td>
                        <td><input type="text" class=" form-control update_stock" name="update_stock"></td>
                        <td>Photo :</td>
                        <td>
                            <div class="custom-file">
                                    <label for="update_photo" class="custom-file-label">Photo</label>
                                    <input type="file" class="custom-file-input" name="update_photo" id="update_photo">

                            </div>
                        </td>
                        <td> Categories : </td>
                        <td>
                            <select multiple class="form-control">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>

                        </td>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 24px">Close</button>
                        <button type="submit" class="btn btn-primary btn-update" style="border-radius: 24px" >Save changes</button>
                    </div>
                    </form>
                    <script src="{{asset('jquery/jquery-3.4.1.min.js')}}"></script>
                    <script type="text/javascript">
                        // var new_name;
                        $('.table-items').on( 'click', 'tr', function () {
                            var update_name=table_items.row(this).data().name;
                            var update_price=table_items.row(this).data().price;
                            var id=table_items.row(this).data().id;
                            var update_weight = table_items.row(this).data().weight;
                            var update_stock = table_items.row(this).data().stock;
                            $('.update_price').val(update_price);
                            $('.update_name').val(update_name);
                            $('.tf_id').val(id);
                            $('.update_weight').val(update_weight);
                            $('.update_stock').val(update_stock);
                            $('.tf_id').val(id);
                            console.log(table_items.row(this).data());
                            $('.update_categories').each(function(){
                                // if()
                            });
                        });


                        // alert(new_name);
                        // console.log(new_name);

                    </script>
                    <script type="text/javascript">
                        $('#item-update').on('submit',function(){
                            // console.log('lol');
                            event.preventDefault();
                            $.ajax({
                                url:'{{route('items.edit')}}',
                                type:'POST',
                                dataType:'JSON',
                                data:new FormData(this),
                                contentType:false,
                                cache:false,
                                processData:false,
                                // {id:$('.tf_id').val(),nama:$('.item_name').val(),custom_input:$('.new_code').val(),id_category:$('.select_category').val(),_token:'{{csrf_token()}}'},
                                success:function(data){
                                    // $('.notif').html('<div class="alert alert-success"><dt>'+data.message+'</dt></div></div>');
                                    $('.table-items').DataTable().ajax.reload();
                                    alert('sukses');
                                    // setTimeout(2000);
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
    </body>
    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('plugins/dataTables.js')}}"></script>
    <script src="{{asset('plugins/dataTables.bootstrap4.js')}}"></script>
    <script>
        var table_items = $('.table-items').DataTable({
            ajax:{
                url:'{{route('items.list')}}',
                dataSrc:''
            },
            columns:[
                {data:'id'},
                {data:'name'},
                {data:'price'},
                {data:'weight'},
                {data:'stock'},
                {data:'photo'},
                {data:'categories'},
                {data:'action'},
            ],
            columnDefs:[
                // {
                //     target: 4,
                //     render:function(data){
                //         var lol = "lol";
                //         return lol;
                //     },
                // },
                {
                    targets: 5,
                    render:function(data){
                        storage = '{{asset('storage/')}}'+'/';
                        return '<img class = "rounded-circle "width="150" height="150" src="'+storage+''+data+'">';
                    }
                },

            ],
        });
    </script>
    <script type="text/javascript">
        $('#add-new').on('submit',function(){
            event.preventDefault();
            $.ajax({
                url:'{{route('items.save')}}',
                type:'POST',
                dataType:'JSON',
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success:function(data){
                    $('.table-items').DataTable().ajax.reload();
                    setTimeout(2000);
                },
                error:function(data){
                    alert('error menyimpan data');
                }

            });
        });
    </script>
    <script>
        $('.table-items').on( 'click', 'tr', function () {
                    // console.log(table_items.row(this).data());
                    id = table_items.row(this).data().id;
                    $('.btn-destroy').on('click',function(){
                        $.ajax({
                            url:'{{route('items.delete')}}',
                            type:'DELETE',
                            dataType:'JSON',
                            data:{id:id,_token:'{{csrf_token()}}'},
                            success:function(data){
                                // $('.notif').html('<div class="alert alert-success"><dt>'+data.message+'</dt></div></div>');
                                $('.table-items').DataTable().ajax.reload();
                                // setTimeout(2000);
                            },
                            error:function(data){
                                // $('.notif').html('<div class="alert alert-danger"><dt>'+data.message+'</dt></div></div>');
                                alert(data.message );
                            }
                        });
                    });
        });
    </script>
</body>
