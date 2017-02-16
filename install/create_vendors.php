<?php 

require_once (dirname(dirname(__FILE__)).'/includes/db.php');

$db = Database::getInstance();
$mysqli = $db->getConnection(); 

$sql = "INSERT INTO r4me_vendor_features (id, name, slug, feature_group) VALUES 
(null, 'Customizable Reports', 'customizable-reports', 'Analytics & Reporting'),
(null, 'Publicly Accessible API Documention','publicly-accessible-api-doc', 'API & SDK'),
(null, 'Modern Software Development Kits (SDKs)','modern-sdks', 'API & SDK'),
(null, 'Modern API Best Practices','modern-api-best-practices', 'API & SDK'),
(null, 'Customer Geofencing','customer-geofencing', 'Automation'),
(null, 'Workflow Triggers & Rules','workflow-triggers-and-rules', 'Automation'),
(null, 'Wifi','wifi', 'Connectivity Type'),
(null, '2G','2g', 'Connectivity Type'),
(null, '3G','3g', 'Connectivity Type'),
(null, '4G','4g', 'Connectivity Type'),
(null, '5G','5g', 'Connectivity Type'),
(null, 'Satellite','satellite', 'Connectivity Type'),
(null, 'Document Management','document-management', 'CRM'),
(null, 'Mapping of POI&#39;s','mapping-of-pois', 'CRM'),
(null, 'Invoice Management','invoice-management', 'CRM'),
(null, 'OBD','obd', 'Devices Supported'),
(null, 'Hardwired Non-OBD Harness','hardwired-non-obd-harness', 'Devices Supported'),
(null, 'Accident/Crash notification','accident-crash-notification', 'Driver & Fleet Safety'),
(null, 'Emergency call (SOS button)','emergency-call-sos-button', 'Driver & Fleet Safety'),
(null, 'Driver&#39;s behavior monitoring','driver-behavior-monitoring', 'Driver & Fleet Safety'),
(null, 'Roadside assistance','roadside-assistance', 'Driver & Fleet Safety'),
(null, 'Security services','security-services', 'Driver & Fleet Safety'),
(null, 'Stolen vehicle recovery','stolen-vehicle-recovery', 'Driver & Fleet Safety'),
(null, 'Real-time Dashcam capture','real-time-dashcam-capture', 'Driver & Fleet Safety'),
(null, 'Fuel usage reporting','fuel-usage-reporting', 'Fleet Management'),
(null, 'Trip KPI dashboard','trip-kpi-dashboard', 'Fleet Management'),
(null, 'Tachograph, odometer reading','tachograph-odometer-reading', 'Fleet Management'),
(null, 'Driver/vehicle scheduling','driver-vehicle-scheduling', 'Fleet Management'),
(null, 'GPS Tracking','gps-tracking', 'Fleet Management'),
(null, 'OBD GPS Tracking','obd-gps-tracking', 'Fleet Management'),
(null, 'Fleet Performance Predictions','fleet-performance-predictions', 'Machine Learning'),
(null, 'Traffic','traffic', 'Mapping Layers'),
(null, 'Weather','weather', 'Mapping Layers'),
(null, 'POI&#39;s','pois', 'Mapping Layers'),
(null, 'Customer Locations','customer-locations', 'Mapping Layers'),
(null, 'Linux Desktop App','linux-desktop-app', 'Native Platforms Applications for Management'),
(null, 'Mac OS Desktop App','mac-os-desktop-app', 'Native Platforms Applications for Management'),
(null, 'Windows Desktop app','windows-desktop-app', 'Native Platforms Applications for Management'),
(null, 'Android','android-driver', 'Native Smartphone App for Driver'),
(null, 'iOS','ios-driver', 'Native Smartphone App for Driver'),
(null, 'Android','android-management', 'Native Smartphone App for Management'),
(null, 'iOS','ios-management', 'Native Smartphone App for Management'),
(null, 'Manual Turn-by-Turn Voice Guidance','manual-turn-by-turn-voice-guidance', 'Navigation'),
(null, 'Automated Turn-by-Turn Voice Guidance','automated-turn-by-turn-voice-guidance', 'Navigation'),
(null, 'Salesforce Integration','salesforce-integration', 'Out-of-the-Box Integrations'),
(null, 'Netsuite Integration','netsuite-integration', 'Out-of-the-Box Integrations'),
(null, 'ServiceMax Integration','servicemax-integration', 'Out-of-the-Box Integrations'),
(null, 'Quickbooks Integration','quickbooks-integration', 'Out-of-the-Box Integrations'),
(null, 'Xero Integration','xero-integration', 'Out-of-the-Box Integrations'),
(null, 'Square Integration','square-integration', 'Out-of-the-Box Integrations'),
(null, 'RFID Driver ID','rfid-driver-id', 'Security'),
(null, 'Facial Recognition Driver ID','facial-recognition-driver-id', 'Security'),
(null, 'Fingerprint Recognition Driver ID','fingerprint-recognition-driver-id', 'Security'),
(null, 'Maintenance Schedules', 'maintenance-schedules', 'Vehicle Maintenance'),
(null, 'Vehicle Engine Diagnostics Codes', 'vehicle-engine-diagnostics-codes', 'Vehicle Maintenance'),
(null, 'Diagnostic Error Code Alerts', 'diagnostic-error-code-alerts', 'Vehicle Maintenance')
";

$result = $mysqli->query($sql);

if(!$result) die($mysqli->error);

die('Congrats! Vendors installed! You can delete this file');