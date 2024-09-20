@php use App\Http\Controllers\WiFiController; @endphp
@extends('layouts.full')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <!-- Header -->
                <div class="header mt-md-5">
                    <div class="header-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <!-- Pretitle -->
                                <h6 class="header-pretitle">
                                    WiFI Equipment
                                </h6>
                                <!-- Title -->
                                <h1 class="header-title">
                                    Router Details
                                </h1>
                            </div>
                            <div class="col-auto">
                            </div>
                        </div>
                        <!-- / .row -->
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title text-muted mt-3">
                            Current Router Settings
                        </h4>
                    </div>

                    <div class="card-body">
                        <form id="wifiForm" action="{{ action([WiFiController::class, 'update'], ['id' => $id]) }}" method="POST">
                            @csrf

                            <!-- Equipment ID Section -->
                            <div class="form-group">
                                <label for="equipment_id">Equipment ID</label>
                                <input type="text" class="form-control" id="equipment_id" name="equipment_id" value="{{ $id }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="ssid">SSID</label>
                                <input type="text" class="form-control" id="ssid" name="ssid" value="{{ $routerDetails['ssid'] }}" disabled>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" value="{{ $routerDetails['password'] }}" disabled>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="togglePassword">Show</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary" id="editButton">Edit</button>
                                <button type="submit" class="btn btn-success" id="submitButton" style="display: none;">Submit</button>
                                <button type="button" class="btn btn-secondary" id="cancelButton" style="display: none;">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const toggleButton = document.getElementById('togglePassword');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.textContent = 'Hide';
            } else {
                passwordField.type = 'password';
                toggleButton.textContent = 'Show';
            }
        });

        document.getElementById('editButton').addEventListener('click', function () {
            document.getElementById('ssid').disabled = false;
            document.getElementById('password').disabled = false;
            document.getElementById('submitButton').style.display = 'inline-block';
            document.getElementById('cancelButton').style.display = 'inline-block';
        });
    </script>
@endsection