<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAFÉ IYAH - Location & Directions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #5a3921;
            --secondary: #d4b896;
            --accent: #8b5a2b;
            --light: #f5f1e8;
            --dark: #3e2e1f;
            --text: #7a5c3c;
            --success: #2d7d32;
            --error: #c53030;
            --info: #1a73e8;
            --route-color: #8b5a2b;
            --route-outline: #d4b896;
        }
        
        body {
            background: linear-gradient(135deg, var(--light) 0%, #e8dfd1 100%);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        .app-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            grid-template-rows: auto 1fr;
            height: 100vh;
            max-width: 100%;
            overflow: hidden;
        }
        
        header {
            grid-column: 1 / -1;
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo {
            font-size: 2.5rem;
            color: var(--accent);
        }
        
        .brand h1 {
            font-size: 1.8rem;
            color: var(--primary);
            font-weight: 400;
            letter-spacing: 1px;
        }
        
        .brand .tagline {
            font-size: 0.9rem;
            color: var(--text);
            font-style: italic;
        }
        
        .header-actions {
            display: flex;
            gap: 15px;
        }
        
        .header-btn {
            padding: 10px 20px;
            background: var(--light);
            border: 1px solid var(--secondary);
            border-radius: 8px;
            color: var(--primary);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .header-btn:hover {
            background: var(--secondary);
        }
        
        .map-section {
            position: relative;
            background: #e8dfd1;
        }
        
        #map {
            height: 100%;
            width: 100%;
            z-index: 1;
        }
        
        .map-controls {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .map-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .map-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .map-btn.active {
            background: var(--accent);
            color: white;
        }
        
        .sidebar {
            background: white;
            padding: 25px;
            overflow-y: auto;
            box-shadow: -2px 0 15px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .section {
            background: var(--light);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
        }
        
        h2 {
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--secondary);
            font-size: 1.4rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        h2 i {
            color: var(--accent);
        }
        
        .location-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .btn {
            padding: 14px 16px;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            box-shadow: 0 4px 10px rgba(139, 90, 43, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(139, 90, 43, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(135deg, var(--secondary), #c9a87a);
            color: var(--primary);
            box-shadow: 0 4px 10px rgba(212, 184, 150, 0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(212, 184, 150, 0.4);
        }
        
        .location-info {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            border-left: 4px solid var(--accent);
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: 500;
            color: var(--text);
        }
        
        .info-value {
            font-weight: 600;
            color: var(--primary);
        }
        
        .directions-panel {
            background: white;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .directions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .directions-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
        }
        
        .route-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
        }
        
        .route-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .route-distance, .route-time {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }
        
        .directions-steps {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .directions-step {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }
        
        .directions-step:hover {
            background-color: #f8f9fa;
        }
        
        .step-number {
            background: var(--route-color);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .step-content {
            flex: 1;
        }
        
        .step-text {
            font-size: 0.9rem;
            color: var(--dark);
            margin-bottom: 4px;
        }
        
        .step-distance {
            font-size: 0.8rem;
            color: var(--text);
        }
        
        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: 10px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid transparent;
        }
        
        .contact-item:hover {
            background: white;
            border-color: var(--secondary);
            transform: translateX(5px);
        }
        
        .contact-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--secondary), #c9a87a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .contact-details h3 {
            font-size: 1.1rem;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .contact-details p {
            color: var(--text);
            font-size: 0.9rem;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }
        
        .social-link {
            width: 50px;
            height: 50px;
            background: var(--light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.3rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }
        
        .social-link.facebook:hover {
            background: #1877f2;
            color: white;
        }
        
        .status-message {
            margin-top: 15px;
            padding: 12px 15px;
            border-radius: 8px;
            text-align: center;
            font-size: 0.9rem;
            display: none;
        }
        
        .success {
            background-color: rgba(240, 255, 244, 0.9);
            color: var(--success);
            border: 1px solid #c8e6c9;
        }
        
        .error {
            background-color: rgba(255, 245, 245, 0.9);
            color: var(--error);
            border: 1px solid #fed7d7;
        }
        
        .info {
            background-color: rgba(232, 245, 255, 0.9);
            color: var(--info);
            border: 1px solid #bbdefb;
        }
        
        .cafe-highlight {
            background: linear-gradient(135deg, var(--accent), var(--primary));
            color: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }
        
        .cafe-highlight h3 {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        
        .cafe-highlight p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 15px;
        }
        
        .hours {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
            font-size: 0.85rem;
        }
        
        .hour-item {
            display: flex;
            justify-content: space-between;
        }
        
        /* Coffee bean decorations */
        .coffee-bean {
            position: absolute;
            width: 30px;
            height: 18px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.1;
            z-index: 0;
        }
        
        .bean-1 {
            top: 30px;
            left: 30px;
            transform: rotate(30deg);
        }
        
        .bean-2 {
            bottom: 40px;
            right: 40px;
            transform: rotate(-15deg);
        }
        
        /* Animation for buttons */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .btn-pulse {
            animation: pulse 1.5s infinite;
        }
        
        /* Custom map popup styling */
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        
        .leaflet-popup-content {
            margin: 15px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .cafe-popup {
            text-align: center;
            min-width: 200px;
        }
        
        .cafe-popup h3 {
            color: var(--primary);
            margin-bottom: 8px;
        }
        
        .cafe-popup p {
            color: var(--text);
            margin-bottom: 10px;
        }
        
        .cafe-popup .rating {
            color: var(--secondary);
            margin-bottom: 10px;
        }
        
        /* Enhanced routing controls styling */
        .leaflet-routing-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.2);
            max-height: 400px;
            overflow-y: auto;
            width: 350px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .leaflet-routing-alt {
            max-height: 200px;
            border-bottom: 1px solid #eee;
        }
        
        .leaflet-routing-alt h2 {
            font-size: 1rem;
            margin: 10px 15px;
            color: var(--primary);
        }
        
        .leaflet-routing-alt table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .leaflet-routing-alt tr:hover {
            background-color: #f5f5f5;
        }
        
        .leaflet-routing-alt td {
            padding: 8px 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }
        
        .leaflet-routing-geocoders {
            padding: 10px 15px;
        }
        
        .leaflet-routing-geocoders input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 8px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .leaflet-routing-geocoders button {
            background: var(--route-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        .leaflet-routing-instructions {
            max-height: 250px;
            overflow-y: auto;
        }
        
        /* Custom route line styling - Coffee Theme */
        .coffee-route-line {
            stroke: var(--route-color);
            stroke-width: 6;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: none;
        }
        
        .coffee-route-outline {
            stroke: var(--route-outline);
            stroke-width: 8;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            stroke-dasharray: none;
        }
        
        /* Location loading animation */
        .location-loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Responsive design */
        @media (max-width: 1024px) {
            .app-container {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr auto;
            }
            
            .sidebar {
                grid-row: 3;
                max-height: 40vh;
            }
            
            .map-section {
                grid-row: 2;
            }
            
            .leaflet-routing-container {
                width: 300px;
            }
        }
        
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .header-actions {
                width: 100%;
                justify-content: center;
            }
            
            .location-actions {
                grid-template-columns: 1fr;
            }
            
            .leaflet-routing-container {
                width: 280px;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <header>
            <div class="logo-container">
                <div class="logo">
                    <i class="fas fa-coffee"></i>
                </div>
                <div class="brand">
                    <h1>CAFÉ IYAH</h1>
                    <p class="tagline">Your perfect coffee destination in Antipolo, Rizal</p>
                </div>
            </div>
            <div class="header-actions">
                <button class="header-btn" id="headerDirections">
                    <i class="fas fa-directions"></i>
                    Directions
                </button>
                <button class="header-btn" id="headerCall">
                    <i class="fas fa-phone"></i>
                    Call Now
                </button>
            </div>
        </header>
        
        <section class="map-section">
            <div class="coffee-bean bean-1"></div>
            <div class="coffee-bean bean-2"></div>
            <div id="map"></div>
            <div class="map-controls">
                <button class="map-btn active" id="mapLocate" title="Use My Location">
                    <i class="fas fa-location-arrow"></i>
                </button>
                <button class="map-btn" id="mapDirections" title="Get Directions">
                    <i class="fas fa-route"></i>
                </button>
                <button class="map-btn" id="mapReset" title="Reset View">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </section>
        
        <aside class="sidebar">
            <div class="section">
                <h2><i class="fas fa-map-marker-alt"></i> Location & Directions</h2>
                
                <div class="location-actions">
                    <button class="btn btn-primary btn-pulse" id="useLocation">
                        <i class="fas fa-location-arrow"></i>
                        My Location
                    </button>
                    <button class="btn btn-secondary" id="setStartPoint">
                        <i class="fas fa-route"></i>
                        Directions
                    </button>
                    <button class="btn btn-secondary" id="shareLocation">
                        <i class="fas fa-share-alt"></i>
                        Share
                    </button>
                </div>
                
                <div class="location-info">
                    <div class="info-row">
                        <span class="info-label">Address:</span>
                        <span class="info-value">Antipolo, Rizal</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Status:</span>
                        <span class="info-value" id="locationStatus">Ready</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Distance:</span>
                        <span class="info-value" id="distanceInfo">--</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Travel Time:</span>
                        <span class="info-value" id="timeInfo">--</span>
                    </div>
                </div>
                
                <div class="directions-panel" id="directionsPanel">
                    <div class="directions-header">
                        <div class="directions-title">Route to Café IYAH</div>
                        <button class="map-btn" id="closeDirections" title="Close Directions" style="width: 35px; height: 35px; font-size: 1rem;">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="route-summary">
                        <div class="route-info">
                            <div class="route-distance">
                                <i class="fas fa-road"></i>
                                <span id="routeDistance">--</span>
                            </div>
                            <div class="route-time">
                                <i class="fas fa-clock"></i>
                                <span id="routeTime">--</span>
                            </div>
                        </div>
                    </div>
                    <div class="directions-steps" id="directionsSteps">
                        <!-- Directions steps will be inserted here -->
                    </div>
                </div>
                
                <div id="statusMessage" class="status-message"></div>
            </div>
            
            <div class="section">
                <h2><i class="fas fa-info-circle"></i> Contact & Information</h2>
                
                <div class="contact-info">
                    <div class="contact-item" id="contactPhone">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Phone Number</h3>
                            <p>0969 370 9061</p>
                        </div>
                    </div>
                    
                    <div class="contact-item" id="contactEmail">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Email Address</h3>
                            <p>hello@cafeiyah.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item" id="openWaze">
                        <div class="contact-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Open in Waze</h3>
                            <p>Navigation app</p>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <a href="https://www.facebook.com/cafeiyah" class="social-link facebook" target="_blank" id="socialFb">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="cafe-highlight">
                <h3>Visit Café IYAH Today</h3>
                <p>Enjoy our premium beverages with stunning views of Antipolo</p>
                <div class="hours">
                    <div class="hour-item">
                        <span>Mon-Fri:</span>
                        <span>7AM - 10PM</span>
                    </div>
                    <div class="hour-item">
                        <span>Saturday:</span>
                        <span>8AM - 11PM</span>
                    </div>
                    <div class="hour-item">
                        <span>Sunday:</span>
                        <span>8AM - 9PM</span>
                    </div>
                    <div class="hour-item">
                        <span>Holidays:</span>
                        <span>9AM - 8PM</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script>
        // Updated exact location coordinates
        const cafeLat = 14.570371679661777;
        const cafeLng = 121.17097452372934;
        
        // Initialize the map with Café IYAH exact location
        const map = L.map('map').setView([cafeLat, cafeLng], 16);
        
        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Custom coffee icon for the café
        const coffeeIcon = L.divIcon({
            className: 'coffee-marker',
            html: '<div style="background: #8b5a2b; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; box-shadow: 0 3px 10px rgba(0,0,0,0.3); border: 3px solid white;"><i class="fas fa-coffee"></i></div>',
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });
        
        // Add marker for Café IYAH at exact location
        const cafeMarker = L.marker([cafeLat, cafeLng], {icon: coffeeIcon}).addTo(map)
            .bindPopup(`
                <div class="cafe-popup">
                    <h3>CAFÉ IYAH</h3>
                    <p>Your perfect coffee destination in Antipolo</p>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        4.5 (128 reviews)
                    </div>
                    <button class="btn btn-primary" onclick="startDirectionsFromPopup()" style="padding: 8px 15px; font-size: 0.9rem; margin-top: 10px;">
                        <i class="fas fa-directions"></i> Get Directions
                    </button>
                </div>
            `)
            .openPopup();
        
        // Routing control
        let routingControl = null;
        
        // User location marker
        let userMarker = null;
        let userLocationCircle = null;
        
        // DOM elements
        const useLocationBtn = document.getElementById('useLocation');
        const setStartPointBtn = document.getElementById('setStartPoint');
        const shareLocationBtn = document.getElementById('shareLocation');
        const mapLocateBtn = document.getElementById('mapLocate');
        const mapDirectionsBtn = document.getElementById('mapDirections');
        const mapResetBtn = document.getElementById('mapReset');
        const headerDirectionsBtn = document.getElementById('headerDirections');
        const headerCallBtn = document.getElementById('headerCall');
        const statusMessage = document.getElementById('statusMessage');
        const locationStatus = document.getElementById('locationStatus');
        const distanceInfo = document.getElementById('distanceInfo');
        const timeInfo = document.getElementById('timeInfo');
        const directionsPanel = document.getElementById('directionsPanel');
        const directionsSteps = document.getElementById('directionsSteps');
        const routeDistance = document.getElementById('routeDistance');
        const routeTime = document.getElementById('routeTime');
        const closeDirections = document.getElementById('closeDirections');
        const openWazeBtn = document.getElementById('openWaze');
        const contactPhone = document.getElementById('contactPhone');
        const contactEmail = document.getElementById('contactEmail');
        const socialFb = document.getElementById('socialFb');

        // Close directions panel
        closeDirections.addEventListener('click', function() {
            directionsPanel.style.display = 'none';
        });

        // Use My Location function - FIXED
        function useMyLocation() {
            if (!navigator.geolocation) {
                showStatus('Geolocation is not supported by this browser.', 'error');
                return;
            }
            
            showStatus('Locating your position...', 'info');
            locationStatus.textContent = 'Locating...';
            
            // Show loading state
            const originalText = useLocationBtn.innerHTML;
            useLocationBtn.innerHTML = '<div class="location-loading"></div> Locating...';
            useLocationBtn.disabled = true;
            
            // Remove pulse animation once clicked
            useLocationBtn.classList.remove('btn-pulse');
            mapLocateBtn.classList.add('active');
            
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;
                    
                    // Remove previous user location markers
                    if (userMarker) {
                        map.removeLayer(userMarker);
                    }
                    if (userLocationCircle) {
                        map.removeLayer(userLocationCircle);
                    }
                    
                    // Custom icon for user location
                    const userIcon = L.divIcon({
                        className: 'user-marker',
                        html: '<div style="background: #1a73e8; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; box-shadow: 0 3px 10px rgba(0,0,0,0.3); border: 3px solid white;"><i class="fas fa-user"></i></div>',
                        iconSize: [30, 30],
                        iconAnchor: [15, 30]
                    });
                    
                    // Add user location marker
                    userMarker = L.marker([userLat, userLng], {icon: userIcon}).addTo(map)
                        .bindPopup('<b>Your Location</b><br>You are here')
                        .openPopup();
                    
                    // Add accuracy circle
                    userLocationCircle = L.circle([userLat, userLng], {
                        color: '#1a73e8',
                        fillColor: '#1a73e8',
                        fillOpacity: 0.1,
                        radius: position.coords.accuracy
                    }).addTo(map);
                    
                    // Fit map to show both locations
                    const group = new L.featureGroup([cafeMarker, userMarker]);
                    map.fitBounds(group.getBounds().pad(0.1));
                    
                    // Calculate distance
                    const distance = calculateDistance(userLat, userLng, cafeLat, cafeLng);
                    distanceInfo.textContent = `${distance.toFixed(2)} km`;
                    
                    locationStatus.textContent = 'Location Found';
                    showStatus(`Your location found! You are ${distance.toFixed(2)} km from Café IYAH`, 'success');
                    
                    // Restore button state
                    useLocationBtn.innerHTML = originalText;
                    useLocationBtn.disabled = false;
                    
                    // Auto-generate directions if user is far from café
                    if (distance > 0.5) {
                        setTimeout(() => {
                            startDirections(userLat, userLng);
                        }, 1500);
                    }
                },
                function(error) {
                    let errorMsg = "Unable to retrieve your location. ";
                    
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMsg += "Location access was denied. Please enable location permissions in your browser settings.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMsg += "Location information is currently unavailable.";
                            break;
                        case error.TIMEOUT:
                            errorMsg += "Location request timed out. Please try again.";
                            break;
                        default:
                            errorMsg += "An unknown error occurred.";
                    }
                    
                    locationStatus.textContent = 'Location Error';
                    showStatus(errorMsg, 'error');
                    
                    // Restore button state
                    useLocationBtn.innerHTML = originalText;
                    useLocationBtn.disabled = false;
                    
                    // Restore pulse animation if location failed
                    useLocationBtn.classList.add('btn-pulse');
                    mapLocateBtn.classList.remove('active');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                }
            );
        }

        // Use My Location button - FIXED EVENT LISTENERS
        useLocationBtn.addEventListener('click', useMyLocation);
        mapLocateBtn.addEventListener('click', useMyLocation);
        
        // Start Directions function with proper road routing and coffee theme colors
        function startDirections(startLat, startLng) {
            // Remove existing routing control
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }
            
            // Create new routing control with OSRM (Open Source Routing Machine)
            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(startLat, startLng),
                    L.latLng(cafeLat, cafeLng)
                ],
                router: L.Routing.osrmv1({
                    serviceUrl: 'https://router.project-osrm.org/route/v1'
                }),
                routeWhileDragging: false,
                showAlternatives: false,
                fitSelectedRoutes: true,
                show: false, // Hide the default instructions panel
                lineOptions: {
                    styles: [
                        {
                            color: '#d4b896', // Light coffee outline
                            opacity: 0.8,
                            weight: 8
                        },
                        {
                            color: '#8b5a2b', // Dark coffee main route
                            opacity: 0.9,
                            weight: 6
                        }
                    ],
                    addWaypoints: false,
                    extendToWaypoints: true,
                    missingRouteTolerance: 1
                },
                createMarker: function(i, waypoint, n) {
                    if (i === 0) {
                        // Start point marker
                        return L.marker(waypoint.latLng, {
                            icon: L.divIcon({
                                className: 'start-marker',
                                html: '<div style="background: #2d7d32; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; box-shadow: 0 3px 10px rgba(0,0,0,0.3); border: 3px solid white;"><i class="fas fa-flag"></i></div>',
                                iconSize: [30, 30],
                                iconAnchor: [15, 30]
                            })
                        });
                    } else if (i === n - 1) {
                        // Destination marker (café)
                        return L.marker(waypoint.latLng, {
                            icon: coffeeIcon
                        });
                    }
                    return null;
                }
            }).addTo(map);
            
            // Listen for route found event
            routingControl.on('routesfound', function(e) {
                const routes = e.routes;
                const route = routes[0];
                
                // Update distance and time information
                const distance = (route.summary.totalDistance / 1000).toFixed(2);
                const time = Math.round(route.summary.totalTime / 60);
                
                distanceInfo.textContent = `${distance} km`;
                timeInfo.textContent = `${time} mins`;
                routeDistance.textContent = `${distance} km`;
                routeTime.textContent = `${time} minutes`;
                
                // Show directions panel
                directionsPanel.style.display = 'block';
                
                // Clear previous steps
                directionsSteps.innerHTML = '';
                
                // Add steps to directions panel
                route.instructions.forEach((instruction, index) => {
                    const stepElement = document.createElement('div');
                    stepElement.className = 'directions-step';
                    
                    // Get direction icon based on maneuver type
                    const directionIcon = getDirectionIcon(instruction.type, instruction.modifier);
                    
                    stepElement.innerHTML = `
                        <div class="step-number">${index + 1}</div>
                        <div class="step-content">
                            <div class="step-text">
                                <i class="${directionIcon}" style="margin-right: 8px; color: #666;"></i>
                                ${instruction.text}
                            </div>
                            <div class="step-distance">${(instruction.distance / 1000).toFixed(2)} km</div>
                        </div>
                    `;
                    
                    directionsSteps.appendChild(stepElement);
                });
                
                locationStatus.textContent = 'Route Found';
                showStatus(`Route calculated! Estimated travel time: ${time} minutes`, 'success');
                mapDirectionsBtn.classList.add('active');
            });
            
            // Show directions panel
            directionsPanel.style.display = 'block';
            locationStatus.textContent = 'Calculating Route...';
            showStatus('Calculating the best route to Café IYAH...', 'info');
        }
        
        // Helper function to get direction icons
        function getDirectionIcon(type, modifier) {
            const icons = {
                'Head': 'fas fa-arrow-up',
                'Continue': 'fas fa-arrow-up',
                'Turn': {
                    'left': 'fas fa-arrow-turn-up-left',
                    'right': 'fas fa-arrow-turn-up-right',
                    'sharp left': 'fas fa-arrow-turn-down-left',
                    'sharp right': 'fas fa-arrow-turn-down-right',
                    'slight left': 'fas fa-arrow-turn-up-left',
                    'slight right': 'fas fa-arrow-turn-up-right'
                },
                'Roundabout': 'fas fa-undo',
                'Rotary': 'fas fa-sync',
                'Merge': 'fas fa-arrow-right-arrow-left',
                'Depart': 'fas fa-flag-checkered',
                'Arrive': 'fas fa-flag-checkered',
                'Fork': 'fas fa-code-fork',
                'Exit': 'fas fa-sign-out-alt'
            };
            
            if (type === 'Turn' && modifier && icons[type][modifier]) {
                return icons[type][modifier];
            }
            
            return icons[type] || 'fas fa-arrow-up';
        }
        
        // Set Start Point / Get Directions button
        setStartPointBtn.addEventListener('click', function() {
            showStatus('Click anywhere on the map to set your starting point', 'info');
            mapDirectionsBtn.classList.add('active');
            
            // Change cursor to indicate selection mode
            map.getContainer().style.cursor = 'crosshair';
            
            // Create a temporary event listener for map click
            const setStartHandler = function(e) {
                const startLat = e.latlng.lat;
                const startLng = e.latlng.lng;
                
                // Start directions from selected point
                startDirections(startLat, startLng);
                
                // Reset cursor
                map.getContainer().style.cursor = '';
                
                // Remove the event listener
                map.off('click', setStartHandler);
            };
            
            map.on('click', setStartHandler);
        });
        
        // Map directions button
        mapDirectionsBtn.addEventListener('click', function() {
            setStartPointBtn.click();
        });
        
        // Header directions button
        headerDirectionsBtn.addEventListener('click', function() {
            setStartPointBtn.click();
        });
        
        // Global function for popup button
        window.startDirectionsFromPopup = function() {
            if (userMarker) {
                // Use current user location if available
                const userLatLng = userMarker.getLatLng();
                startDirections(userLatLng.lat, userLatLng.lng);
            } else {
                // Otherwise, prompt for start point
                setStartPointBtn.click();
            }
        };
        
        // Share Location button
        shareLocationBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'CAFÉ IYAH Location',
                    text: 'Check out CAFÉ IYAH in Antipolo, Rizal - Your perfect coffee destination',
                    url: `https://maps.google.com/?q=${cafeLat},${cafeLng}`
                })
                .then(() => showStatus('Location shared successfully!', 'success'))
                .catch(error => {
                    console.error('Error sharing:', error);
                    copyToClipboard(`https://maps.google.com/?q=${cafeLat},${cafeLng}`, 'Location link');
                });
            } else {
                // Fallback: copy to clipboard
                copyToClipboard(`https://maps.google.com/?q=${cafeLat},${cafeLng}`, 'Location link');
            }
        });
        
        // Reset View button
        function resetMapView() {
            map.setView([cafeLat, cafeLng], 16);
            cafeMarker.openPopup();
            
            // Remove user location markers
            if (userMarker) {
                map.removeLayer(userMarker);
                userMarker = null;
            }
            if (userLocationCircle) {
                map.removeLayer(userLocationCircle);
                userLocationCircle = null;
            }
            
            // Remove routing control
            if (routingControl) {
                map.removeControl(routingControl);
                routingControl = null;
            }
            
            // Hide directions panel
            directionsPanel.style.display = 'none';
            
            // Reset status
            locationStatus.textContent = 'Ready';
            distanceInfo.textContent = '--';
            timeInfo.textContent = '--';
            
            // Restore pulse animation
            useLocationBtn.classList.add('btn-pulse');
            mapLocateBtn.classList.remove('active');
            mapDirectionsBtn.classList.remove('active');
            
            showStatus('Map view reset to Café IYAH location', 'success');
        }
        
        mapResetBtn.addEventListener('click', resetMapView);
        
        // Header call button - Updated with correct phone number
        headerCallBtn.addEventListener('click', function() {
            window.open('tel:09693709061');
            showStatus('Calling Café IYAH...', 'info');
        });
        
        // Open in Waze - Updated with exact coordinates
        openWazeBtn.addEventListener('click', function() {
            showStatus('Opening Waze navigation...', 'info');
            
            // Waze deeplink
            const wazeUrl = `https://www.waze.com/ul?ll=${cafeLat},${cafeLng}&navigate=yes`;
            
            // Try to open Waze app, fallback to website
            setTimeout(() => {
                window.open(wazeUrl, '_blank');
                showStatus('Waze is now open with directions to Café IYAH', 'success');
            }, 1000);
        });
        
        // Contact Phone - Updated with correct phone number
        contactPhone.addEventListener('click', function() {
            copyToClipboard('09693709061', 'Phone number');
        });
        
        // Contact Email
        contactEmail.addEventListener('click', function() {
            copyToClipboard('hello@cafeiyah.com', 'Email address');
        });
        
        // Helper function to calculate distance between two coordinates
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = 
                Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }
        
        // Helper function to show status messages
        function showStatus(message, type) {
            statusMessage.textContent = message;
            statusMessage.className = 'status-message ' + type;
            statusMessage.style.display = 'block';
            
            // Auto-hide success messages after 5 seconds
            if (type === 'success' || type === 'info') {
                setTimeout(() => {
                    statusMessage.style.display = 'none';
                }, 5000);
            }
        }
        
        // Helper function to copy text to clipboard
        function copyToClipboard(text, description) {
            navigator.clipboard.writeText(text).then(
                function() {
                    showStatus(`${description} copied to clipboard!`, 'success');
                },
                function() {
                    // Fallback for older browsers
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        showStatus(`${description} copied to clipboard!`, 'success');
                    } catch (err) {
                        showStatus('Failed to copy to clipboard', 'error');
                    }
                    document.body.removeChild(textArea);
                }
            );
        }
    </script>
</body>
</html>