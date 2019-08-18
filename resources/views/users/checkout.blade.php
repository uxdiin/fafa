@include('users.base')
<br>
<br>
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
<div class="container">
    <br>
    <br>
    <br>
        <div class="row">
            <div class="col-sm">
                <select class="form-control province" id="province">
                    <option class="province-option" value="">Province</option>
                </select>
                <br>
                <select class="form-control   city" id="city">
                        <option class="province-option" value="">City</option>
                </select>
            </div>
            <div class="col-sm">
                <select class="form-control  expedition">
                        <option class="province-option" value="">expedition</option>
                        <option class="province-option" value="jne">jne</option>
                </select>
                <br>
                <select class="form-control  service" id="service">
                        <option class="province-option"  value="">service</option>
                        <!-- <option class="province-option" value="jne">jne</option> -->
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <br>
                shipping cost<input class="form-control col-sm cost" readonly id="cost">
            </div>
            <div class="col-sm">
                <br>
                Total Balance<input class="form-control col-sm total-cost" readonly id="total-cost">
            </div>
        </div>
        <br>
        <div  class="row">
            <div class="col-sm">
                <button class="btn btn-outline-primary make-order">Make Order</button>
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
                            <button class="btn btn-outline-primary round">Check Out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</div>
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
    $(document).ready(function(){
        $.ajax({
        url:'{{route('users.shippings.province-list')}}',
        type:'GET',
        dataType:'JSON',
        success:function(data){
            data.forEach(province);
            function province(province,index){
                $('.province').append('<option class="province-option" value="'+data[index].province_id+'">'+data[index].province+'</option>');
            }
        }
        });
        $('.masthead').css('display','none');
        $('.fixed-top').css('background-color','black');
    });
</script>
<script>
    $('.province').change(function(){
        $('.city').html('<option class="province-option" value="">City</option>');
        $.ajax({
            url:'{{route('users.shippings.city-list')}}',
            type:'POST',
            dataType:'JSON',
            data:{province_id:document.getElementById("province").value,_token:'{{csrf_token()}}'},
            success:function(data){
                data.forEach(city);

            function city(province,index){
                $('.city').append('<option class="province-option" value="'+data[index].city_id+'">'+data[index].city_name+'</option>');
            }
            }
        });
    });
</script>
<script>
        $('.expedition').change(function(){
            $('.service').html('<option class="city-option" value="">Service</option>');
            $.ajax({
                url:'{{route('user.shippings.price')}}',
                type:'POST',
                dataType:'JSON',
                data:{city_id:document.getElementById("city").value,_token:'{{csrf_token()}}'},
                success:function(data){
                    var i,j;
                    for (i in data[0].costs) {
                        for (j in data[0].costs[i].cost) {
                            console.log(data[0].costs[i].cost[j]);
                            $('.service').append('<option class="province-option" value="'+data[0].costs[i].cost[0].value+'">'+data[0].costs[i].service+'</option>');

                        }
                    }


                }
            });
        });
</script>
<script>
    $('.make-order').on('click',function(){
        $.ajax({
            url:'{{route('user.checkout.make-order')}}',
            type:'POST',
            dataType:'JSON',
            data:{city_id:document.getElementById("city").value,service_id:$('.service').prop('selectedIndex'),_token:'{{csrf_token()}}'},
            success:function(data){
                    alert('order Making success');
            }
        });
    });
</script>
<script>
    $('.service').change(function(){
        var cost = document.getElementById("service").value
        $('.cost').val(cost);
    });
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

<script>
    $('document').ready(function(){
        // totalCost();
    });
</script>
