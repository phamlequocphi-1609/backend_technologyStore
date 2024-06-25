@extends('admin.Layouts.app')
@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-5 align-self-center">
            <h4 class="page-title">Country</h4>
        </div>
        <div class="col-7 align-self-center">
            <div class="d-flex align-items-center justify-content-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Country</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    <h4><i class="icon fa fa-check"></i>Thông báo !</h4>
                                    {{session('success')}}
                                </div>
                            @endif
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                    @php
                                        $image = json_decode($blog['image'], true);
                                    @endphp
                                <tr>
                                    <th scope="row">{{$blog['id']}}</th>
                                    <td>{{$blog['title']}}</td>
                                    <td>
                                        @if(isset($image))
                                            @foreach($image as $img)
                                                <img src="{{asset('upload/blog/'.$img)}}" style="width: 100px" class="mb-5">
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{$blog['description']}}</td>
                                    <td>{{$blog['content']}}</td>
                                    <td>
                                        <a href="{{route('blogEdit', ['id'=> $blog['id']])}}" class="btn btn-success mb-3 w-100">Edit</a>
                                        <a href="{{route('blogDelete', ['id'=> $blog['id']])}}" class="btn btn-success w-100">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            <a href="{{url('/admin/blog/add')}}" class="btn btn-success">Add Blog</a>
                    </div>
                    <h6 class="card-title"><i class="m-r-5 font-18 mdi mdi-numeric-2-box-multiple-outline"></i> Table Without Outside Padding</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection