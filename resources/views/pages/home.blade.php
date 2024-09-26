@extends('pages.default')

@section('title', 'OpenSim')

@section('content')
<div class="panel panel-default" style="margin-top:20px;">
    <div class="panel-body">
        <h1 style="text-align:center;margin:0px;"><i class="fa fa-medkit fa-fw"></i> OpenSim Registry</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm-6" style="font-size:20px;">
        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    Welcome to the OpenSim Registry, 
                    an open-source database designed to enhance experiential learning activities at 
                    Binghamton University and across State University of New York (SUNY) institutions. 
                    This platform allows users to <a href="{{route('search')}}">easily search</a>
                    for and access a wide range of validated 
                    learning activities in healthcare simulation and interprofessional education (IPE).
                </p>
                <p>
                    This registry serves as a centralized resource for managing and coordinating educational 
                    offerings, reducing duplication of efforts, and promoting collaboration among institutions. 
                    By providing a transparent record of IPE and simulation-based learning activities, we support 
                    compliance with accreditation standards and uphold best practice criteria. Join us in fostering 
                    a network that enhances educational experiences and encourages the exchange of ideas and 
                    successful strategies across disciplines.
                </p>
                <p>
                    For more information, <a href="https://www.binghamton.edu/decker/clinics-centers/ispc/contact.html" target="_blank">
                    contact</a> the Binghamton University Innovative Simulation and Practice Center
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <img src="https://www.binghamton.edu/news/images/uploads/features/P1040099.jpg" style="width:100%;border-radius:3px">
    </div>
</div>
@endsection
