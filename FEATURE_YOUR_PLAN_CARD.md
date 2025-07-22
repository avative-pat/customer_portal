# Internet Plan Card Feature

## Overview
This feature enhances the Dashboard view of the Sonar Customer Portal by adding a new "Internet Plan" card that displays basic information about the account's data service.

## Implementation Details

### Backend Changes

#### BillingController.php
- Added `getCurrentDataService()` method to fetch the current data service for the logged-in account
- Modified the `index()` method to include `$currentDataService` in the view data
- The method filters services to find data services (where `data_service = true`)
- Returns service information including:
  - Service ID
  - Service name
  - Monthly amount (price)
  - Download speed (in kilobits per second)
  - Upload speed (in kilobits per second)
  - Service type (always "DATA" for data services)

### Frontend Changes

#### Blade Template (resources/views/pages/billing/index.blade.php)
- Added a new card section that displays when `$currentDataService` is available
- Card includes:
  - Service name as the main title
  - Monthly price (full width)
  - Download speed with down arrow icon (always in Mbps)
  - Upload speed with up arrow icon (always in Mbps)
- Service type is not displayed to end users (removed based on feedback)
- Uses responsive Bootstrap grid layout (col-6 for speed data points)
- Styled with consistent portal theming (card, badges, icons)
- Added arrow icons (fe fe-arrow-down, fe fe-arrow-up) for speed indicators

### Internationalization

#### Translation Files
Added new translation keys to support multiple languages:

**English (lang/en/headers.php):**
- `internetPlan` => 'Internet Plan'
- `serviceDetails` => 'Service Details'
- `downloadSpeed` => 'Download Speed'
- `uploadSpeed` => 'Upload Speed'
- `monthlyPrice` => 'Monthly Price'
- `serviceType` => 'Service Type'
- `mbps` => 'Mbps'
- `kbps` => 'Kbps'

**Spanish (lang/es/headers.php):**
- `internetPlan` => 'Plan de Internet'
- `serviceDetails` => 'Detalles del Servicio'
- `downloadSpeed` => 'Velocidad de Descarga'
- `uploadSpeed` => 'Velocidad de Carga'
- `monthlyPrice` => 'Precio Mensual'
- `serviceType` => 'Tipo de Servicio'
- `mbps` => 'Mbps'
- `kbps` => 'Kbps'

**French (lang/fr/headers.php):**
- `internetPlan` => 'Plan Internet'
- `serviceDetails` => 'Détails du Service'
- `downloadSpeed` => 'Vitesse de Téléchargement'
- `uploadSpeed` => 'Vitesse de Téléversement'
- `monthlyPrice` => 'Prix Mensuel'
- `serviceType` => 'Type de Service'
- `mbps` => 'Mbps'
- `kbps` => 'Kbps'

## Features

### Data Display
1. **Service Name**: Displays the name of the data service
2. **Monthly Price**: Shows the formatted currency amount using the existing Formatter::currency() method (full width layout)
3. **Download Speed**: Always displays in Mbps with down arrow icon
   - Converts from kilobits per second to Mbps (divides by 1000)
   - Shows 2 decimal places for speeds < 1 Mbps, 0 decimal places for speeds >= 1 Mbps
4. **Upload Speed**: Always displays in Mbps with up arrow icon
   - Same conversion logic as download speed
5. **Service Type**: Removed from display (not shown to end users)

### Error Handling
- Uses try-catch block to handle potential API errors
- Logs warnings (not errors) using Laravel's Log facade to avoid alert fatigue
- Gracefully returns null if service cannot be fetched OR if no data service exists
- Card only displays if valid service data is available
- Handles accounts without data services as a normal scenario (no errors logged)
- Additional safety checks in Blade template with null coalescing operators
- Validates service properties exist before accessing them

### UI/UX Considerations
- Card is positioned in the left column alongside payment status cards
- Uses consistent styling with existing dashboard cards
- Includes WiFi icon (fe fe-wifi) to represent internet service
- Responsive design works on mobile and desktop
- Maintains spacing consistency with mt-3 margin

## Requirements Met

✅ **Card Title**: "Internet Plan" (translated appropriately)
✅ **Service Name**: Displays the actual service name from Sonar
✅ **Amount**: Shows monthly price with proper currency formatting
✅ **Download Speed**: Displays download speed always in Mbps with down arrow icon
✅ **Upload Speed**: Displays upload speed always in Mbps with up arrow icon  
✅ **Type**: "DATA" service type (not displayed to users per feedback)
✅ **Account-specific**: Shows data for the logged-in account only
✅ **Data Service Filter**: Only shows if account has a data service

## User Feedback Implemented

✅ **Removed Service Type Display**: "Service Type: DATA" no longer shown to end users
✅ **Added Speed Icons**: Upload speed has up arrow, download speed has down arrow
✅ **Always Show Mbps**: Both speeds always displayed in Mbps (no Kbps)
✅ **Card Title Change**: Changed from "Your Plan" to "Internet Plan"
✅ **Data Fetching Fix**: Enhanced service property detection for correct values

## Future Enhancements

Potential improvements that could be made:
1. Add link to service management/upgrade page
2. Include data usage progress bar if usage-based billing is enabled
3. Show service activation date
4. Add service status (active/suspended)
5. Include overage information if applicable
6. Add service tier/package information

## Testing Notes

To test this feature:

**With Data Service:**
1. Ensure the account has at least one data service assigned
2. Log in to the customer portal
3. Navigate to the dashboard
4. The "Internet Plan" card should appear in the left column
5. Verify all information displays correctly:
   - Service name shows correctly
   - Monthly price shows actual amount (not $0.00)
   - Download speed shows in Mbps with down arrow icon
   - Upload speed shows in Mbps with up arrow icon
   - Service type is NOT displayed
6. Test with different language settings

**Without Data Service (Critical Test):**
1. Use an account that has NO data services (only voice, recurring, or other service types)
2. Log in to the customer portal
3. Navigate to the dashboard
4. The "Internet Plan" card should NOT appear
5. No errors should be logged or displayed
6. Dashboard should function normally

**Debugging Zero Values:**
If values are showing as zero, check the application logs for the debug information that shows:
- service_properties: Available properties on the service object
- service_def_properties: Available properties on the service definition object
- This will help identify the correct property names for amount and speeds

**Edge Cases:**
1. Account with empty services array
2. Account with services but all non-data services
3. Account with data service but missing properties
4. API errors when fetching services