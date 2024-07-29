@extends('layouts.app')
@section('title', 'Transaction')
@section('content')

    <head>
        <style>
            .table-cell-ellipsis {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 2;
                /* Number of lines to show */
                overflow: hidden;
                text-overflow: ellipsis;
                height: 3em;
                /* Adjust based on line-height */
                line-height: 1.5em;
                /* Adjust based on font size */
                white-space: normal;
                /* Allow text to wrap */
                word-wrap: break-word;
                /* Break long words */
            }
        </style>
    </head>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h1 class="">{{ __('Projects') }}</h1>
                    <div>
                        <input type="hidden" id="projectSelectedID">
                        <h1 id="projectSelectedTitle"> {{ $projectDetail->project_title }} </h1>
                    </div>

                    <div></div>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <div class="content">

        <!------ Floating Button ----->
        <ul id="menu" class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
            <li class="mfb-component__wrap">
                <a href="#" class="mfb-component__button--main">
                    <i class="mfb-component__main-icon--resting ion-plus-round"></i>
                    <i class="mfb-component__main-icon--active ion-close-round"></i>
                </a>
                <ul class="mfb-component__list">
                    <li>
                        <a data-mfb-label="Add Project Item" class="mfb-component__button--child" id="addProjectItemModal">
                            <i class="mfb-component__child-icon fa fa-list"></i>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="https://github.com/nobitagit" data-mfb-label="Follow me on Github"
                            class="mfb-component__button--child">
                            <i class="mfb-component__child-icon ion-social-octocat"></i>
                        </a>
                    </li>

                    <li>
                        <a href="http://twitter.com/share?text=Check this material floating button component!&url=http://nobitagit.github.io/material-floating-button/&hashtags=material,design,button,css"
                            data-mfb-label="Share on Twitter" class="mfb-component__button--child">
                            <i class="mfb-component__child-icon ion-social-twitter"></i>
                        </a>
                    </li> --}}
                </ul>
            </li>
        </ul><!------- End of Floating Button ------>


        <div class="container-fluid">
            <!----- Project Card Section ---->
            <div class="card" id="addNewProject">
                <div class="card-header header-hover" data-toggle="collapse" data-target="#addProject" aria-expanded="false"
                    aria-controls="addProject">
                    <div class="d-flex justify-content-between col-12">
                        <h5 id="ProjectHeader">Project Details</h5>
                        <div class="card-tools">
                            <!-- Collapse Button -->
                            <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#addProject"
                                aria-expanded="false" aria-controls="addProject"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                {{-- Project Card Start --}}
                <div class="collapse" id="addProject">
                    <form id="projectDetailsForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="row col-12">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="hidden" id="add_project_id">
                                            <label for="add_project_title">Project Title</label>
                                            <input type="text" class="form-control" id="add_project_title"
                                                value="{{ $projectDetail->project_title }}" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_location">Location</label>
                                            <input value="{{ $projectDetail->project_location }}" type="text"
                                                class="form-control" id="add_project_location" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_owner">Owner</label>
                                            <input value="{{ $projectDetail->project_owner }}" type="text"
                                                class="form-control" id="add_project_owner" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_description">Project Description</label>
                                            <input value="{{ $projectDetail->project_description }}" type="text"
                                                class="form-control" id="add_project_description" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_contract_duration">Contract Duration</label>
                                            <input value="{{ $projectDetail->project_contract_duration }}" type="text"
                                                class="form-control" id="add_project_contract_duration"
                                                name="add_project_contract_duration" required>
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_appropriation">Project Cost</label>
                                            <input value="{{ $projectDetail->project_appropriation }}" type="text"
                                                class="form-control price-input" id="add_project_appropriation"
                                                name="add_project_appropriation" required>
                                        </div>

                                        <div class="form-group margin-top">
                                            <label for="add_project_category">Project Category</label>
                                            <input value="{{ $projectDetail->project_category }}" type="text"
                                                class="form-control" id="add_project_category" name="add_project_category"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <div class="form-group margin-top">
                                            <label for="add_project_source_of_fund">Project Source Of Fund</label>
                                            <select class="form-control" id="add_project_source_of_fund"
                                                name="add_project_source_of_fund" required>
                                                <option value=""
                                                    {{ $projectDetail->project_source_of_fund == '' ? 'selected' : '' }}>
                                                </option>
                                                <option value="General Fund"
                                                    {{ $projectDetail->project_source_of_fund == 'General Fund' ? 'selected' : '' }}>
                                                    General Fund</option>
                                                <option value="Trust Fund"
                                                    {{ $projectDetail->project_source_of_fund == 'Trust Fund' ? 'selected' : '' }}>
                                                    Trust Fund</option>
                                                <option value="Special Trust Fund"
                                                    {{ $projectDetail->project_source_of_fund == 'Special Trust Fund' ? 'selected' : '' }}>
                                                    Special Trust Fund</option>
                                                <option value="RGMO"
                                                    {{ $projectDetail->project_source_of_fund == 'RGMO' ? 'selected' : '' }}>
                                                    RGMO</option>
                                            </select>

                                        </div>
                                        <div class="form-group margin-top mt-2">
                                            <label for="add_project_date_prepared">Project Date Prepared</label>
                                            <input value="{{ $projectDetail->project_date_prepared }}" type="date"
                                                class="form-control" id="add_project_date_prepared"
                                                name="add_project_date_prepared">
                                        </div>
                                        <div class="form-group margin-top">
                                            <label for="add_project_mode_of_implementation">Project Mode Of
                                                Implementation</label>
                                            <select class="form-control" id="add_project_mode_of_implementation"
                                                name="add_project_mode_of_implementation" required>
                                                <option value=""
                                                    {{ $projectDetail->project_mode_of_implementation == '' ? 'selected' : '' }}>
                                                </option>
                                                <option value="By Admin"
                                                    {{ $projectDetail->project_mode_of_implementation == 'By Admin' ? 'selected' : '' }}>
                                                    By Admin</option>
                                                <option value="By Contract"
                                                    {{ $projectDetail->project_mode_of_implementation == 'By Contract' ? 'selected' : '' }}>
                                                    By Contract</option>
                                            </select>
                                        </div>
                                        <div class="card">
                                            <div class="row p-3 d-flex justify-content-center">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="add_project_ocm">OCM</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                id="add_project_ocm" value="{{ $projectDetail->ocm }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="add_project_contractProfit">Contract Profit</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                id="add_project_contractProfit"
                                                                value="{{ $projectDetail->contractors_profit }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- VAT  --}}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="add_project_vat">VAT</label>
                                                        <div class="input-group">
                                                            <input type="number" class="form-control"
                                                                id="add_project_vat" value="{{ $projectDetail->vat }}">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer col-12">
                                            <button type="submit" class="btn btn-success col-12">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> <!-- ./ Project Card  --->

            <!---- Signatures Section ---->
            <div class="card" id="addNewSignature">
                <div class="card-header header-hover" data-toggle="collapse" data-target="#addSignature"
                    aria-expanded="false" aria-controls="addSignature">
                    <div class="d-flex justify-content-between col-12">
                        <h5 id="ProjectHeader">Signature Detail</h5>
                        <div class="card-tools">
                            <!-- Collapse Button -->
                            <button type="button" class="btn btn-tool" data-toggle="collapse"
                                data-target="#addSignature" aria-expanded="false" aria-controls="addSignature"><i
                                    class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                {{-- Project Card Start --}}
                <div class="collapse" id="addSignature">
                    <div class="row p-3">
                        <div class="col-lg-12">
                            <div class="text-right mb-3">
                                <div class="btn btn-success" id="addSignatureBtn"><i class="fa fa-plus"></i></div>
                            </div>
                            <table class="table col-12 table-margin" id="signatureTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Title</th>
                                        <th>Role</th>
                                        <th>Position</th>
                                        {{-- <th>Modified By</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- ./ Signatures Card  --->


            <!----- Third Column for Required ----->
            <div class="d-flex col-12">
                <!------ Technical Personnel Required ------>
                <div class="col-6">
                    <div class="card" id="addTechnicalPersonnel">
                        <div class="card-header header-hover col-12" data-toggle="collapse"
                            data-target="#addTechnicalPCard" aria-expanded="false">
                            <div class="d-flex justify-content-between col-12">
                                <h5 id="ProjectHeader">Technical Personnel</h5>
                                <div class="card-tools">
                                    <!-- Collapse Button -->
                                    <button type="button" class="btn btn-tool" data-toggle="collapse"
                                        aria-expanded="false"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        {{-- Project Card Start --}}
                        <div class="collapse" id="addTechnicalPCard">
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-success" id="addtechnicalPersonnelBtn"
                                            onclick=""><i class="fa fa-plus"></i></button>
                                    </div>
                                    <table class="table table-margin" id="technicalPersonnelTable" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tech_personnels as $tech_personnel)
                                                <tr>
                                                    <td>{{ $tech_personnel->personnel_no }}</td>
                                                    <td>{{ $tech_personnel->personnel_description }}</td>
                                                    <td class="text-center d-flex">
                                                        <button type="button" class="btn bg-success mr-2"
                                                            data-id="{{ $tech_personnel->personnel_no }}"
                                                            onclick="editTechnicalPersonnel({{ $tech_personnel->personnel_no }}, '{{ $tech_personnel->personnel_description }}')">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn bg-danger"
                                                            data-id="{{ $tech_personnel->personnel_no }}"
                                                            onclick="deleteTechnicalPersonnel({{ $tech_personnel->personnel_no }})">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ./ Technical Personnel Required Card  --->
                </div>

                <!------ Minimum Equipment Requirement ------>
                <div class="col-6">
                    <div class="card" id="addMinEquipReq">
                        <div class="card-header header-hover col-12" data-toggle="collapse"
                            data-target="#addMinEquipReqCard" aria-expanded="false">
                            <div class="d-flex justify-content-between col-12">
                                <h5 id="ProjectHeader">Minimum Equipment</h5>

                                <div class="card-tools">
                                    <!-- Collapse Button -->
                                    <button type="button" class="btn btn-tool" data-toggle="collapse"
                                        aria-expanded="false"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        {{-- Project Card Start --}}
                        <div class="collapse" id="addMinEquipReqCard">
                            <div class="row p-3">
                                <div class="col-lg-12">
                                    <div class="text-right mb-3">
                                        <button type="button" class="btn btn-success" id="addMinimumEquipmentBtn"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    <table class="table col-12 table-margin" id="addMinEquipReqTable">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Owned</th>
                                                <th>Lease</th>
                                                <th>Total # of Unit</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($minimum_equipments as $equipment)
                                                <td>{{ $equipment->min_equip_description }}</td>
                                                <td>{{ $equipment->min_equip_owned }}</td>
                                                <td>{{ $equipment->min_equip_lease }}
                                                </td>
                                                <td>{{ $equipment->min_equip_totalUnits }}</td>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- ./ Minimum Equipment Requirement Card  --->
                </div>
            </div>

            {{-- Project Item --}}
            <div class="container-fluid mt-3" id="dynamicContent">
                <div class="d-flex justify-content-between mb-2">
                    <h4>Project Item</h4>
                    <div class="col-2">
                        <select class="form-control" id="selectProjParticular">
                        </select>
                    </div>

                    {{-- <div class="btn btn-success"></div> --}}
                </div>
            </div>


            <div id="data_wrapper" class="col-12 d-flex flex-column p-4 margin-top">
                @foreach ($particulars as $particular)
                    <div class="card" id="mainCardProjectParticular">
                        <!------ Header of Each Card ------>
                        <div class="card-header header-hover padding-header collapsed"
                            style="border-left: 7px solid green;" data-toggle="collapse"
                            data-target="#projectPart{{ $particular['particular_id'] }}" aria-expanded="false">

                            <div class="d-flex justify-content-between">
                                <h5 class="numeralPartName" id="{{ $particular['particular_id'] }}">
                                    <span>{{ $particular['particular_name'] }}{{ empty($particular['pay_item']) ? '' : ' - ' . $particular['pay_item'] }}</span>
                                </h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-danger" id="deleteProjectItem"
                                        onclick="deleteProjectItem({{ $particular->project_particular_id }}, '{{ $particular->particular_name }}')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!------- Card Body Section ----->
                        <div class="collapse" id="projectPart{{ $particular['particular_id'] }}">
                            <div class="card-body">
                                <!---- Row Section --->
                                <div class="row">
                                    <div class="pd-zero pd-3 card"
                                        id="projectPartDetail_{{ $particular['particular_id'] }}">
                                        <div class="card-body form-top">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-4 d-flex gap-1">
                                                        <h6>Quantity: </h6>
                                                        <input class="form-control-sm form-control" type="number"
                                                            id="quantity_{{ $particular['particular_id'] }}">
                                                    </div>
                                                    <div class="col-3 d-flex gap-1">
                                                        <h6>Unit: </h6>
                                                        <input class="form-control-sm form-control" type="text"
                                                            id="unit_{{ $particular['particular_id'] }}">
                                                    </div>
                                                    <div class="col-4">
                                                        <h6>
                                                            Total Amount:
                                                            <span
                                                                id="total_{{ $particular['project_particular_id'] }}"></span>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!------ Material, Labor, Equipment Card Section ----->
                                    <div class="col-12">
                                        <!------ Materila Card ---->
                                        <div class="card card-refresh"
                                            id="materialCard_{{ $particular['particular_id'] }}">
                                            <!----- Material Card Header ---->
                                            <div class="card-header d-flex justify-content-between col-12 header-hover padding-header"
                                                data-toggle="collapse"
                                                data-target="#materialCardBody_{{ $particular['particular_id'] }}"
                                                onclick="toggleTotal('Material', {{ $particular['particular_id'] }})">

                                                <div class="d-flex justify-content-between col-12">
                                                    <h5 class="col-8">Material</h5>
                                                    <div class="d-flex justify-content-between col-4">
                                                        <div style="font-weight: 500; opacity: 0;"
                                                            id="materialCardTotal_{{ $particular['particular_id'] }}">
                                                            <div>Total Material Amount: <span
                                                                    id="materialCardAmount_{{ $particular['project_particular_id'] }}"></span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="btn btn-success btn-header"
                                                                onclick="addDetailBtn({{ $particular['particular_id'] }}, 'Material' , {{ $particular['project_particular_id'] }})"
                                                                id="addMaterialBtn">
                                                                <i class="fa fa-plus"></i>
                                                            </div>
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse"><i class="fas fa-toggle-on"
                                                                    id="iconToggle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!----- Material Card Body ----->
                                            <div class="collapse show"
                                                id="materialCardBody_{{ $particular['particular_id'] }}">
                                                <div class="card-body">
                                                    <table id="materialTable_{{ $particular['particular_id'] }}"
                                                        class="table table-bordered" style="width: 100%;">
                                                        <thead>
                                                            <th>Material Name</th>
                                                            <th>Category Name</th>
                                                            <th>Unit</th>
                                                            <th>Quarter</th>
                                                            <th>Year</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                            <th>Amount</th>
                                                            <th>Actions</th>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($particular['materials'] as $material)
                                                                <tr>
                                                                    <td>{{ $material['material_name'] }}</td>
                                                                    <td>{{ $material['material_category_name'] }}</td>
                                                                    <td>{{ $material['unit'] }}</td>
                                                                    <td>{{ $material['quarter'] }}</td>
                                                                    <td>{{ $material['year'] }}</td>
                                                                    <td>{{ number_format($material['quantity'], 2) }}</td>
                                                                    <td class="text-right">
                                                                        ₱{{ number_format($material['price'], 2) }}</td>
                                                                    <td class="text-right">
                                                                        ₱{{ number_format($material['quantity'] * $material['price'], 2) }}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-success edit-material"
                                                                            data-particularID="{{ $particular['particular_id'] }}"
                                                                            data-id="{{ $material['project_particular_material_id'] }}"
                                                                            data-name="{{ $material['material_name'] }}"
                                                                            data-categoryName="{{ $material['material_category_name'] }}"
                                                                            data-unit="{{ $material['unit'] }}"
                                                                            data-quarter="{{ $material['quarter'] }}"
                                                                            data-year="{{ $material['year'] }}"
                                                                            data-quantity="{{ number_format($material['quantity'], 2) }}"
                                                                            data-price=" ₱{{ number_format($material['price'], 2) }}"
                                                                            data-amount="₱{{ number_format($material['quantity'] * $material['price'], 2) }}"
                                                                            data-projectParticularid="{{ $particular['project_particular_id'] }}">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                        <button class="btn btn-danger"
                                                                            onclick="deleteDetail('material', {{ $material['project_particular_material_id'] }}, {{ $particular['particular_id'] }})"><i
                                                                                class="fa fa-trash-alt"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="7" style="text-align:right">Total:</th>
                                                                <th class="text-right"
                                                                    id="totalMaterialAmount_{{ $particular['project_particular_id'] }}">
                                                                    Loading..
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!----- Labor Card Section ---->
                                        <div class="card card-refresh" id="laborCard_{{ $particular['particular_id'] }}">
                                            <!----- Labor Card Header ---->
                                            <div class="card-header d-flex justify-content-between col-12 header-hover padding-header"
                                                data-toggle="collapse"
                                                data-target="#laborCardBody_{{ $particular['particular_id'] }}"
                                                onclick="toggleTotal('Labor', {{ $particular['particular_id'] }})">

                                                <div class="d-flex justify-content-between col-12">
                                                    <h5 class="col-8">Labor</h5>
                                                    <div class="d-flex justify-content-between col-4">
                                                        <div style="font-weight: 500; opacity: 0;"
                                                            id="laborCardTotal_{{ $particular['particular_id'] }}">
                                                            <div>Total Labor Amount: <span
                                                                    id="laborCardAmount_{{ $particular['project_particular_id'] }}"></span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="btn btn-success btn-header"
                                                                id="addDeta{{ $particular['particular_id'] }}"
                                                                onclick="addDetailBtn({{ $particular['particular_id'] }}, 'Labor' , {{ $particular['project_particular_id'] }})">
                                                                <i class="fa fa-plus"></i>
                                                            </div><button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse"><i class="fas fa-toggle-on"
                                                                    id="iconToggle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!----- Labor Card Body ----->
                                            <div class="collapse show"
                                                id="laborCardBody_{{ $particular['particular_id'] }}">
                                                <div class="card-body">
                                                    <table id="laborTable_{{ $particular['particular_id'] }}"
                                                        class="table table-bordered" style="width: 100%;">
                                                        <thead>
                                                            <th>Labor Name</th>
                                                            <th>No of Person</th>
                                                            <th>Work Days</th>
                                                            <th>Labor Rate</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($particular['labors'] as $labor)
                                                                <tr>
                                                                    <td>{{ $labor['labor_name'] }}</td>
                                                                    <td>{{ $labor['no_of_persons'] }}</td>
                                                                    <td>{{ $labor['work_days'] }}</td>
                                                                    <td class="text-right">
                                                                        ₱{{ number_format($labor['rate'], 2) }}</td>
                                                                    <td class="text-right">
                                                                        ₱{{ number_format($labor['no_of_persons'] * $labor['rate'] * $labor['work_days'], 2) }}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-success"
                                                                            onclick="editLabor(
                                                                                {{ $labor['project_particular_labor_id'] }},
                                                                                '{{ addslashes($labor['labor_name']) }}',
                                                                                {{ $labor['no_of_persons'] }},
                                                                                {{ $labor['work_days'] }},
                                                                                {{ $labor['rate'] }},
                                                                                {{ $particular['particular_id'] }}
                                                                            )">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>

                                                                        <button class="btn btn-danger"
                                                                            onclick="deleteDetail('labor', {{ $labor['project_particular_labor_id'] }}, {{ $particular['particular_id'] }})"><i
                                                                                class="fa fa-trash-alt"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="4" style="text-align:right">Total:</th>
                                                                <th class="text-right"
                                                                    id="totalLaborAmount_{{ $particular['project_particular_id'] }}">
                                                                    Loading..
                                                                </th>
                                                                <th class="text-left"
                                                                    id="laborPercent_{{ $particular['project_particular_id'] }}">
                                                                    Loading</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!----- Equipment Card ---->
                                        <div class="card card-refresh"
                                            id="equipmentCard_{{ $particular['particular_id'] }}">
                                            <!----- Equipment Card Header ---->
                                            <div class="card-header d-flex justify-content-between col-12 header-hover padding-header"
                                                data-toggle="collapse"
                                                data-target="#equipmentCardBody_{{ $particular['particular_id'] }}"
                                                onclick="toggleTotal('Equipment', {{ $particular['particular_id'] }})">

                                                <div class="d-flex justify-content-between col-12">
                                                    <h5 class="col-8">Equipment</h5>
                                                    <div class="d-flex justify-content-between col-4">
                                                        <div style="font-weight: 500; opacity: 0;"
                                                            id="equipmentCardTotal_{{ $particular['particular_id'] }}">
                                                            <div>Total Equipment Amount: <span
                                                                    id="equipmentCardAmount_{{ $particular['project_particular_id'] }}"></span>
                                                            </div>
                                                        </div>
                                                        <div class="">
                                                            <div class="btn btn-success btn-header"
                                                                id="equipmentDetail_{{ $particular['particular_id'] }}"
                                                                onclick="addDetailBtn({{ $particular['particular_id'] }}, 'Equipment' , {{ $particular['project_particular_id'] }})">
                                                                <i class="fa fa-plus"></i>
                                                            </div><button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse"><i class="fas fa-toggle-on"
                                                                    id="iconToggle"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!----- Equipment Card Body ----->
                                            <div class="collapse show"
                                                id="equipmentCardBody_{{ $particular['particular_id'] }}">
                                                <div class="card-body">
                                                    <table id="equipmentTable_{{ $particular['particular_id'] }}"
                                                        class="table table-bordered" style="width: 100%;">
                                                        <thead>
                                                            <th>Equipment Name</th>
                                                            <th>Category Name</th>
                                                            <th>No of Units</th>
                                                            <th>Work Days</th>
                                                            <th>Equipment Rate</th>
                                                            <th>Amount</th>
                                                            <th>Action</th>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($particular['equipments'] as $equipment)
                                                                <tr>
                                                                    <td>{{ $equipment['equipment_name'] }}</td>
                                                                    <td>{{ $equipment['equipment_category_name'] }}</td>
                                                                    <td>{{ $equipment['no_of_units'] }}</td>
                                                                    <td>{{ $equipment['work_days'] }}</td>
                                                                    <td class="text-right">
                                                                        ₱{{ number_format($equipment['rate'], 2) }}</td>
                                                                    <td class="text-right">
                                                                        ₱{{ number_format($equipment['no_of_units'] * $equipment['rate'] * $equipment['work_days'], 2) }}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-success"
                                                                            onclick="editEquipment(
                                                                                {{ $equipment['project_particular_equipment_id'] }},
                                                                                '{{ $equipment['equipment_category_name'] }}',
                                                                                '{{ addslashes($equipment['equipment_name']) }}',
                                                                                {{ $equipment['no_of_units'] }},
                                                                                {{ $equipment['work_days'] }},
                                                                                {{ $equipment['rate'] }},
                                                                                {{ $particular['particular_id'] }},
                                                                                '{{ $equipment['equipment_model'] }}',
                                                                                {{ $equipment['equipment_capacity'] }},
                                                                            )">
                                                                            <i class="fa fa-edit"></i>
                                                                        </button>
                                                                        <button class="btn btn-danger"
                                                                            onclick="deleteDetail('equipment', {{ $equipment['project_particular_equipment_id'] }}, {{ $particular['particular_id'] }})"><i
                                                                                class="fa fa-trash-alt"></i></button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>

                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="5" style="text-align:right">Total:</th>
                                                                <th class="text-right"
                                                                    id="totalEquipmentAmount_{{ $particular['project_particular_id'] }}">
                                                                    Loading..
                                                                </th>
                                                            </tr>
                                                        </tfoot>

                                                    </table>
                                                    {{-- <div class="card totalFooter">
                                                        <div class="card-body col-11">
                                                            <div class="text-right" style="margin-top: -10px;">
                                                                <span class="total-text">Total Labor Amount: </span>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!----- End of Row ----->

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="loader text-center" style="display: none; font-weight: bold; font-size: 20px;">
            <div class="d-flex justify-content-center">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

    </div>


    <script>
        $("#selectProjParticular")
            .select2({
                theme: "bootstrap-5",
                placeholder: "Add Project Item",
                dropdownPosition: 'below'
            });


        refreshParticularTable();
        // Adding of Project Item Section
        function refreshParticularTable() {
            $.ajax({
                url: "{{ route('getParticulars') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {

                    console.log('Particular Array: ', data);
                    if (Array.isArray(data) && data.length > 0) {
                        var selectedProjID = localStorage.getItem("projectID");
                        var selectElem = $("#selectProjParticular").empty();

                        // Filter data for the selected project ID
                        var selectedProject = data.find(function(project) {
                            return project.project_id == selectedProjID;
                        });

                        // If selected project is found
                        if (selectedProject && selectedProject.particulars_available) {
                            // Add a blank option
                            selectElem.append('<option value=""></option>');

                            selectedProject.particulars_available.forEach(function(particular) {
                                let optionText = particular.particular_name;
                                if (particular.pay_item) {
                                    optionText += ' - ' + particular.pay_item;
                                }
                                selectElem.append('<option value="' + particular.particular_id + '">' +
                                    optionText + '</option>');
                            });
                        } else {
                            console.error(
                                "Selected project or particulars available data not found or invalid.");
                        }
                    } else {
                        console.error("No data or invalid data received.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }

        // Event handler for select2 select event
        $('#selectProjParticular').on('select2:select', function(e) {
            var selectedParticularId = e.params.data.id;
            var selectedProjID = localStorage.getItem("projectID");

            // Prepare data for AJAX request
            var requestData = {
                project_id: selectedProjID, // Assuming selectedProjectID is defined
                particular_id: selectedParticularId,
                _token: "{{ csrf_token() }}",
            };

            // Send AJAX request to store the project particular
            $.ajax({
                url: "{{ route('projectParticulars.store') }}",
                type: "POST",
                dataType: "json",
                data: requestData,
                success: function(response) {
                    // Reload the current page
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error("Error storing project particular:", xhr.responseText);
                }
            });
        }); // --- End Of Project Item Section


        let totalMaterial = 231250;
        let rate = 910;
        let percent = 35 / 100;
        let targetAmount = percent * totalMaterial;

        function findBestCombination(targetAmount, rate, maxPersons, maxDays) {
            let bestCombination = {
                noOfPerson: 0,
                workDays: 0,
                amount: 0
            };
            let minDifference = Infinity;

            for (let noOfPerson = 1; noOfPerson <= maxPersons; noOfPerson++) {
                let workDays = Math.ceil(targetAmount / (noOfPerson * rate));
                if (workDays <= maxDays) {
                    let amount = noOfPerson * rate * workDays;
                    let difference = Math.abs(amount - targetAmount);
                    if (difference < minDifference) {
                        minDifference = difference;
                        bestCombination = {
                            noOfPerson,
                            workDays,
                            amount
                        };
                        if (difference === 0) return bestCombination; // Stop if exact match is found
                    }
                }
            }
            return bestCombination;
        }

        let maxPersons = 50;
        let maxDays = 50;

        let result = findBestCombination(targetAmount, rate, maxPersons, maxDays);
        console.log(`Best combination: ${result.noOfPerson} person(s) for ${result.workDays} work day(s)`);
        console.log(`Amount: ${result.amount.toFixed(2)}`);
    </script>

    <script>
        UniqueParticularID = 0;
        // For Data table script
        const particulars = {!! json_encode($particulars) !!};
        console.log(particulars);

        const projectDetail = {!! json_encode($projectDetail) !!};

        // Extracting particular_id from each object in the data array
        const particularIds = particulars.data.map(particular => particular.particular_id);
        // Loop through each particular_id and apply the action
        particularIds.forEach(particularId => {
            $('#materialTable_' + particularId).DataTable({
                // Your other DataTables options here
                columnDefs: [{
                    targets: [0], // Column index to target (change this as needed)
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('table-cell-ellipsis').attr('title', cellData);
                    }
                }]
            });
            $('#laborTable_' + particularId).DataTable();
            $('#equipmentTable_' + particularId).DataTable();
        });
        //.. End of Data table script

        refreshSignature();


        // Start of Lazy Loading Project Item Script
        var ENDPOINT = "{{ route('transactions.index') }}";
        var page = 1;
        var isLoading = false;

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 20) && !isLoading) {
                page++;
                LoadMore(page);
                isLoading = true;
            }
        });

        function LoadMore(page) {
            isLoading = true;
            $.ajax({
                url: ENDPOINT +
                    "?page=" + page,
                datatype: 'html',
                type: 'get',
                beforeSend: function() {
                    $('.loader').show();
                }
            }).done(function(response) {
                // Assuming the response is wrapped in a container with ID 'data_wrapper'
                var responseData = $(response).find('#data_wrapper').html();

                if (responseData.trim() == '') {
                    $('.loader').html("End");
                    return;
                }

                $('.loader').hide();
                $('#data_wrapper').append(responseData);
                isLoading = false;
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                console.log('Server Error Occured');
            });

        } // End of Lazy Loading Project Item Script




        // Functionalities of the Project Items
        function toggleTotal(detailType, particular_id) {
            detailType = detailType.toLowerCase();
            var $element = $(`#${detailType}CardTotal_${particular_id}`);
            if ($element.css('opacity') === '1') {
                $element.css({
                    'opacity': '0',
                    'transition': 'opacity 0.4s ease-out'
                });
            } else {
                $element.css({
                    'opacity': '1',
                    'transition': 'opacity 0.4s ease-in'
                });
            }
        }


        // Refresh the ProjectItem
        function refreshProjectItem(projPartIdInt) {
            let projPartId = parseInt(projPartIdInt);
            // Ajax to get the Get the Data of ProjectItem
            $.ajax({
                url: "{{ route('transactions.create') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Filter the data where particular_id is equal to 8
                    const filteredData = data.filter(item => item.particular_id === projPartId);

                    // Extract materials array from each object in filteredData
                    const materialsArrays = filteredData.map(item => item.materials);
                    // Extract Labor array from each object in filteredData
                    const laborsArrays = filteredData.map(item => item.labors);
                    // Extract Equipemnt array from each object in filteredData
                    const equipmentsArrays = filteredData.map(item => item.equipments);

                    // Populate the Datatables
                    const materialTable = $('#materialTable_' + projPartId).DataTable();
                    const laborTable = $('#laborTable_' + projPartId).DataTable();
                    const equipmentTable = $('#equipmentTable_' + projPartId).DataTable();
                    const existingMaterialRow = materialTable.rows().remove().draw(false);
                    const existingLaborRow = laborTable.rows().remove().draw(false);
                    const existingEquipmentRow = equipmentTable.rows().remove().draw(false);

                    const currencyFormatter = new Intl.NumberFormat('en-PH', {
                        style: 'currency',
                        currency: 'PHP',
                        minimumFractionDigits: 2,
                    });

                    // Extract particular_id from filteredData
                    const particularId = filteredData[0].particular_id;

                    // Loop through newData and append rows to the table
                    materialsArrays.forEach(function(materialArray) { // Loop through the outer array
                        materialArray.forEach(function(material) {
                            const materialQuantity = parseFloat(material.quantity).toFixed(2);
                            const price = currencyFormatter.format(material.price);
                            const amount = currencyFormatter.format(material.quantity * material
                                .price);

                            console.log(particularId);

                            const newRow = materialTable.row.add([
                                material.material_name,
                                material.material_category_name,
                                material.unit,
                                material.quarter,
                                material.year,
                                materialQuantity,
                                '<div class="text-right">' + price + '</div>',
                                '<div class="text-right">' + amount + '</div>',
                                '<div class="text-center d-flex">' +
                                `<button type="button" class="btn bg-success mr-2 edit-material" onclick="editMaterial(${material.project_particular_material_id}, '${material.material_name}', '${material.material_category_name}', '${material.unit}', '${material.quarter}', '${material.year}', '${materialQuantity}', '${price}', '${amount}' , ${projPartId})"><i class="fas fa-edit"></i></button>` +
                                `<button type="button" class="btn btn-danger" onclick="deleteDetail('material', ${material.project_particular_material_id}, ${particularId})"><i class="fa fa-trash-alt"></i></button>` +
                                '</div>'
                            ]).draw(false).node();

                        });

                    });
                    materialTable.draw();


                    console.log('This is the Labors Array: ', laborsArrays);

                    // Refresh Labor Row
                    laborsArrays.forEach(function(laborArray) { // Loop through the outer array
                        laborArray.forEach(function(labor) {
                            const noOfPerson = parseFloat(labor.no_of_persons).toFixed(2);
                            const rate = currencyFormatter.format(labor.rate);
                            const workDays = currencyFormatter.format(labor.work_days);
                            const amount = currencyFormatter.format(labor.rate * labor
                                .work_days * labor.no_of_persons);

                            const newRow = laborTable.row.add([
                                labor.labor_name,
                                labor.no_of_persons,
                                labor.work_days,
                                '<div class="text-right">' + rate + '</div>',
                                '<div class="text-right">' + amount + '</div>',
                                '<div class="text-center d-flex">' +
                                `<button type="button" class="btn bg-success mr-2" onclick="editLabor(${labor.project_particular_labor_id}, '${labor.labor_name}', ${labor.no_of_persons}, ${labor.work_days}, ${labor.rate}, ${particularId} )"><i class="fas fa-edit"></i></button>` +
                                `<button type="button" class="btn btn-danger" onclick="deleteDetail('labor', ${labor.project_particular_labor_id}, ${particularId})"><i class="fa fa-trash-alt"></i></button>` +
                                '</div>'
                            ]).draw(false).node();

                        });

                    });
                    laborTable.draw();

                    // Refresh Equipment Row
                    equipmentsArrays.forEach(function(equipmentArray) { // Loop through the outer array
                        equipmentArray.forEach(function(equipment) {
                            const rate = currencyFormatter.format(equipment.rate);
                            const amount = currencyFormatter.format(equipment.rate * equipment
                                .work_days * equipment.no_of_units);

                            const newRow = equipmentTable.row.add([
                                equipment.equipment_name,
                                equipment.equipment_category_name,
                                equipment.no_of_units,
                                equipment.work_days,
                                '<div class="text-right">' + rate + '</div>',
                                '<div class="text-right">' + amount + '</div>',
                                '<div class="text-center d-flex">' +
                                `<button type="button" class="btn bg-success mr-2" onclick="editEquipment(${equipment.project_particular_equipment_id}, '${equipment.equipment_name}', '${equipment.equipment_category_name}', ${equipment.no_of_units}, ${equipment.work_days}, ${equipment.rate}, ${particularId}, '${equipment.equipment_model}', ${equipment.equipment_capacity} )"><i class="fas fa-edit"></i></button>` +
                                `<button type="button" class="btn btn-danger" onclick="deleteDetail('equipment', ${equipment.project_particular_equipment_id}, ${particularId})"><i class="fa fa-trash-alt"></i></button>` +
                                '</div>'
                            ]).draw(false).node();

                        });

                    });
                    equipmentTable.draw();


                    calculateTotalAmount();

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Delete Project Item
        function deleteProjectItem(projectParticularId, particularName) {
            // Display confirmation dialog
            Swal.fire({
                title: 'Confirm Deletion of Project Item',
                text: "'" + particularName + "'" + " Will Be Deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, proceed with deletion
                    $.ajax({
                        url: "{{ url('projectParticulars') }}/" + projectParticularId,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Refresh the page
                            window.location.reload();

                            // Show toastr notification for successful deletion
                            toastr.success('Project particular deleted successfully.');
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            alert("Error: " + error);
                        }
                    });
                }
            });
        }

        const [year, quarter] = [(new Date()).getFullYear(), ["1st", "2nd", "3rd", "4th"][Math.floor(((new Date())
            .getMonth() % 12) / 3)]];


        // Adding Of Detail Buttons
        function addDetailBtn(projPartId, detailType, particularID) {
            event.stopPropagation();
            if (detailType === "Material") {
                // Populate the Modal Particular Name
                $.ajax({
                    url: "/getAllData/master-list", // URL of the route for masterList function
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        // Extract materials from the Ajax response
                        var materials = response.materials;
                        // Get the select element and empty it
                        var materialSelect = $("#add_particular_material").empty();
                        $('#addProjectPartMaterialForm').trigger('reset');
                        // Add a default option
                        materialSelect.append(
                            $("<option>", {
                                value: "",
                                text: "Select Material",
                            })
                        );
                        // Populate select options with material names using jQuery chaining and map()
                        materialSelect.append(
                            materials.map(function(material) {
                                return $("<option>", {
                                    value: material.material_id,
                                    text: material.material_name,
                                });
                            })
                        );

                        $("#add_particular_material").select2({
                            theme: "bootstrap-5",
                            tags: true,
                            dropdownParent: $("#addParticularMaterial"),
                            placeholder: "Select Material", // Optional placeholder text
                            // allowClear: true, // Allow clearing the selection
                        });

                        // Open Add Particular Material Modal
                        $("#addParticularMaterial").modal("show");
                        UniqueParticularID = projPartId;

                        $("#add_materialProjectPartID").val(particularID);

                        // Add change event listener to the material select element
                        $("#add_particular_material").on("change", function() {
                            // Get the selected material id
                            var selectedMaterialId = $(this).val();

                            // Check if a material is selected and it's in the materials list
                            var selectedMaterial = materials.find(function(material) {
                                return material.material_id == selectedMaterialId;
                            });

                            if (selectedMaterial) {
                                // Populate category, unit, and price fields
                                $("#add_particular_category").val(selectedMaterial
                                    .material_category_name);
                                $("#add_particular_materialID").val(selectedMaterial.material_id);
                                $("#add_particular_materialUnit").val(selectedMaterial.material_unit);
                                $("#add_particular_materialPrice").val(selectedMaterial.material_price);
                                $("#add_particular_materialQuarter").val(selectedMaterial
                                    .material_quarter);
                                $("#add_particular_materialYear").val(selectedMaterial.material_year);
                                $("#add_particular_priceID").val(selectedMaterial.material_price_id);

                                $("#add_projectParticularID").val(particularID);

                                initializePriceInputs();

                                // Change readonly attribute of the form
                                $("#add_particular_category").prop("readonly", true);
                                $("#add_particular_materialUnit").prop("readonly", true);
                                $("#add_particular_materialPrice").prop("readonly", true);
                                $("#add_particular_materialQuarter").prop("readonly", true);
                                $("#add_particular_materialYear").prop("readonly", true);
                            } else {
                                // Reset and enable fields for a new material
                                $("#add_particular_materialID").val("");
                                $("#add_particular_category").prop("readonly", false).val("");
                                $("#add_particular_materialUnit").prop("readonly", false).val("");
                                $("#add_particular_materialPrice").prop("readonly", false).val("");
                                $("#add_particular_materialQuarter").prop("readonly", false).val(
                                    quarter);
                                $("#add_particular_materialYear").prop("readonly", false).val(year);
                            }
                        });

                        initializePriceInputs();
                        initializeQuantityInputs();

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            } else if (detailType === "Labor") {
                $.ajax({
                    url: "/getAllData/master-list", // URL of the route for masterList function
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        console.log(response)
                        var labors = response.labors;

                        // Get the select element and empty it
                        var laborSelect = $("#add_particular_laborName").empty();

                        // Add a default option
                        laborSelect.append(
                            $("<option>", {
                                value: "",
                                text: "Select Labor",
                            })
                        );

                        // Populate select options with labor names using jQuery chaining and map()
                        laborSelect.append(
                            labors.map(function(labor) {
                                return $("<option>", {
                                    value: labor.labor_id,
                                    text: labor.labor_name,
                                });
                            })
                        );

                        $("#add_particular_laborName").select2({
                            tags: true,
                            theme: "bootstrap-5",
                            dropdownParent: $("#addPartLaborModal"),
                            placeholder: "Select Labor Name", // Optional placeholder text
                            // allowClear: true, // Allow clearing the selection
                        });

                        // Open Add Particular Labor Modal
                        $("#addPartLaborModal").modal("show");

                        $("#add_projectParticularLaborId").val(
                            particularID
                        );
                        $("#add_projectParticularIDLabor").val(
                            projPartId
                        );

                        // Add change event listener to the labor select element
                        $("#add_particular_laborName").on("change", function() {
                            var selectedLaborId = $(this).val();

                            // Chech if Values are on the labors list
                            var selectedLabor = labors.find(function(labor) {
                                return labor.labor_id == selectedLaborId;
                            });

                            if (selectedLabor) {
                                // Populate fields with selected labor data
                                $("#add_particular_laborLocation").val(
                                    selectedLabor.labor_location
                                );
                                $("#add_particular_laborID").val(
                                    selectedLabor.labor_id
                                );
                                $("#add_particular_laborRate").val(
                                    selectedLabor.labor_rate
                                );
                                $("#add_particular_laborWorkDays").val(
                                    selectedLabor.labor_workdays
                                );
                                $("#add_particular_labor_rateID").val(
                                    selectedLabor.labor_rate_id
                                );


                                initializePriceInputs();

                                // Chnage readonly attributte of the form
                                $("#add_particular_laborRate").prop("readonly", true);

                            } else {
                                $("#add_particular_laborID").val("");
                                $("#add_particular_laborRate").prop("readonly", false);
                            }
                        });

                        initializePriceInputs();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            } else if (detailType === "Equipment") {
                $.ajax({
                    url: "/getAllData/master-list", // URL of the route for masterList function
                    type: "GET",
                    dataType: "json",
                    success: function(response) {

                        var equipments = response
                            .equipments; // Extract equipment data from the AJAX response

                        // Get the select element and empty it
                        var equipmentSelect = $(
                            "#add_particular_EquipmentName"
                        ).empty();

                        // Add a default option
                        equipmentSelect.append(
                            $("<option>", {
                                value: "",
                                text: "Select Equipment",
                            })
                        );

                        // Populate select options with equipment names using jQuery chaining and map()
                        equipmentSelect.append(
                            equipments.map(function(equipment) {
                                return $("<option>", {
                                    value: equipment.equipment_id,
                                    text: equipment.equipment_name,
                                });
                            })
                        );

                        $("#add_particular_EquipmentName").select2({
                            theme: "bootstrap-5",
                            tags: true,
                            dropdownParent: $("#addPartEquipmentModal"),
                            placeholder: "Select Equipment Name", // Optional placeholder text
                            // allowClear: true, // Allow clearing the selection
                        });

                        // Add change event listener to the labor select element
                        $("#add_particular_EquipmentName").on("change", function() {
                            var selectedEquipmentId = $(this).val();

                            var selectedEquipment = equipments.find(function(
                                equipment
                            ) {
                                return equipment.equipment_id == selectedEquipmentId;
                            });

                            $("#add_projectParticularIdEquipment").val(
                                particularID
                            );
                            $("#add_particularIdEquipment").val(
                                projPartId
                            );


                            if (selectedEquipment) {
                                // Populate fields with selected labor data
                                $("#add_particular_EquipmentRate").val(
                                    selectedEquipment.equipment_rate);
                                $("#add_particular_EquipmentCategory").val(
                                    selectedEquipment.equipment_category_name);
                                $("#add_particular_EquipmentModel").val(
                                    selectedEquipment.equipment_model);
                                $("#add_particular_EquipmentCapacity").val(
                                    selectedEquipment.equipment_capacity);
                                $("#add_particular_EquipmentID").val(
                                    selectedEquipment.equipment_id);
                                $("#add_particular_equipmentRateID").val(
                                    selectedEquipment.equipment_rate_id);

                                initializePriceInputs();
                                // Chnage readonly attributte of the form
                                $("#add_particular_EquipmentRate").prop('readonly', true);
                                $("#add_particular_EquipmentCategory").prop('readonly', true);
                                $("#add_particular_EquipmentModel").prop('readonly', true);
                                $("#add_particular_EquipmentCapacity").prop('readonly', true);

                            } else {
                                $("#add_particular_EquipmentID").val("");
                                // Populate fields with selected labor data
                                $("#add_particular_EquipmentRate").prop('readonly', false);
                                $("#add_particular_EquipmentCategory").prop('readonly', false);
                                $("#add_particular_EquipmentModel").prop('readonly', false);
                                $("#add_particular_EquipmentCapacity").prop('readonly', false);
                            }
                        });

                        initializePriceInputs();

                        // Open Add Particular Equipment Modal
                        $("#addPartEquipmentModal").modal("show");
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            } else {
                // Handle other cases
            }
        }

        function editMaterial(projMaterialId, materialName, materialCategoryName, unit, quarter, year, quantity,
            price,
            amount, particularId) {
            $("#edit_particular_material_id").val(projMaterialId);
            $("#edit_particular_material").val(materialName);
            $("#edit_particular_materialQuantity").val(quantity);
            $("#edit_particular_category").val(materialCategoryName);
            $("#edit_particular_materialUnit").val(unit);
            $("#edit_particular_materialPrice").val(price);
            $("#edit_particular_materialQuarter").val(quarter);
            $("#edit_particular_materialYear").val(year);
            $("#editParticularId").val(particularId);

            // Show Edit Project Particular Material Modal
            $("#editParticularMaterialModal").modal('show');

        }

        function editLabor(projPartLaborID, laborName, noOfPerson, workDays, rate, particularID) {

            $("#edit_particular_laborID").val(projPartLaborID);
            $("#edit_particular_laborName").val(laborName);
            $("#edit_particular_noOfPerson").val(noOfPerson);
            $("#edit_particular_laborWorkDays").val(workDays);
            $("#edit_particular_laborRate").val(rate);
            $("#edit_particular_laborAmount").val(rate * workDays * noOfPerson);
            $("#edit_particularIdLabor").val(particularID);


            IMask($("#edit_particular_laborRate")[0], {
                mask: '₱num',
                blocks: {
                    num: {
                        mask: Number,
                        thousandsSeparator: ',',
                        padFractionalZeros: true,
                        normalizeZeros: true,
                        radix: '.',
                        mapToRadix: ['.'],
                        min: 0,
                        scale: 2
                    }
                }
            });

            // Show Edit Project Particular Material Modal
            $("#editPartLaborModal").modal('show');
        }

        function editEquipment(ProjPartEquipId, EquipmentName, EquipmentCategoryName, NoOfUnits, WorkDays, Rate,
            ParticularId, EquipmentModel, EquipmentCapacity) {
            $("#edit_particular_EquipmentID").val(ProjPartEquipId);
            $("#edit_particular_EquipmentName").val(EquipmentName);
            $("#edit_particular_EquipmentCategory").val(EquipmentCategoryName);
            $("#edit_particular_EquipmentModel").val(EquipmentModel);
            $("#edit_particular_EquipmentCapacity").val(EquipmentCapacity);
            $("#edit_particular_EquipmentRate").val(Rate);
            $("#edit_particular_noOfUnit").val(NoOfUnits);
            $("#edit_particular_EquipmentWorkDays").val(WorkDays);
            $("#edit_particular_EquipmentParticularId").val(ParticularId);

            IMask($("#edit_particular_EquipmentRate")[0], {
                mask: '₱num',
                blocks: {
                    num: {
                        mask: Number,
                        thousandsSeparator: ',',
                        padFractionalZeros: true,
                        normalizeZeros: true,
                        radix: '.',
                        mapToRadix: ['.'],
                        min: 0,
                        scale: 2
                    }
                }
            });

            $("#editPartEquipmentModal").modal('show');
        }
        // Delete Detail
        function deleteDetail(detailType, partID, projectPartId) {
            // Show confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to delete this record!",
                icon: "warning",
                showCancelButton: true,
                cancelButtonColor: "#353535",
                confirmButtonColor: "#FF0000",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with delete operation
                    const data = {
                        _token: "{{ csrf_token() }}",
                        detailType: detailType,
                        partID: partID,
                    };
                    $.ajax({
                        url: "{{ url('delete-datails') }}",
                        type: "DELETE",
                        data: data,
                        success: function(response) {
                            refreshProjectItem(parseInt(projectPartId));
                            // Show success toast with delay
                            toastr.options.progressBar = true;
                            setTimeout(function() {
                                toastr.success("Deleted Successfully!");
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            // Handle error response
                        },
                    });
                }
            });
        }




        // Get Particular Material Values
        document.addEventListener("DOMContentLoaded", function() {

            $('#addProjectItemModal').click(function() {
                $("#addProjPartItemModal").modal("show");
            });

            // Get the Data from the edit material
            document.querySelectorAll('.edit-material').forEach(item => {
                item.addEventListener('click', event => {
                    const materialId = item.dataset.id;
                    const materialName = item.dataset.name;
                    const materialCategoryName = item.dataset.categoryname;
                    const unit = item.dataset.unit;
                    const quarter = item.dataset.quarter;
                    const year = item.dataset.year;
                    const quantity = item.dataset.quantity;
                    const price = item.dataset.price;
                    const amount = item.dataset.amount;
                    const particularId = item.dataset
                        .particularid; // Adjusted to match the naming convention
                    editMaterial(materialId, materialName, materialCategoryName, unit, quarter,
                        year, quantity, price, amount, particularId);
                });
            });

            // Prevent form submission
            $("#addProjectPartMaterialForm").on("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                // Get the selected project ID from localStorage
                var submitProjectID = localStorage.getItem("projectID");
                // Get form data
                let projectId = submitProjectID;
                let particularId = $("#add_materialProjectPartID").val();
                let detail_type = 'Material';
                let materialId = $("#add_particular_materialID").val();
                if (materialId === "") {
                    materialId = "empty";
                }

                let materialName = $("#add_particular_material").val();
                let materialQuantityComma = $(
                    "#add_particular_materialQuantity"
                ).val();

                let materialQuantity = parseFloat(materialQuantityComma.replace('₱', '').replace(/,/g, ''));

                let materialCategory = $(
                    "#add_particular_category"
                ).val();
                let materialUnit = $(
                    "#add_particular_materialUnit"
                ).val();
                let materialQuarter = $(
                    "#add_particular_materialQuarter"
                ).val();
                let materialYear = $(
                    "#add_particular_materialYear"
                ).val();

                let materialPriceID = $(
                    "#add_particular_priceID"
                ).val();
                let commaPrice = $(
                    "#add_particular_materialPrice"
                ).val();

                // Remove the P and commas
                let materialPriceCleaned = commaPrice.replace('₱', '').replace(/,/g,
                    '');
                let materialPrice = parseFloat(materialPriceCleaned);

                let projectParticularID = $(
                    "#add_projectParticularID"
                ).val();

                // Remove materialId from the data object if it's "empty"
                let data = {
                    materialId: materialId,
                    particularId: projectParticularID,
                    projectParticularId: particularId,
                    materialName: materialName,
                    materialCategory: materialCategory,
                    materialUnit: materialUnit,
                    materialPrice: materialPrice,
                    materialQuarter: materialQuarter,
                    materialYear: materialYear,
                    materialQuantity: materialQuantity,
                    materialPriceID: materialPriceID,
                    _token: "{{ csrf_token() }}",
                };
                if (materialId !== "empty") {
                    data.materialId = materialId;
                } else if (materialId === "empty") {
                    data.materialId = "empty"; // or assign any other appropriate value
                }

                // AJAX request
                $.ajax({
                    url: "/submit-details",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function(response) {
                        $("#addProjectPartMaterialForm")[0].reset();
                        $("#addParticularMaterial").modal("hide");

                        toastr.options.progressBar = true;
                        toastr.success("Material Added Successfully!");

                        refreshProjectItem(UniqueParticularID);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response from the server
                        console.error(
                            "Error submitting form data:",
                            xhr.responseText
                        );
                    },
                });
            });

            // Submit the Particular Material Modal Form
            $("#editProjectPartMaterialForm").on("submit", function(event) {
                event.preventDefault();
                let detail_type = 'Material';
                let editProjectMaterialId = $("#edit_particular_material_id").val();
                let materialQuantity = $(
                    "#edit_particular_materialQuantity"
                ).val();
                let particularID = $(
                    "#editParticularId"
                ).val();

                // AJAX request
                $.ajax({
                    url: "/submit-details",
                    type: "POST",
                    dataType: "json",
                    data: {
                        editProjectMaterialId: editProjectMaterialId,
                        materialQuantity: materialQuantity,
                        particularID: particularID,
                        _token: "{{ csrf_token() }}",
                        // Add more form data fields here if needed
                    },
                    success: function(response) {
                        $("#editProjectPartMaterialForm")[0].reset();
                        $("#editParticularMaterialModal").modal("hide");

                        // Refresh The Project Item
                        refreshProjectItem(particularID);

                        toastr.options.progressBar = true;
                        toastr.success("Material Update Successfully!");

                    },
                    error: function(xhr, status, error) {
                        // Handle error response from the server
                        console.error(
                            "Error submitting form data:",
                            xhr.responseText
                        );

                    },
                });
            });

            // Submit the Particular Labor Modal Form
            $("#addProjectPartLaborForm").on("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission behavior

                let submitProjectID = localStorage.getItem("projectID");
                let projectId = submitProjectID;
                let projectParticularID = $("#add_projectParticularLaborId").val();
                let laborId = $("#add_particular_laborID").val();
                let laborRateComma = $('#add_particular_laborRate').val();
                let particularID = $('#add_projectParticularIDLabor').val();

                let laborRate = parseFloat(laborRateComma.replace('₱', '').replace(/,/g, ''));
                let laborName = $("#add_particular_laborName").val();
                let noOfPerson = $("#add_particular_noOfPerson").val();
                let workDays = $("#add_particular_laborWorkDays").val();
                if (laborId === "") {
                    laborId = "empty";
                }

                let laborRateID = $("#add_particular_labor_rateID").val();
                let data = {
                    projectId: projectId,
                    projectParticularID: projectParticularID,
                    particularId: particularID,
                    laborId: laborId,
                    laborRate: laborRate,
                    laborName: laborName,
                    laborLocation: "maramag",
                    noOfPerson: noOfPerson,
                    workDays: workDays,
                    laborRateID: laborRateID,
                    _token: "{{ csrf_token() }}",
                }
                if (laborId !== "empty") {
                    data.laborId = laborId;
                } else if (laborId === "empty") {
                    data.laborId = "empty";
                }

                // AJAX request to submit labor details
                $.ajax({
                    url: "/submit-details",
                    type: "POST",
                    dataType: "json",
                    data: data,
                    success: function(response) {
                        $("#addProjectPartLaborForm")[0].reset();
                        $("#addPartLaborModal").modal("hide");

                        refreshProjectItem(particularID);

                        toastr.options.progressBar = true;
                        toastr.success("Labor Added Successfully!");
                    },
                    error: function(xhr, status, error) {
                        console.error(
                            "Error submitting form data:",
                            xhr.responseText
                        );
                    },
                });
            });

            // Submit the Particular Labor Modal Form
            $("#editProjectPartLaborForm").on("submit", function(event) {
                event.preventDefault();
                // Get form data
                var submitProjectID = localStorage.getItem("projectID");
                let projectId = submitProjectID;
                let detail_type = 'Labor';
                let laborId = $("#edit_particular_laborID").val();
                let noOfPerson = $(
                    "#edit_particular_noOfPerson"
                ).val();
                let workDays = $(
                    "#edit_particular_laborWorkDays"
                ).val();
                let particularID = $(
                    "#edit_particularIdLabor"
                ).val();

                // AJAX request
                $.ajax({
                    url: "/submit-details",
                    type: "POST",
                    dataType: "json",
                    data: {
                        projectId: projectId,
                        editLaborID: laborId,
                        noOfPerson: noOfPerson,
                        workDays: workDays,
                        _token: "{{ csrf_token() }}",
                        // Add more form data fields here if needed
                    },
                    success: function(response) {
                        $("#editProjectPartLaborForm")[0].reset();
                        $("#editPartLaborModal").modal("hide");

                        refreshProjectItem(parseInt(particularID));

                        toastr.options.progressBar = true;
                        toastr.success("Labor Update Successfully!");

                    },
                    error: function(xhr, status, error) {
                        // Handle error response from the server
                        console.error(
                            "Error submitting form data:",
                            xhr.responseText
                        );
                    },
                });
            });


            // Submit the Particular Equipment Modal Form
            $("#addProjectPartEquipmentForm").on(
                "submit",
                function(event) {
                    event.preventDefault(); // Prevent the default form submission behavior

                    var submitProjectID = localStorage.getItem("projectID");

                    let projectId = submitProjectID;

                    let particularID = $('#add_particularIdEquipment').val();

                    let equipmentId = $(
                        "#add_particular_EquipmentID"
                    ).val();
                    if (equipmentId === "") {
                        equipmentId = "empty";
                    }

                    let equipmentName = $(
                        "#add_particular_EquipmentName"
                    ).val();
                    let projectParticularID = $(
                        "#add_projectParticularIdEquipment"
                    ).val();
                    let equipmentRateComma = $("#add_particular_EquipmentRate").val();
                    let equipmentRate = parseFloat(equipmentRateComma.replace('₱', '').replace(/,/g, ''));

                    let equipmentCategory = $("#add_particular_EquipmentCategory").val();
                    let equipmentModel = $("#add_particular_EquipmentModel").val();
                    let equipmentCapacity = $("#add_particular_EquipmentCapacity").val();
                    let noOfUnit = $("#add_particular_noOfUnit").val();
                    let equipmentWorkDays = $(
                        "#add_particular_EquipmentWorkDays"
                    ).val();
                    let equipmentRateID = $("#add_particular_equipmentRateID").val();

                    let data = {
                        projectId: projectId,
                        particularID: particularID,
                        projectParticularID: projectParticularID,
                        equipmentId: equipmentId,
                        equipmentName: equipmentName,
                        equipmentRate: equipmentRate,
                        equipmentCategory: equipmentCategory,
                        equipmentModel: equipmentModel,
                        equipmentCapacity: equipmentCapacity,
                        noOfUnit: noOfUnit,
                        equipmentWorkDays: equipmentWorkDays,
                        equipmentRateID: equipmentRateID,
                        // Add more form data fields here if needed
                        _token: "{{ csrf_token() }}",
                    };
                    if (equipmentId !== "empty") {
                        data.equipmentId = equipmentId;
                    } else if (equipmentId === "empty") {
                        data.equipmentId = "empty";
                    }


                    console.log('This is the Equipment Data: ', data);


                    // AJAX request to submit equipment details
                    $.ajax({
                        url: "/submit-details",
                        type: "POST",
                        dataType: "json",
                        data: data,
                        success: function(response) {
                            $("#addProjectPartEquipmentForm")[0].reset();
                            $("#addPartEquipmentModal").modal("hide");

                            refreshProjectItem(parseInt(particularID));

                            toastr.options.progressBar = true;
                            toastr.success("Equipment Added Successfully!");
                        },
                        error: function(xhr, status, error) {
                            console.error(
                                "Error submitting form data:",
                                xhr.responseText
                            );
                        },
                    });
                }
            );

            // Submit the Particular Equipment Modal Form
            $("#editProjectPartEquipmentForm").on("submit", function(event) {
                event.preventDefault();
                // Get form data
                let detail_type = 'Labor';
                let noOfUnits = $(
                    "#edit_particular_noOfUnit"
                ).val();
                let workDays = $(
                    "#edit_particular_EquipmentWorkDays"
                ).val();

                let particularId = $(
                    "#edit_particular_EquipmentParticularId"
                ).val();

                let equipmentId = $("#edit_particular_EquipmentID").val();

                console.log('This is the Rqui', equipmentId);

                // AJAX request
                $.ajax({
                    url: "/submit-details",
                    type: "POST",
                    dataType: "json",
                    data: {
                        particularId: particularId,
                        EditEquipmentId: equipmentId,
                        noOfUnits: noOfUnits,
                        equipmentWorkDays: workDays,
                        _token: "{{ csrf_token() }}",
                        // Add more form data fields here if needed
                    },
                    success: function(response) {
                        $("#editProjectPartEquipmentForm")[0].reset();
                        $("#editPartEquipmentModal").modal("hide");

                        refreshProjectItem(parseInt(particularId));

                        toastr.options.progressBar = true;
                        toastr.success("Equipment Update Successfully!");

                    },
                    error: function(xhr, status, error) {
                        // Handle error response from the server
                        console.error(
                            "Error submitting form data:",
                            xhr.responseText
                        );
                    },
                });
            });

            // Edit the Project Details Form
            $("#projectDetailsForm").submit(function(event) {
                // Prevent default form submission
                event.preventDefault();
                var submitProjectID = localStorage.getItem("projectID");

                let projectId = submitProjectID;

                // Gather form data
                let projectTitle = $("#add_project_title").val();
                let projectLocation = $("#add_project_location").val();
                let projectOwner = $("#add_project_owner").val();
                let projectDescription = $("#add_project_description").val();
                let contactDuration = $("#add_project_contract_duration").val();
                let appropriation = $("#add_project_appropriation").val();
                let sourceOfFund = $("#add_project_source_of_fund").val();
                let datePrepared = $("#add_project_date_prepared").val();
                let projectCategory = $("#add_project_category").val();
                let modeOfImplementation = $("#add_project_mode_of_implementation").val();
                let ocm = $("#add_project_ocm").val();
                let cp = $("#add_project_contractProfit").val();
                let vat = $("#add_project_vat").val();

                // Remove the P and commas
                let projectCostCleaned = appropriation.replace('₱', '').replace(/,/g,
                    '');
                let projectCost = parseFloat(projectCostCleaned);
                // Send Ajax request
                $.ajax({
                    url: "{{ route('getAllData.store') }}",
                    type: "POST",
                    data: {
                        add_project_id: projectId,
                        add_project_title: projectTitle,
                        add_project_location: projectLocation,
                        add_project_owner: projectOwner,
                        add_project_description: projectDescription,
                        add_project_contract_duration: contactDuration,
                        add_project_appropriation: projectCost,
                        add_project_source_of_fund: sourceOfFund,
                        add_project_date_prepared: datePrepared,
                        add_project_category: projectCategory,
                        add_project_mode_of_implementation: modeOfImplementation,
                        add_project_ocm: ocm,
                        add_project_cp: cp,
                        add_project_vat: vat,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        // Reset the form
                        // $("#projectDetailsForm")[0].reset();
                        // getProjects();

                        toastr.options.progressBar = true;
                        toastr.success("Project Updated Successfully!");
                        // Request succeeded, do something with the response if needed
                        console.log("Success Response:", response);
                    },
                    error: function(xhr, status, error) {
                        // Request failed
                        console.error("Request failed. Status:", status);
                        console.error("Error:", error);
                        console.error("Response Text:", xhr.responseText);
                    },
                });
            });

            $('#addSignatureBtn').click(function() {
                $('#addProjectSignatureModal').modal('show');
            });

            $("#add_project_signature_role, #add_project_signature_position").select2({
                theme: "bootstrap-5",
                tags: true,
                dropdownParent: $("#addProjectSignatureModal"),
            });
            $("#edit_project_signature_role, #edit_project_signature_position")
                .select2({
                    theme: "bootstrap-5",
                    tags: true,
                    dropdownParent: $("#editProjectSignatureModal"),
                });

            // Adding of Signature Form
            $('#addSignatureForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                var submitProjectID = localStorage.getItem("projectID");
                let projectId = submitProjectID;
                let fullName = $('#add_project_signature_fullName').val();
                let degree = $('#add_signature_degree').val();
                let role = $('#add_project_signature_role').val();
                let position = $('#add_project_signature_position').val();
                let projectID = $('#signature_projectID').val();

                console.log(projectId);
                console.log(fullName);

                // Make AJAX request to add new paticular
                $.ajax({
                    url: "{{ route('signatures.store') }}",
                    type: "POST",
                    data: {
                        fullName: fullName,
                        degree: degree,
                        role: role,
                        position: position,
                        projectId: projectId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {

                        console.log(response); // Log response for debugging

                        if (response.success) {
                            $('#addSignatureForm')[0].reset();
                            $('#addProjectSignatureModal').modal('hide');
                            toastr.options.progressBar = true;
                            toastr.success('Signature Added Successfully!');

                            refreshSignature();
                        } else {
                            toastr.options.progressBar = true;
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });

            // Edit Signature
            $('#editSignatureForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                var submitProjectID = localStorage.getItem("projectID");
                let projectId = submitProjectID;
                let fullName = $('#edit_project_signature_fullName').val();
                let degree = $('#edit_signature_degree').val();
                let role = $('#edit_project_signature_role').val();
                let position = $('#edit_project_signature_position').val();
                let signatureID = $('#editSignatureID').val();

                console.log(signatureID);

                // Check if all values are empty
                if (position === null) {
                    toastr.options.progressBar = true;
                    toastr.error('Position is Required');
                } else {
                    // Make AJAX request to add new paticular
                    $.ajax({
                        url: "{{ route('signatures.update', ['signature' => ':signature']) }}"
                            .replace(
                                ':signature',
                                signatureID),
                        type: "PUT",
                        data: {
                            fullName: fullName,
                            degree: degree,
                            signature_id: signatureID,
                            role: role,
                            position: position,
                            projectId: projectId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response);
                            toastr.options.progressBar = true;
                            if (response.success) {
                                toastr.success(response.message);

                                $('#editSignatureForm')[0].reset();
                                $('#editProjectSignatureModal').modal('hide');

                                refreshSignature();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            alert('Error occurred. Check console for details.');
                        }
                    });
                }
            });

        });

        function refreshSignature() {

            // Check if data is already cached in localStorage
            var cachedSignatureData = localStorage.getItem('signatureData');

            if (cachedSignatureData) {
                // If cached data exists, parse and use it
                displaySignature(JSON.parse(cachedSignatureData));
            }
            // If no cached data, fetch new data via AJAX
            $.ajax({
                url: "{{ route('signatures.index') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Store fetched data in localStorage for future use
                    localStorage.setItem('signatureData', JSON.stringify(data));
                    // Display the fetched data
                    displaySignature(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }

        // Display the signature
        function displaySignature(data) {
            var submitProjectID = localStorage.getItem("projectID");

            // Filter the data to include only signatures with matching project_id
            var filteredData = data.filter(signature => signature.project_id == submitProjectID);

            var table = $('#signatureTable').DataTable();
            var existingRows = table.rows().remove().draw(false);

            filteredData.forEach(function(signature, index) {
                var newRow = table.row.add([
                    signature.fullname,
                    signature.degree,
                    signature.role,
                    signature.position,
                    '<div class="text-center d-flex">' +
                    `<button type="button" class="btn bg-success mr-2" data-id="${signature.project_id}" onclick="editSignatureModal(${signature.project_id}, '${signature.fullname}', '${signature.degree}', '${signature.position}', '${signature.role}', ${signature.signature_id} )"><i class="fas fa-edit"></i></button>` +
                    `<button type="button" class="btn bg-danger" data-id="${signature.particular_id}" onclick="deleteSignature(${signature.signature_id})"><i class="fas fa-trash-alt"></i></button>` +
                    '</div>'
                ]).node();
            });

            table.draw();
        }

        // Edit Signature Modal
        function editSignatureModal(project_id, fullname, degree, position, role, signature_id) {
            $('#edit_project_signature_fullName').val(fullname)

            if (degree === "null") {
                degree = "";
                $('#edit_signature_degree').val(degree)
            } else {
                $('#edit_signature_degree').val(degree)
            }


            function updateOrAppendOption($select, value) {
                // Check if the option already exists
                var optionExists = $select.find('option[value="' + value + '"]').length > 0;

                if (optionExists) {
                    // Update the existing option's text and value
                    $select.val(value).trigger('change');
                } else {
                    // Create a new option element
                    var newOption = new Option(value, value, true, true);

                    // Append the new option to the Select2 input
                    $select.append(newOption).trigger('change');
                }
            }

            // Usage
            updateOrAppendOption($('#edit_project_signature_role'), role);
            updateOrAppendOption($('#edit_project_signature_position'), position);

            $('#editSignatureID').val(signature_id)
            $('#editProjectSignatureModal').modal('show');
        }
        // Delete Signature
        function deleteSignature(signature_id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this Signature!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('signatures') }}/" + signature_id,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.options.progressBar = true;
                            toastr.success('Signature Deleted Successfully!');
                            refreshSignature();
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText); // Log error response for debugging
                            toastr.error(
                                'Error occurred while deleting Signature. Please check console for details.'
                            );
                        }
                    });
                }
            });
        }

        // Input Price Library
        function initializePriceInputs() {
            const priceInputs = document.querySelectorAll('.price-input');
            priceInputs.forEach(input => {
                const mask = IMask(input, {
                    mask: '₱num',
                    blocks: {
                        num: {
                            // nested masks are available!
                            mask: Number,
                            thousandsSeparator: ',',
                            padFractionalZeros: true,
                            normalizeZeros: true,
                            radix: '.',
                            mapToRadix: ['.'],
                            min: 0,
                            scale: 2
                        }
                    }
                });
            });
        }

        // Initialized QuantituInputs Imask
        function initializeQuantityInputs() {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            quantityInputs.forEach(input => {
                const mask = IMask(input, {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: ',',
                    padFractionalZeros: true,
                    normalizeZeros: true,
                    radix: '.',
                    mapToRadix: ['.'],
                    min: 0
                });
            });
        }

        // Function to Calculate the total value of each Project Particular Detail
        function calculateTotalAmount() {
            $.ajax({
                url: "{{ route('calculateTotalAmount.index') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    // Loop through each project particular object in the data
                    for (const particular of data) {
                        const projectParticularId = particular.project_particular_id;
                        let totalMaterialAmount = 0;
                        let totalLaborAmount = 0;
                        let totalEquipmentAmount = 0;

                        // Check if materials exist for the current project particular
                        if (particular.materials && particular.materials.length > 0) {
                            // Loop through each material in the 'materials' array
                            for (const material of particular.materials) {
                                const materialPrice = parseFloat(material.material_price.replace(/,/g,
                                    '')); // Parse price, remove commas
                                const quantity = material.quantity || 0; // Handle null quantity
                                totalMaterialAmount += materialPrice * quantity;
                            }
                        }
                        // Check if labors exist for the current project particular
                        if (particular.labors && particular.labors.length > 0) {
                            // Loop through each labor in the 'labors' array
                            for (const labor of particular.labors) {
                                const laborRate = parseFloat(labor.rate.replace(/,/g,
                                    '')); // Parse rate, remove commas
                                const noOfPerson = labor.no_of_persons || 0; // Handle null quantity
                                const workDays = labor.work_days || 0;
                                totalLaborAmount += laborRate * noOfPerson * workDays;
                            }
                        }
                        // Check if Equipment exist for the current project particular
                        if (particular.equipments && particular.equipments.length > 0) {
                            // Loop through each equipment in the 'equipments' array
                            for (const equipment of particular.equipments) {
                                const equipmentRate = parseFloat(equipment.equipment_rate.replace(/,/g,
                                    '')); // Parse rate, remove commas
                                const noOfUnits = equipment.no_of_units || 0; // Handle null quantity
                                const workDays = equipment.work_days || 0;
                                totalEquipmentAmount += equipmentRate * noOfUnits * workDays;
                            }
                        }

                        // Update the corresponding total material amount span with comma separators
                        $(`#totalMaterialAmount_${projectParticularId}`).text(
                            `${totalMaterialAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );
                        // Material Toggle
                        $(`#materialCardAmount_${projectParticularId}`).text(
                            `${totalMaterialAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );

                        // Update The Total Labor Amount
                        $(`#totalLaborAmount_${projectParticularId}`).text(
                            `${totalLaborAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );

                        // Labor Toggle
                        $(`#laborCardAmount_${projectParticularId}`).text(
                            `${totalLaborAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );

                        // Update The Total Equipment Amount
                        $(`#totalEquipmentAmount_${projectParticularId}`).text(
                            `${totalEquipmentAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );

                        // Equipment Toggle
                        $(`#equipmentCardAmount_${projectParticularId}`).text(
                            `${totalEquipmentAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );

                        // Update the Total Amount of Each Project Item
                        let TotalProjectItemAmount = 0;

                        TotalProjectItemAmount += totalMaterialAmount + totalLaborAmount +
                            totalEquipmentAmount;

                        $(`#total_${projectParticularId}`).text(
                            `${TotalProjectItemAmount.toLocaleString('en-US', { style: 'currency', currency: 'PHP' })}`
                        );


                        // Calculate labor amount as a percentage of total material amount
                        let laborAmountPercent = ((totalLaborAmount / totalMaterialAmount) * 100).toFixed(2);

                        $(`#laborPercent_${projectParticularId}`).text(
                            `(${laborAmountPercent}%) of Material`
                        );



                    }

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                },
            });
        }

        calculateTotalAmount();

        // Edit Technical Personnel
        function editTechnicalPersonnel(personnelId, personnelIdDescription) {
            console.log(personnelId);
        }


        document.addEventListener("DOMContentLoaded", function() {
            // Initialized DataTables
            var techPersonnelTable = $('#technicalPersonnelTable').DataTable();

            $('#addMinimumEquipmentBtn').click(function() {
                $("#addMinimumEquipmentModal").modal("show");
            });
            $('#addtechnicalPersonnelBtn').click(function() {
                $("#addTechnicalPersonnelModal").modal("show");
            });

            $('#addTechnicalPersonnelForm').submit(function(e) {
                e.preventDefault();

                // Get form data
                let personnel_no = $('#add_personnel_no').val();
                let description = $('#add_personnel_description').val();

                // Make AJAX request to add new material
                $.ajax({
                    url: "{{ route('technical_personnels.store') }}",
                    type: "POST",
                    data: {
                        personnelDescription: description,
                        personnelNo: personnel_no,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.options.progressBar = true;
                        toastr.success('Technical Personnel Added Successfully!');
                        refreshTechnicalPersonnel();


                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response for debugging
                        alert('Error occurred. Check console for details.');
                    }
                });
            });


            function refreshTechnicalPersonnel() {
                var techPersonnelTable = $('#technicalPersonnelTable').DataTable();
                techPersonnelTable.clear(); // Clear existing data

                $.ajax({
                    url: "{{ route('technical_personnels.index') }}",
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var rows = [];

                        data.forEach(function(tech_personnel) {
                            rows.push([
                                tech_personnel.personnel_no,
                                tech_personnel.personnel_description,
                                `<div class="text-center d-flex">
                        <button type="button" class="btn bg-success mr-2" data-id="${tech_personnel.personnel_id}" onclick="editTechnicalPersonnel(${tech_personnel.personnel_id}, '${tech_personnel.personnel_description}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn bg-danger" data-id="${tech_personnel.personnel_id}" onclick="deleteTechnicalPersonnel(${tech_personnel.personnel_id})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>`
                            ]);
                        });

                        techPersonnelTable.rows.add(rows).draw(); // Add new rows and redraw the table
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }


            // minimum_equipments

            function refreshMinimumEquipment() {
                $.ajax({
                    url: "{{ route('minimum_equipments.index') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log('Minimun Equipments: ', data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    },
                });
            }
            refreshMinimumEquipment();

            // Code to execute when the DOM is fully loaded
            // const sortable = new Sortable(document.getElementById('projectParticularContent'), {
            //     group: 'shared', // set both lists to the same group
            //     animation: 150
            // });

            new Sortable(data_wrapper, {
                animation: 150,
                ghostClass: 'blue-background-class'
            });

            // // Function to update Roman numerals
            // function updateRomanNumerals() {
            //     const listItems = document.querySelectorAll('#projectParticularContent .numeralPartName');
            //     listItems.forEach((item, index) => {
            //         const romanNumeral = intToRoman(index +
            //             1); // Adding 1 to index to match 1-based indexing
            //         const spanElement = item.querySelector('span'); // Get the span element inside h5
            //         if (spanElement) {
            //             spanElement.textContent = romanNumeral; // Set the Roman numeral as the span's text
            //         }
            //     });
            // }

            // // Function to save the order of list items in local storage
            // function saveOrder() {
            //     const listItems = document.querySelectorAll('#projectParticularContent .numeralPartName');
            //     const order = Array.from(listItems).map(item => ({
            //         id: item.id,
            //         text: item.textContent
            //     }));
            //     localStorage.setItem('sortableOrder', JSON.stringify(order));
            //     console.log('Saved Sorted order saved locally:', order);
            // }

            // // Function to load the order of list items from local storage
            // function loadOrder() {
            //     const order = JSON.parse(localStorage.getItem('sortableOrder'));
            //     if (order) {
            //         const listItems = document.querySelectorAll('#projectParticularContent .numeralPartName');
            //         listItems.forEach((item, index) => {
            //             item.textContent = order[index];
            //         });
            //     }
            // }

            // // Initialize Roman numerals
            // function intToRoman(num) {
            //     const romanNumerals = [{
            //             value: 100,
            //             numeral: "C"
            //         },
            //         {
            //             value: 50,
            //             numeral: "L"
            //         },
            //         {
            //             value: 10,
            //             numeral: "X"
            //         },
            //         {
            //             value: 9,
            //             numeral: "IX"
            //         },
            //         {
            //             value: 5,
            //             numeral: "V"
            //         },
            //         {
            //             value: 4,
            //             numeral: "IV"
            //         },
            //         {
            //             value: 1,
            //             numeral: "I"
            //         }
            //     ];
            //     let result = '';
            //     romanNumerals.forEach(({
            //         value,
            //         numeral
            //     }) => {
            //         while (num >= value) {
            //             result += numeral;
            //             num -= value;
            //         }
            //     });
            //     return result + ". ";
            // }

            // // Call updateRomanNumerals() initially
            // updateRomanNumerals();

            // // Listen for SortableJS events
            // sortable.option("onEnd", function(evt) {
            //     saveOrder();
            //     updateRomanNumerals();
            // });
        });
    </script>



    @include('modals.project_particular_detail.add_project_particular_detail')
    @include('modals.project_particular.add_projectPart_material')
    @include('modals.project_particular.add_projectPart_labor')
    @include('modals.project_particular.add_projectPart_equipment')
    @include('modals.project_particular.edit_projectPart_material')
    @include('modals.transactionals.add_trans_proj_modal')
    @include('modals.project_particular.edit_projectPart_labor')
    @include('modals.project_particular.edit_projectPart_equipment')
    @include('modals.signature.add_signature')
    @include('modals.signature.edit_signature')
    @include('modals.transactionals.add_project_item_modal')
    @include('modals.min_equipment.add_min_equipment')
    @include('modals.min_equipment.edit_min_equipment')
    @include('modals.tech_personnel.add_tech_personnel')
    @include('modals.tech_personnel.edit_tech_personnel')


    <!-- /.content -->
@endsection
