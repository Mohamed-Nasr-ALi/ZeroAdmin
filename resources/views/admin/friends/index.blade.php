@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Friends</h1>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">full name</th>
                <th scope="col">phone</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @if (count($friends)>0)
                @foreach($friends as $index=>$friend)
                    <tr class="text-center"  id="{{$friend->id}}">
                        <td>{{$friends->firstItem() + $index}}</td>
                        <td>{{$friend->full_name ?? ''}}</td>
                        <td>{{$friend->phone_number ?? ''}}</td>
                        <td><a href="{{route('friends.edit',$friend->id)}}"
                               class="btn btn-outline-primary text-capitalize">update</a></td>
                        <td><!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal-{{$friend->id}}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{$friend->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete ?!
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('friends.destroy', $friend->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger delete">Delete</button>
                                            </form><!-- end of form -->
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                <mark class="d-inline-block mb-1">total entries:- {{$friends->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$friends->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$friends->firstItem()}}</span> to <span>{{$friends->lastItem()}}</span> of <span>{{$friends->total()}}</span> entries</mark>
        {{ $friends->onEachSide(1)->links() }}
    </div>
@endsection

