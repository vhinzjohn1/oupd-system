@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

    <head>

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

            <div id="example1" class="list-group col">
                <div class="list-group-item">Item 1</div>
                <div class="list-group-item">Item 2</div>
                <div class="list-group-item">Item 3</div>
                <div class="list-group-item">Item 4</div>
                <div class="list-group-item">Item 6</div>
                <div class="list-group-item">Item 5</div>
            </div>

            {{-- <div id="example1">
                <div class="card">Item 1</div>
                <div class="card">Item 2</div>
                <div class="">Item 3</div>
                <div class="">Item 4</div>
                <div class="">Item 6</div>
                <div class="">Item 5</div>
            </div> --}}
            <div class="btn btn-danger" onclick="confirmDeletion()">Delete</div>
        </div> <!-- ./ Project Card  --->
        <!-- Your Blade view with JavaScript -->

        <button type="button" class="btn btn-secondary" id="popoverButton" data-toggle="popover" title="Popover Title">
            Open Popover
        </button>
        <input class="currency-input form-control" type="text" id="numberInput">
        <input class="currency-input form-control" type="text" id="price" name="price" placeholder="price">
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currencyInputs = document.querySelectorAll('.currency-input');
            currencyInputs.forEach(input => {
                new AutoNumeric(input, {
                    digitGroupSeparator: ',',
                    decimalCharacter: '.',
                    currencySymbol: '₱',
                    currencySymbolPlacement: 'p'
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Load the order of list items from local storage
            loadOrder();
            // Initialize SortableJS
            const sortable = new Sortable(document.getElementById('example1'), {
                group: 'shared', // set both lists to the same group
                animation: 150,
                onEnd: function(evt) {
                    saveOrder();
                }
            });

            // Function to update Roman numerals
            function updateRomanNumerals() {
                const listItems = document.querySelectorAll('#example1 .list-group-item');
                listItems.forEach((item, index) => {
                    const romanNumeral = intToRoman(index +
                        1); // Adding 1 to index to match 1-based indexing
                    // Remove existing Roman numeral before adding a new one
                    item.textContent = item.textContent.replace(/^\w+\.\s/, '');
                    // Prepend the Roman numeral directly to the beginning of each item's text content
                    item.textContent = romanNumeral + '. ' + item.textContent;
                });
            }

            // Function to save the order of list items in local storage
            function saveOrder() {
                const listItems = document.querySelectorAll('#example1 .list-group-item');
                const order = Array.from(listItems).map(item => item.textContent);
                localStorage.setItem('sortableOrder', JSON.stringify(order));
            }

            // Function to load the order of list items from local storage
            function loadOrder() {
                const order = JSON.parse(localStorage.getItem('sortableOrder'));
                if (order) {
                    const listItems = document.querySelectorAll('#example1 .list-group-item');
                    listItems.forEach((item, index) => {
                        item.textContent = order[index];
                    });
                }
            }

            // Initialize Roman numerals
            function intToRoman(num) {
                const romanNumerals = [{
                        value: 100,
                        numeral: "C"
                    },
                    {
                        value: 50,
                        numeral: "L"
                    }, {
                        value: 10,
                        numeral: "X"
                    },
                    {
                        value: 9,
                        numeral: "IX"
                    },
                    {
                        value: 5,
                        numeral: "V"
                    },
                    {
                        value: 4,
                        numeral: "IV"
                    },
                    {
                        value: 1,
                        numeral: "I"
                    }
                ];
                let result = '';
                romanNumerals.forEach(({
                    value,
                    numeral
                }) => {
                    while (num >= value) {
                        result += numeral;
                        num -= value;
                    }
                });
                return result;
            }

            // Call updateRomanNumerals() initially
            updateRomanNumerals();



            // Listen for SortableJS events
            sortable.option("onEnd", function(evt) {
                saveOrder();
                updateRomanNumerals();
            });
        });
    </script>


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






    <!-- /.content -->
@endsection