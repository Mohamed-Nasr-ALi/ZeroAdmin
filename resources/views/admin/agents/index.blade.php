@extends('layouts.app')
@include('layouts.aside')
@section('content')
    <div class="container animated fadeInUp">
        <div class="header">
            <h1>Agents</h1>
        </div>
        <div class="d-flex flex-row-reverse bd-highlight">
            <a href="{{route('agents.create')}}" class="btn btn-outline-success text-capitalize">Create agent</a>
        </div>
        <table class="table table-hover">
            <thead class="text-center">
            <tr class="text-capitalize">
                <th scope="col">#</th>
                <th scope="col">full name</th>
                <th scope="col">phone</th>
                <th scope="col">type name</th>
                <th scope="col">business name</th>
                <th scope="col">business type</th>
                <th scope="col">total cashback</th>
                <th scope="col">business logo</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
            </thead>
            <tbody>
            @if (count($agents)>0)
                @foreach($agents as $index=>$agent)
                    <tr class="text-center" id="{{$agent->id}}">
                        <td>{{$agents->firstItem() + $index}}</td>
                        <td>{{$agent->user->full_name ?? ''}}</td>
                        <td>{{$agent->user->phone ?? ''}}</td>
                        <td>{{$agent->type->type_name ?? ''}}</td>
                        <td>{{$agent->business_name ?? ''}}</td>
                        <td>
                            @if ($agent->business_type === 1)
                                <span class="badge badge-success">POS</span>
                            @elseif($agent->business_type === -1)
                                <span class="badge badge-primary">PUR</span>
                            @else
                                <span class="badge badge-success">POS</span>
                                <span class="badge badge-primary">PUR</span>
                            @endif
                        </td>
                        <td>{{$agent->cashback()->first()->total_cashback ?? '0.00'}}</td>
                        <td><img style="height: 100px;" class="img-thumbnail image-preview" alt="..."
                                 src="{{ (isset($agent->business_logo) && ($agent->business_logo !== "")) ? asset("$agent->business_logo")  :  asset('defaults/agent_business_logo.png') }}">
                        </td>
                        <td><a href="{{route('agents.edit',$agent->id)}}"
                               class="btn btn-outline-primary text-capitalize">update</a></td>
                        <td><!-- Button trigger modal -->
                            <button da type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal-{{$agent->id}}">
                                Delete
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal-{{$agent->id}}" tabindex="-1" role="dialog"
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
                                            <form action="{{ route('agents.destroy', $agent->id) }}" method="post">
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
                <mark class="d-inline-block mb-1">total entries:- {{$agents->total()}}</mark>
                <mark class="d-inline-block mb-1">current page Num:- {{$agents->currentPage()}}</mark>
            @endif
            </tbody>
        </table>
        <mark class="d-inline-block mb-1">showing <span>{{$agents->firstItem()}}</span> to
            <span>{{$agents->lastItem()}}</span> of <span>{{$agents->total()}}</span> entries
        </mark>
        {{ $agents->onEachSide(1)->links() }}
    </div>
@endsection

