@include('admins.base')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">    
        <link rel="stylesheet" href="{{asset('plugins/dataTables.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/dataTables.bootstrap4.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    </head>
<body>
    @section('content')
    <div class="container" >
        <div class="add" style="">   
            <form id="add-new" method="POST" enctype="multipart/form-data">
             @csrf         
            <td>Nama</td>
            <td>:</td>
            <td><input class="form-control nama" type="text" name="nama" style="border-radius:24px"></td>                
            <td> Code : </td>
            <td><input type="text" class="form-control code" name="custom_input" style="border-radius:24px"></td>
            <td> Avatar :</td>
            <td>
                <div class="custom-file">        
                   <label for="avatar" class="custom-file-label">Avatar</label>              
                       <input type="file" class="custom-file-input avatar" name="avatar" id="avatar">                                                
                    </div>
             </td>
            <td> Categories : </td>
            <td>
                <select multiple class="form-control select_category" style="border-radius:24px">
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
    
    <!-- <div id="content-wrapper" class="d-flex flex-column"> -->
        <div class="container">
            <table class="table table-items">
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>Price</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </table>
        </div>
    <!-- </div>  -->
       
    @endsection
</body>
<script src="{{asset('plugins\datatables.js')}}"></script>
<!-- <script src="{{asset('pligins\datatables.css')}}"></script> -->
<script src="{{asset('plugins\dataTables.bootstrap4.js')}}"></script>
<!-- <script src="{{asset('pligins\datatables.css')}}"></script> -->
<script src="{{asset('bootstrap/js/bootstrap.js')}}"></script>
<script type="text/javascript">
    $('.table-items').DataTable({
        ajax:{
            url:
        },
        columns:[
            {data:'id'},
            {data:'name'},
            {data:'price'},
            {data:'photo'},
        ],
    });
</script>

</html>