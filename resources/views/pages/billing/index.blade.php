@extends('layouts.full')
@section('content')

@if (isset($values["currentUsage"]["billable"]))
<style nonce="{{ csp_nonce() }}">
   #usage-progressbar {
     width:  {{$values["currentUsage"]["billable"]}}%
   }
</style>
@endif

<!-- HEADER -->
<div class="header index-bg pb-5">
   <div class="container-fluid">
      <!-- Body -->
      <div class="header-body-nb">
         <div class="row align-items-end">
            <div class="col">
               <!-- Pretitle -->
               <h6 class="header-pretitle text-secondary-light">
                  {{utrans("headers.summary")}}
               </h6>
               <!-- Title -->
               <h1 class="header-title text-white">
                  {{utrans("headers.dashboard")}}
               </h1>
            </div>
            <div class="col-auto">
               <!-- Nav -->
               <ul class="nav nav-tabs header-tabs">
                  <li class="nav-item">
                     <a class="nav-link text-right">
                        <h6 class="header-pretitle text-secondary-light">
                           {{utrans("headers.amountDue")}}
                        </h6>
                        <h3 class="text-white mb-0">
                           {{Formatter::currency($values['amount_due'])}}
                        </h3>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <!-- / .row -->
      </div>
      <!-- / .header-body -->
   </div>
</div>

<!-- MAIN CONTENT -->
<div class="container-fluid mt--6">
   <div class="row">
      <div class="col-12 col-xl-4">
         @if($values['amount_due'] > 0)
         <div class="card">
            <div class="card-body text-center">
               <div class="row justify-content-center">
                  <div class="col-12 col-xl-10">
                     <span class="badge badge-soft-danger">
                        <i class="fe fe-alert-triangle cspfont1"></i>
                     </span>
                     <h2 class="mb-2 mt-3">
                        {{utrans("headers.amountDue")}}
                     </h2>
                     <p class="text-muted">
                        {{Formatter::currency($values['amount_due'])}}
                     </p>
                     <a href="{{action([\App\Http\Controllers\BillingController::class, 'makePayment'])}}" class="btn btn-white">
                        {{utrans("billing.makePayment")}}
                     </a>
                  </div>
               </div>
            </div>
         </div>
         @else
         <div class="card">
            <div class="card-body text-center mb-4 mt-5">
               <div class="row justify-content-center">
                  <div class="col-12 col-xl-10">
                     <span class="badge badge-soft-success">
                        <i class="fe fe-thumbs-up cspfont1"></i>
                     </span>
                     <h2 class="mb-4 mt-4">
                        {{utrans("headers.allPaid")}}
                     </h2>
                     <a href="{{action([\App\Http\Controllers\BillingController::class, 'makePayment'])}}" class="btn btn-white">
                        {{utrans("billing.makePayment")}}
                     </a>
                  </div>
               </div>
            </div>
         </div>
         @endif
      </div>
      <div class="col-12 col-xl-8">
         <div class="row">
            <div class="col-12 col-xl-6">
               <div class="card">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                           <h6 class="card-title text-uppercase text-muted mb-2">
                              {{utrans("billing.totalBalance")}}
                           </h6>
                           <span class="h2 mb-0">
                              {{Formatter::currency($values['balance_minus_funds'])}}
                           </span>
                        </div>
                        <div class="col-auto">
                           <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-12 col-xl-6">
               <div class="card">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                           <h6 class="card-title text-uppercase text-muted mb-2">
                              {{utrans("billing.nextBillDate")}}
                           </h6>
                           <span class="h2 mb-0">
                              @if($values['next_bill_date'] !== null)
                              {{Formatter::date($values['next_bill_date'], false)}}
                              @else
                              {{utrans("general.notAvailable")}}
                              @endif
                           </span>
                        </div>
                        <div class="col-auto">
                           <span class="h2 fe fe-calendar text-muted mb-0"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col-12 col-xl-6">
               <div class="card">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                           <h6 class="card-title text-uppercase text-muted mb-2">
                              {{utrans("billing.nextBillAmount")}}
                           </h6>
                           <span class="h2 mb-0">
                              @if($values['next_bill_amount'] !== null)
                              {{Formatter::currency($values['next_bill_amount'])}}
                              @else
                              {{utrans("general.notAvailable")}}
                              @endif
                           </span>
                        </div>
                        <div class="col-auto">
                           <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            @if($systemSetting->data_usage_enabled === true && $values["currentUsage"] && isset($values["currentUsage"]["billable"]))
            <div class="col-12 col-xl-6">
               <div class="card">
                  <div class="card-body">
                     <div class="row align-items-center">
                        <div class="col">
                           <h6 class="card-title text-uppercase text-muted mb-2">
                              {{utrans("headers.currentDataUsage")}}
                           </h6>
                           <div class="row align-items-center no-gutters">
                              <div class="col-auto">
                                 <span class="h2 mr-2 mb-0">
                                    {{$values["currentUsage"]["billable"]}}GB
                                 </span>
                              </div>
                              <div class="col">
                                 <div class="progress progress-sm">
                                    <div id="usage-progressbar" class="progress-bar" role="progressbar" aria-valuenow="{{$values["currentUsage"]["billable"]}}" aria-valuemin="0" aria-valuemax="100"></div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-auto">
                           <span class="h2 fe fe-activity text-muted mb-0"></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endif

            <!-- WiFi Router Management Card (Displayed Even If routerDetails is Missing) -->
            <div class="col-12 col-xl-6">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-header-title text-muted">
                        <i class="fe fe-wifi mr-3"></i>WiFi Router Management
                     </h4>
                  </div>
                  <div class="card-body">
                     @if(isset($routerDetails))
                     <!-- Display the SSID and Password Form -->
                     <form method="POST" action="{{ action([\App\Http\Controllers\WiFiController::class, 'updateRouter']) }}">
                        @csrf
                        <div class="form-group">
                           <label for="ssid">SSID</label>
                           <input type="text" id="ssid" name="ssid" class="form-control" value="{{ $routerDetails['ssid'] }}" readonly>
                        </div>

                        <div class="form-group">
                           <label for="password">Password</label>
                           <div class="input-group">
                              <input type="password" id="password" name="password" class="form-control" value="{{ $routerDetails['password'] }}" readonly>
                              <div class="input-group-append">
                                 <button type="button" class="btn btn-secondary" id="toggle-password" onclick="togglePassword()">Show</button>
                              </div>
                           </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update WiFi Settings</button>
                     </form>
                     @else
                     <!-- Show a Message If No Router Details Are Available -->
                     <p class="text-danger">No router details found.</p>
                     @endif
                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
</div>

<script>
function togglePassword() {
   var passwordInput = document.getElementById("password");
   var toggleButton = document.getElementById("toggle-password");
   
   if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleButton.textContent = "Hide";
   } else {
      passwordInput.type = "password";
      toggleButton.textContent = "Show";
   }
}
</script>

@endsection
