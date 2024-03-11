@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Dashboard') }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="text-right">
                <button type="button" class="btn btn-success">Add Particular</button>
            </div>
            <div class="col-lg-12 d-flex m-1">
                <table id="projectParticularTable" class="table" border="2">
                    <thead>
                        <tr class="bg-navy">
                            <th class="text-center col-12" colspan="3">COE Building </th>
                        </tr>

                        <tr class="bg-gray-dark">
                            <th class="text-center col-12" colspan="3">Embankment</th>
                        </tr>

                        <tr>
                            <td class="bg-olive">Materials</td>
                            <td class="bg-olive">Labor</td>
                            <td class="bg-olive">Equipment</td>
                        </tr>
                        <tr>
                            <td>Washed Sand</td>
                            <td>Foreman</td>
                            <td>Excavators</td>
                        </tr>

                        <tr>
                            <td>Gravel</td>
                            <td>Panday</td>
                            <td>Truck</td>
                        </tr>

                        <tr class="bg-gray-dark">
                            <th class="text-center col-12" colspan="3">Pavements</th>
                        </tr>
                        <tr>
                            <td class="bg-olive">Materials</td>
                            <td class="bg-olive">Labor</td>
                            <td class="bg-olive">Equipment</td>
                        </tr>
                        <tr>
                            {{-- Value of Materials --}}
                            <td>Washed Sand</td>
                            {{-- End of value of Materials --}}


                            {{-- Value of Labor --}}
                            <td>Foreman</td>
                            {{-- End of Value Labor --}}

                            {{-- Value of Equipment --}}
                            <td>Excavators</td>
                            {{-- End of Value Equipemtn --}}
                        </tr>

                        <tr>
                            {{-- Value of Materials --}}
                            <td>Gravel</td>
                            {{-- End of value of Materials --}}


                            {{-- Value of Labor --}}
                            <td>Panday</td>
                            {{-- End of Value Labor --}}

                            {{-- Value of Equipment --}}
                            <td>Truck</td>
                            {{-- End of Value Equipemtn --}}
                        </tr>

                    </thead>
                </table>
            </div>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    {{-- <script>
        $(document).ready(function() {
            // Define sample project data locally for testing
            var projectsData = [{
                    project_title: 'COE Constructions',
                    particular_name: ['Embankment of COE Constructions', 'Compaction of COE Constructions',
                        'Compaction of COE Constructions', 'Compaction of COE Constructions',
                        'Compaction of COE Constructions'
                    ]
                },
                {
                    project_title: 'CISC Constructions',
                    particular_name: ['Earthworks of CISC Constructions', 'Ground Works of CISC Constructions',
                        'Compaction of CISC Constructions'
                    ]
                }
            ];

            var table = $('#projectParticularTable');

            for (var i = 0; i < projectsData.length; i++) {
                var projectHeaderRow = $('<tr class="bg-secondary"><th class="text-center col-12">' +
                    projectsData[i].project_title +
                    '</th><th><button class="btn btn-success bg-gradient-success"><i class="fa fa-plus" aria-hidden="true"></i>Add</button></th></tr>'
                );


                var projects = projectsData[i].particular_name;

                table.append(projectHeaderRow);

                for (var j = 0; j < projects.length; j++) {
                    var projectRow = $('<tr></tr>');
                    projectRow.append('<td><i class="nav-icon fas fa-cogs"></i> ' + projects[j] +
                        '</td>');
                    projectRow.append(
                        '<td><button class="btn btn-danger delete-btn">Delete</button></td>');

                    table.append(projectRow);
                }
            }

            // Delete button click event
            $(document).on('click', '.delete-btn', function() {
                $(this).closest('tr').remove();
            });



        });
    </script> --}}
@endsection
