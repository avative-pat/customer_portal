<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WiFiController extends Controller
{
    /**
     * Show the WiFi router management page with current SSID and password.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRouterSettings()
    {
        // Simulate fetching the router details (SSID and Password) from the database or external service.
        // In practice, you'd pull these details from a database or API.
        $routerDetails = [
            'ssid' => 'HomeNetwork', // Example SSID
            'password' => 'hiddenpassword' // Example Password
        ];

        // Return the view with the router details.
        return view('router.settings', compact('routerDetails'));
    }

    /**
     * Update the WiFi router settings (SSID and Password).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRouter(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'ssid' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        // Fetch the new SSID and password from the form
        $ssid = $request->input('ssid');
        $password = $request->input('password');

        // Simulate saving the new settings to the database or external API
        // In practice, you'd update the database or send a request to the router management API.
        // Example: RouterService::updateCredentials($ssid, $password);

        // Flash a success message to the session
        session()->flash('success', 'WiFi settings have been updated successfully.');

        // Redirect back to the WiFi management page
        return redirect()->back();
    }
}
