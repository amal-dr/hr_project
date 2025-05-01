<!DOCTYPE html>
<html>
<head>
    <title>Employee Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Employee Portal</a>
            <div class="navbar-nav">
                <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Your Profile</h2>
        
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Matricule:</strong> {{ $employer->matricul_employer }}</p>
                        <p><strong>Name:</strong> {{ $employer->prenom }} {{ $employer->nom }}</p>
                        <p><strong>Email:</strong> {{ $employer->email }}</p>
                    </div>
                    <p><strong>Hire Date:</strong> 
    @isset($employer->date_embauche)
        {{ is_string($employer->date_embauche) 
            ? \Carbon\Carbon::parse($employer->date_embauche)->format('d/m/Y')
            : $employer->date_embauche->format('d/m/Y') }}
    @else
        Not available
    @endisset
</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>