@extends('layout')

@section('content')

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <h1 class="h3 text-gray-800">
        Room Types
    </h1>

    <a href="{{ route('roomtypes.create') }}" class="btn btn-success btn-sm">
        <i class="fas fa-plus"></i> Add Room Type
    </a>

</div>

<!-- DataTable Card -->
<div class="card shadow mb-4">

    <!-- Card Header -->
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            All Room Types
        </h6>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover"
                   id="dataTable"
                   width="100%"
                   cellspacing="0">

                <!-- Table Head -->
                <thead class="thead-light">
                    <tr>
                        <th width="10%">#</th>
                        <th>Title</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <!-- Table Body -->
              <tbody>

    @forelse($roomtypes as $roomtype)

        <tr>

            <td>{{ $roomtype->id }}</td>

            <td>{{ $roomtype->title }}</td>

            <td class="text-center">

                <div class="d-flex justify-content-center">

                    <!-- View -->
                    <a href="{{ route('roomtypes.show', $roomtype->id) }}"
                       class="btn btn-info btn-sm mr-1">

                        <i class="fas fa-eye"></i>

                    </a>

                    <!-- Edit -->
                    <a href="{{ route('roomtypes.edit', $roomtype->id) }}"
                       class="btn btn-primary btn-sm mr-1">

                        <i class="fas fa-edit"></i>

                    </a>

                    <!-- Delete -->
                    <form action="{{ route('roomtypes.destroy', $roomtype->id) }}"
                          method="POST"
                          class="m-0">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">

                            <i class="fas fa-trash"></i>

                        </button>

                    </form>

                </div>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="3" class="text-center">
                No room types found.
            </td>

        </tr>

    @endforelse

</tbody>
            </table>

        </div>

    </div>

</div>

@endsection