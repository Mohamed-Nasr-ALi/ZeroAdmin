@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Types</h1>
        </div>
        <div class="d-flex flex-row-reverse bd-highlight">
            <a href="{{route('types.create')}}" class="btn btn-outline-success text-capitalize">Create type</a>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">type name</th>
                <th scope="col">state</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @if (count($types)>0)
                @foreach($types as $index=>$type)
                    <tr class="text-center"  id="{{$type->id}}">
                        <td>{{$types->firstItem() + $index}}</td>
                        <td>{{$type->type_name ?? ''}}</td>
                        <td>{{$type->state === 1 ? 'available' : 'disactive'}}</td>
                        <td><a href="{{route('types.edit',$type->id)}}"
                               class="btn btn-outline-primary text-capitalize">update</a></td>
                        <td><!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal-{{$type->id}}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{$type->id}}" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete ?!
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('types.destroy', $type->id) }}" method="post">
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
                <mark class="d-inline-block mb-1">total entries:- {{$types->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$types->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$types->firstItem()}}</span> to <span>{{$types->lastItem()}}</span> of <span>{{$types->total()}}</span> entries</mark>
        {{ $types->onEachSide(1)->links() }}
    </div>
@endsection

