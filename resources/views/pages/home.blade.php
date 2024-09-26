@extends('pages.default')

@section('title', 'OpenSim')

@section('content')
<h1 style="text-align:center;">OpenSim</h1>
<div class="row">
<div class="col-sm-6" style="font-size:20px;">
<p>
    Welcome to the OpenSim, 
    an open-source database designed to enhance experiential learning activities at 
    Binghamton University and across State University of New York (SUNY) institutions. 
    Our platform allows users to <a href="{{route('search')}}">easily search</a>
    for and access a wide range of validated 
    learning activities in healthcare simulation and IPE.
</p>
<p>
    Key features include user login for tracking activity, flexible reporting options, and 
    the ability to download activity PDFs. Data entry is restricted to approved users, 
    ensuring the integrity and quality of the content.
</p>
<p>
    This registry serves as a centralized resource for managing and coordinating educational 
    offerings, reducing duplication of efforts, and promoting collaboration among institutions. 
    By providing a transparent record of IPE and simulation-based learning activities, we support 
    compliance with accreditation standards and uphold best practice criteria. Join us in fostering 
    a network that enhances educational experiences and encourages the exchange of ideas and 
    successful strategies across disciplines.
</p>
</div>
<div class="col-sm-6">
    <img src="https://www.binghamton.edu/news/images/uploads/features/P1040099.jpg" style="width:100%;">
</div>
</div>
@endsection
