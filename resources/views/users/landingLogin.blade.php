@include('users.base')
<html>
    <head>
        <style>
            .round-bottom{
                border-bottom-left-radius:24px;
                border-bottom-right-radius: 24px;
            }
            .round-up{
                border-top-left-radius:24px;
                border-top-right-radius: 24px;
            }
            .round{
                border-radius: 24px;
            }
        </style>
        <link rel="stylesheet" href="{{asset('plugins/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

    </head>
    <body>
        <section class="bg-light page-section" id="portfolio">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                          <h2 class="section-heading text-uppercase">Product List</h2>
                          <h3 class="section-subheading text-muted"></h3>
                    </div>
                </div>
                <div class="row">
                    <?php $index=0?>
                    @foreach ($items as $item)
                        <div class="col-md-4 col-sm-6 portfolio-item" onclick="fillModal({{$index}})">
                            <a class="portfolio-link " data-toggle="modal" href="#portfolioModal1">
                                <div class="portfolio-hover round-up ">
                                    <div class="portfolio-hover-content ">
                                        <i class="fas fa-plus fa-3x"></i>
                                    </div>
                                </div>
                                <input type="text" name="itemId" hidden value={{$item->id}}>
                                <img name="photo" class="img-fluid round-up" src="{{asset('/storage/'.$item['photo'])}}" alt="">
                            </a>
                            <div class="portfolio-caption round-bottom ">
                                <h4 name="name">{{$item->name}}</h4>
                            <p class="text-muted" name="price">Rp {{$item->price}}</p>
                              </div>
                            </div>
                        <?php $index++?>
                      @endforeach
                </div>
            </div>
        </section>
            <div class="modal fade bd-example-modal-xl" id="portfolioModal1" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="close-modal" data-dismiss="modal">
                            <div class="lr">
                               <div class="rl"></div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="modal-body">
                                        <!-- Project Details Go Here -->
                                        <input type="text" hidden class="modal-item-id">
                                        <h2 class="text-uppercase modalName">Project Name</h2>
                                        <img class="img-fluid d-block mx-auto round modalPhoto" src="" alt="">
                                        <p class="modalPrice"></p>
                                        <button class="btn btn-outline-primary round addBasket" type="button" onclick="addToBasket()">
                                                Add to Troly</button>
                                        <button class="btn btn-outline-primary round" data-dismiss="modal" type="button">
                                            <i class="fas fa-times"></i>
                                            Close </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade bd-example-modal-lg" id="modalBasket" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="container">
                            <div class="modal-header"><h4>Your Troly</h4></div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <table class="table table-basket">
                                        <thead>
                                            <tr>
                                                <td hidden>id</td>
                                                <td>Name</td>
                                                <td></td>
                                                <td>Price</td>
                                                <td hidden>user id</td>
                                                <td hidden>item_id</td>
                                                <td>Total</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="number" readonly class="form-control col-md-4 total-balance">
                                <a href="users/checkout" class="btn btn-outline-primary round">Check Out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </body>
    <script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
    <script src="{{asset('plugins/dataTables.js')}}"></script>
    <script src="{{asset('plugins/dataTables.bootstrap4.js')}}"></script>
    <script>
        var table_basket = $('.table-basket').DataTable({
            ajax:{
                url:'{{route('basket.item-list')}}',
                dataSrc:''
            },
            columns:[
                {data:'id'},
                {data:'name'},
                {data:'photo'},
                {data:'price'},
                {data:'user_id'},
                {data:'item_id'},
                {data:'action'},
            ],
            "searching":false,
            "paging":false,
            "ordering":false,
            "info":false,
            columnDefs:[
                {
                    targets:0,
                    "visible":false,
                },
                {
                    targets:3,
                    "name":"price",
                },
                {
                    targets:4,
                    "visible":false,
                },
                {
                    targets:5,
                    "visible":false,
                },
                {
                    targets:2,
                    render:function(data){
                        storage = '{{asset('storage/')}}'+'/';
                        return '<img class = "rounded-circle "width="150" height="150" src="'+storage+''+data+'">';
                    }
                },
            ]
        });
    </script>
    <script>
        function fillModal(index){
            var name=document.getElementsByName("name")[index].innerText;
            var photo=document.getElementsByName("photo")[index].src;
            var price=document.getElementsByName("price")[index].innerText;
            var itemId=document.getElementsByName("itemId")[index].value;
            $('.modalName').text(name);
            $('.modalPhoto').attr('src',photo);
            $('.modalPrice').text(price);
            $('.modal-item-id').val(itemId);
            console.log(name);
            console.log(photo);
        }
    </script>
    <script>
        function addToBasket(){
            $.ajax({
                url:'{{route('basket.edit')}}',
                type:'POST',
                dataType:'JSON',
                data:{item_id:$('.modal-item-id').val(),_token:'{{csrf_token()}}'},
                success:function(data){
                    console.log('sukses menambah keranjang');
                    $('.table-basket').DataTable().ajax.reload();
                    setTimeout(check);
                },
                error:function(data){

                }

            });
        }
    </script>
    <script>
        function addTotal(index){
            var total = document.getElementsByName("total")[index].value;
            total++;
            var yesAdd =1;
            document.getElementsByName("total")[index].value=total;
            $('.table-basket').on('click','tr',function(){
                var item_id = table_basket.row(this).data().item_id;
                // console.log(item_id);
                if(yesAdd==1){
                    $.ajax({
                        url:'{{route('basket.addTotal')}}',
                        type:'POST',
                        dataType:'JSON',
                        data:{item_id:item_id,_token:'{{csrf_token()}}'},
                        success:function(data){
                                console.log('succes add total');
                                setTimeout(totalBalance);
                        },
                        error:function(data){

                        }
                    });
                    yesAdd=0;
                }
            });
        }
    </script>
    <script>
            function decTotal(index){
                var total = document.getElementsByName("total")[index].value;
                total--;
                var yesDec=1;
                document.getElementsByName("total")[index].value=total;
                $('.table-basket').on('click','tr',function(){
                   var item_id = table_basket.row(this).data().item_id;
                    if(yesDec==1){
                        $.ajax({
                            url:'{{route('basket.decTotal')}}',
                            type:'POST',
                            dataType:'JSON',
                            data:{item_id:item_id,_token:'{{csrf_token()}}'},
                            success:function(data){
                                console.log('succes dec total');
                                setTimeout(totalBalance);
                            },
                            error:function(data){

                            }
                        });
                        yesDec=0;
                    }
                });

            }
        </script>
        <script>
            function totalBalance(){
                var totalPrice=0;
                for(index=0;index<table_basket.rows().count();index++){
                    totalPrice = totalPrice + table_basket.row(index).data().price*document.getElementsByName("total")[index].value;
                    // console.log(table_basket.row(0).data().price);
                }
                $('.total-balance').val(totalPrice);
                console.log(totalPrice);
            }
        </script>

</html>
