<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WiFiController extends Controller
{
    public function __construct()
    {
        // Initialization if needed.
    }

    /**
     * Display a listing of the WiFi equipment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        return response()->view('pages.wifi.index');
    }

    /**
     * Show the WiFi router management page with current SSID and password.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRouterSettings(): \Illuminate\Http\Response
    {
        $routerDetails = $this->getRouterDetails();

        if (empty($routerDetails)) {
            return response()->json(['error' => 'Router details not found'], 500);
        }

        return view('pages.wifi.index', compact('routerDetails'));
    }

    /**
     * Retrieve current router details
     *
     * @return array
     */
    protected function getRouterDetails(): array
    {
        // Define the router details with dummy test values
        $routerDetails = [
            'ssid' => 'TestNetwork',  // Dummy SSID
            'password' => 'testpassword123' // Dummy Password
        ];

        // Debugging log to verify the router details are being set
        Log::info('Router Details:', $routerDetails);

        return $routerDetails;
    }

    /**
     * Update the WiFi router settings (SSID and Password).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRouter(Request $request): \Illuminate\Http\Response
    {
        $validated = $request->validate([
            'ssid' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $this->saveRouterSettings($validated['ssid'], $validated['password']);

        session()->flash('success', 'WiFi settings have been updated successfully.');

        return redirect()->back();
    }

    /**
     * Save new router settings
     *
     * @param string $ssid
     * @param string $password
     * @return void
     */
    protected function saveRouterSettings(string $ssid, string $password): void
    {
        // Log the update for debugging purposes
        Log::info('Updated Router Settings:', ['ssid' => $ssid, 'password' => $password]);

        // Simulate saving the new settings to the database or external API
        // In a real-world scenario, you would persist these values into a database or update via API
        // Example: RouterService::updateCredentials($ssid, $password);
    }

    public function show($id)
    {
        $router = $this->getRouterById($id);
        if (!$router) {
            return redirect()->route('wifi.index')->with('error', 'WiFi Device not found.');
        }
        return view('wifi.show', compact('router'));
    }

    public function create()
    {
        return view('wifi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ssid' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $this->saveNewRouter($validated);

        return redirect()->route('pages.wifi.index')->with('success', 'WiFi Device created successfully.');
    }

    public function edit($id)
    {
        $router = $this->getRouterById($id);
        if (!$router) {
            return redirect()->route('pages.wifi.index')->with('error', 'WiFi Device not found.');
        }
        return view('wifi.edit', compact('router'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ssid' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $router = $this->getRouterById($id);
        if (!$router) {
            return redirect()->route('pages.wifi.index')->with('error', 'WiFi Device not found.');
        }

        $this->saveRouterSettings($validated['ssid'], $validated['password'], $id);

        return redirect()->route('pages.wifi.index')->with('success', 'WiFi Device updated successfully.');
    }

    public function destroy($id)
    {
        $router = $this->getRouterById($id);
        if (!$router) {
            return redirect()->route('pages.wifi.index')->with('error', 'WiFi Device not found.');
        }

        $this->deleteRouter($id);

        return redirect()->route('pages.wifi.index')->with('success', 'WiFi Device deleted successfully.');
    }

    /**
     * Fetch router by ID
     *
     * @param int $id
     * @return array|null
     */
    protected function getRouterById(int $id): ?array
    {
        // Simulate fetching router details by ID from a database
        // In a real system, you would use a model or query the database
        return [
            'id' => $id,
            'ssid' => 'TestNetwork',
            'password' => 'testpassword123'
        ];
    }

    /**
     * Save a new router
     *
     * @param array $routerData
     * @return void
     */
    protected function saveNewRouter(array $routerData): void
    {
        // Simulate saving the new router details to a database
        // In a real application, you would persist the data to a database
        Log::info('Creating new Router:', $routerData);
    }

    /**
     * Delete router by ID
     *
     * @param int $id
     * @return void
     */
    protected function deleteRouter(int $id): void
    {
        // Simulate deleting the router from a database
        // In a real application, you would run a delete query
        Log::info("Deleting router with ID: $id");
    }
}