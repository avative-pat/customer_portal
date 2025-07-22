# Your Plan Card Feature

## Overview
This feature enhances the Dashboard view of the Sonar Customer Portal by adding a new "Your Plan" card that displays basic information about the account's data service.

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
  - Monthly price
  - Service type (DATA)
  - Download speed (converted to Mbps when >= 1000 kbps)
  - Upload speed (converted to Mbps when >= 1000 kbps)
- Uses responsive Bootstrap grid layout (col-6 for each data point)
- Styled with consistent portal theming (card, badges, icons)

### Internationalization

#### Translation Files
Added new translation keys to support multiple languages:

**English (lang/en/headers.php):**
- `yourPlan` => 'Your Plan'
- `serviceDetails` => 'Service Details'
- `downloadSpeed` => 'Download Speed'
- `uploadSpeed` => 'Upload Speed'
- `monthlyPrice` => 'Monthly Price'
- `serviceType` => 'Service Type'
- `mbps` => 'Mbps'
- `kbps` => 'Kbps'

**Spanish (lang/es/headers.php):**
- `yourPlan` => 'Tu Plan'
- `serviceDetails` => 'Detalles del Servicio'
- `downloadSpeed` => 'Velocidad de Descarga'
- `uploadSpeed` => 'Velocidad de Carga'
- `monthlyPrice` => 'Precio Mensual'
- `serviceType` => 'Tipo de Servicio'
- `mbps` => 'Mbps'
- `kbps` => 'Kbps'

**French (lang/fr/headers.php):**
- `yourPlan` => 'Votre Plan'
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
2. **Monthly Price**: Shows the formatted currency amount using the existing Formatter::currency() method
3. **Service Type**: Always shows "DATA" to indicate it's a data service
4. **Download Speed**: Automatically converts and displays in appropriate units:
   - Shows in Kbps if speed < 1000 kbps
   - Shows in Mbps (converted) if speed >= 1000 kbps
5. **Upload Speed**: Same conversion logic as download speed

### Error Handling
- Uses try-catch block to handle potential API errors
- Logs errors using Laravel's Log facade
- Gracefully returns null if service cannot be fetched
- Card only displays if valid service data is available

### UI/UX Considerations
- Card is positioned in the left column alongside payment status cards
- Uses consistent styling with existing dashboard cards
- Includes WiFi icon (fe fe-wifi) to represent internet service
- Responsive design works on mobile and desktop
- Maintains spacing consistency with mt-3 margin

## Requirements Met

✅ **Card Title**: "Your Plan" (translated appropriately)
✅ **Service Name**: Displays the actual service name from Sonar
✅ **Amount**: Shows monthly price with proper currency formatting
✅ **Download Speed**: Displays download speed with automatic unit conversion
✅ **Upload Speed**: Displays upload speed with automatic unit conversion  
✅ **Type**: Always shows "DATA" to indicate data service
✅ **Account-specific**: Shows data for the logged-in account only
✅ **Data Service Filter**: Only shows if account has a data service

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
1. Ensure the account has at least one data service assigned
2. Log in to the customer portal
3. Navigate to the dashboard
4. The "Your Plan" card should appear in the left column
5. Verify all information displays correctly
6. Test with different language settings
7. Test with accounts that have no data services (card should not appear)