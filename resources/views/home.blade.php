@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>

        <script src="{{ asset('js/ag-grid.js') }}"></script>

    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            {{-- <div id="example1" class="list-group col">
                <div class="list-group-item" draggable="false" style="">Item 1</div>
                <div class="list-group-item" draggable="false" style="">Item 2</div>
                <div class="list-group-item" style="">Item 3</div>
                <div class="list-group-item" style="">Item 4</div>
                <div class="list-group-item" draggable="false" style="">Item 6</div>
                <div class="list-group-item" style="">Item 5</div>
            </div>
            <div id="example2" class="list-group col">
                <div class="list-group-item" draggable="false" style="">Item 1</div>
                <div class="list-group-item" style="">Item 2</div>
                <div class="list-group-item" style="">Item 3</div>
                <div class="list-group-item" style="">Item 4</div>
                <div class="list-group-item" style="">Item 5</div>
                <div class="list-group-item" style="">Item 6</div>
            </div> --}}

            <div class="btn btn-danger" onclick="confirmDeletion()">Delete</div>
        </div> <!-- ./ Project Card  --->
        <!-- Your Blade view with JavaScript -->
    </div>

    <script>
        // Function to confirm deletion
        function confirmDeletion(id) {
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms again, trigger delete action
                    confirmFinalDeletion(id);
                }
            });
        }

        // Function to confirm deletion again
        function confirmFinalDeletion(id) {
            // Show SweetAlert final confirmation dialog
            Swal.fire({
                title: 'Are you really sure?',
                text: "This action is irreversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms again, proceed with deletion
                    deleteMaterial(id);
                }
            });
        }

        // Function to delete material
        function deleteMaterial(id) {
            axios.delete(`/materials/${id}`)
                .then(response => {
                    // Handle success response
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Material has been deleted.',
                        icon: 'success'
                    });
                })
                .catch(error => {
                    // Handle error response
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete material.',
                        icon: 'error'
                    });
                });
        }
    </script>


    <script>
        new Sortable(example1, {
            animation: 150,
            ghostClass: 'blue-background-class',
            dragClass: 'bg-blue-50',
        });

        new Sortable(example2, {
            group: 'shared', // set both lists to same group
            animation: 150,
        });
    </script>



    <!-- /.content -->
@endsection
