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
    public function showRouterSettings(): \Illuminate\Http\Response
    {
        // Define the router details with dummy test values
        $routerDetails = [
            'ssid' => 'TestNetwork',  // Dummy SSID
            'password' => 'testpassword123' // Dummy Password
        ];

        // Debugging log to verify the router details are being set
        \Log::info('Router Details:', $routerDetails);

        // Check if the router details are not empty before passing to the view
        if (empty($routerDetails)) {
            // Return an error response if the router details are missing
            return response()->json(['error' => 'Router details not found'], 500);
        }

        // Pass the $routerDetails to the view
        return view('pages.billing.index', compact('routerDetails'));
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
        // In a real-world scenario, you would persist these values into a database or update via API
        // Example: RouterService::updateCredentials($ssid, $password);

        // Log the update for debugging purposes
        \Log::info('Updated Router Settings:', ['ssid' => $ssid, 'password' => $password]);

        // Flash a success message to the session
        session()->flash('success', 'WiFi settings have been updated successfully.');

        // Redirect back to the WiFi management page
        return redirect()->back();
    }
}