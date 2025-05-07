# Software Requirements Specification

## Table of Contents
- [1. Introduction](#1-introduction)
  - [1.1 Purpose](#11-purpose)
  - [1.2 Document Conventions](#12-document-conventions)
  - [1.3 Current Implementation](#13-current-implementation)
- [2. Overall Description](#2-overall-description)
  - [2.1 Product Perspective](#21-product-perspective)
  - [2.2 Product Functions](#22-product-functions)
  - [2.3 User Classes and Characteristics](#23-user-classes-and-characteristics)
  - [2.4 Operating Environment](#24-operating-environment)
- [3. Functional Requirements](#3-functional-requirements)
  - [3.1 User Authentication System](#31-user-authentication-system)
    - [3.1.1 Login](#311-login)
    - [3.1.2 Registration](#312-registration)
    - [3.1.3 Profile Management](#313-profile-management)
    - [3.1.4 Logout](#314-logout)
  - [3.2 API Endpoints](#32-api-endpoints)
  - [3.3 Cart System](#33-cart-system)
  - [3.4 Destination Management](#34-destination-management)
    - [3.4.1 Destinations List](#341-destinations-list)
    - [3.4.2 Destination Detail](#342-destination-detail)
  - [3.5 Package Management](#35-package-management)
    - [3.5.1 Package Listing](#351-package-listing)
    - [3.5.2 Package Features](#352-package-features)
    - [3.5.3 Database Relations](#353-database-relations)
  - [3.6 Package Booking System](#36-package-booking-system)
  - [3.7 Admin Dashboard](#37-admin-dashboard)
  - [3.8 Booking Management](#38-booking-management)
  - [3.9 Reporting and Analytics](#39-reporting-and-analytics)
  - [3.10 Database Requirements](#310-database-requirements)
    - [3.10.1 Core Entities](#3101-core-entities)
      - [3.10.1.1 Users Table](#31011-users-table)
      - [3.10.1.2 Destinations Table](#31012-destinations-table)
      - [3.10.1.3 Packages Table](#31013-packages-table)
      - [3.10.1.4 Bookings Table](#31014-bookings-table)
    - [3.10.2 Database Configuration](#3102-database-configuration)
    - [3.10.3 Security Considerations](#3103-security-considerations)
- [4. Non-Functional Requirements](#4-non-functional-requirements)
  - [4.1 Performance](#41-performance)
  - [4.2 Security](#42-security)
    - [4.2.1 Security Architecture](#421-security-architecture)
  - [4.3 Usability](#43-usability)
  - [4.4 Maintainability](#44-maintainability)
- [5. User Interface Requirements](#5-user-interface-requirements)
  - [5.1 Home Page Components](#51-home-page-components)
  - [5.2 Performance Requirements](#52-performance-requirements)
  - [5.3 Browser Compatibility](#53-browser-compatibility)
  - [5.4 Client-Side Interactions](#54-client-side-interactions)
    - [5.4.1 UI Enhancements](#541-ui-enhancements)
    - [5.4.2 Technical Specifications](#542-technical-specifications)
    - [5.4.3 Accessibility](#543-accessibility)
    - [5.4.4 Error Handling](#544-error-handling)
  - [5.5 Template System Architecture](#55-template-system-architecture)
    - [5.5.1 Header Template](#551-header-template)
    - [5.5.2 Footer Template](#552-footer-template)
    - [5.5.3 Functions File](#553-functions-file)
    - [5.5.4 Template Requirements](#554-template-requirements)
    - [5.5.5 Chatbot Integration](#555-chatbot-integration)
      - [5.5.5.1 Header Integration](#5551-header-integration)
      - [5.5.5.2 PHP Backend Integration](#5552-php-backend-integration)
      - [5.5.5.3 Technical Requirements](#5553-technical-requirements)
      - [5.5.5.4 UI Components](#5554-ui-components)
- [6. API Specifications](#6-api-specifications)
  - [6.1 Cart Management API](#61-cart-management-api)
  - [6.2 Packages API](#62-packages-api)
  - [6.3 Authentication API](#63-authentication-api)
- [7. Chatbot System Requirements](#7-chatbot-system-requirements)
  - [7.1 Overview](#71-overview)
  - [7.2 Functional Requirements](#72-functional-requirements)
    - [7.2.1 Chat Interface](#721-chat-interface)
    - [7.2.2 AI Integration](#722-ai-integration)
    - [7.2.3 Package Recommendation System](#723-package-recommendation-system)
    - [7.2.4 Authentication Integration](#724-authentication-integration)
    - [7.2.5 Conversation Management](#725-conversation-management)
    - [7.2.6 NLP Capabilities](#726-nlp-capabilities)
    - [7.2.7 Business Logic Integration](#727-business-logic-integration)
  - [7.3 Non-Functional Requirements](#73-non-functional-requirements)
    - [7.3.1 Performance](#731-performance)
    - [7.3.2 Security](#732-security)
    - [7.3.3 UI/UX](#733-uiux)
  - [7.4 Technical Specifications](#74-technical-specifications)
    - [7.4.1 Frontend Technologies](#741-frontend-technologies)
    - [7.4.2 Backend Integration](#742-backend-integration)
    - [7.4.3 External Services](#743-external-services)
- [8. Glossary](#8-glossary)
- [9. Assumptions and Dependencies](#9-assumptions-and-dependencies)
- [10. Appendices](#10-appendices)
  - [10.1 Appendix A: System Architecture Diagram](#101-appendix-a-system-architecture-diagram)
  - [10.2 Appendix B: Database Schema](#102-appendix-b-database-schema)

## 1. Introduction

### 1.1 Purpose

The Travelminds Travel Agency web application provides customers with:

* Destination browsing and search
* Package booking system
* User accounts and authentication
* Shopping cart functionality
* Admin dashboard for management

### 1.2 Document Conventions

* \[F] = Functional requirement
* \[NF] = Non-functional requirement
* Priority: High/Medium/Low

### 1.3 Current Implementation

* PHP 7.4+ backend
* MySQL database
* Bootstrap 5 frontend
* Responsive design
* PDO for database access

## 2. Overall Description

### 2.1 Product Perspective

The Travelminds Travel Agency web application is a web-based system, accessible through a web browser, built using PHP 7.4+ and MySQL.

### 2.2 Product Functions

* User registration and login
* Destination browsing and search
* Package booking system
* Shopping cart functionality
* Admin dashboard for management
* Payment processing
* Booking management
* Reporting and analytics

### 2.3 User Classes and Characteristics

* Customers: individuals booking travel arrangements
* Travel agents: managing bookings and customer relationships
* Administrators: managing system settings and reports

### 2.4 Operating Environment

* Web-based application, accessible through a web browser
* Compatible with major browsers (Chrome, Firefox, Safari, Edge)
* Responsive design for mobile devices

## 3. Functional Requirements

### 3.1 User Authentication System \[F, High]

#### 3.1.1 Login (`login.php`)

* **Features**:
  - Username/email and password authentication
  - Separate admin/user login flows
  - Session-based authentication
  - Redirect handling for protected pages
* **Security**:
  - Password hashing with PHP password\_hash()
  - CSRF protection (implied by session)
  - Input sanitization

#### 3.1.2 Registration (`register.php`)

* **Fields**:
  - Username (required, unique)
  - Email (required, validated)
  - Password (min 8 chars, confirmation)
  - First/Last name (optional)
* **Validation**:
  - Duplicate username/email check
  - Email format validation
  - Password strength requirements

#### 3.1.3 Profile Management (`profile.php`)

* **Features**:
  - View personal information
  - Booking history
  - Current cart contents
* **Data**:
  - Joins with packages table
  - Session-based cart integration

#### 3.1.4 Logout (`logout.php`)

* **Process**:
  - Session destruction
  - Clean redirect
  - Success message display

### 3.2 API Endpoints \[F, High]

* Cart management (`api_add_to_cart.php`)
* Package data retrieval (`api_get_packages.php`)
* Authentication status (`get_login_status.php`)

### 3.3 Cart System \[F, High]

* **Features**:
  - Session-based cart storage
  - Dynamic AJAX updates every 5s
  - Booking modal with date/party size inputs
  - Webhook integration (Make.com) for booking notifications
* **Security**:
  - User authentication required
  - Input validation:
    - Minimum 1 person per package
    - Future date validation
  - Price calculation from database

### 3.4 Destination Management \[F, Medium]

#### 3.4.1 Destinations List (`destinations.php`)

- Search by name/country/description
- Dynamic price ranges (MIN from packages)
- Hero section with search bar
- Responsive card grid layout

#### 3.4.2 Destination Detail (`destination.php`)

- Alternate entry by ID or name
- Weather widget with Open-Meteo API
- Timezone-aware display
- Related packages:
  - Name/description matching
  - Price-sorted display
- Interactive booking system

### 3.5 Package Management \[F, High]

#### 3.5.1 Package Listing (`packages.php`)

- Dynamic filtering by destination
- Price sorting (low-high)
- Search by package name/description
- Pagination support

#### 3.5.2 Package Features

- Image gallery integration
- Detailed itinerary display
- Inclusion/exclusion lists
- Capacity indicators

#### 3.5.3 Database Relations

- Foreign key to destinations table
- Price validation constraints
- Availability tracking

### 3.6 Package Booking System \[F, High]

* Users can book packages
* Package details are stored in the MySQL database
* Booking details are stored in the system

### 3.7 Admin Dashboard for Management \[F, Medium]

* Administrators can view and manage bookings
* Administrators can update booking details
* Booking history is stored in the system

### 3.8 Booking Management \[F, Medium]

* Travel agents can view and manage bookings
* Travel agents can update booking details
* Booking history is stored in the system

### 3.9 Reporting and Analytics \[F, Low]

* Administrators can view reports on bookings and revenue
* Administrators can view analytics on user behavior

### 3.10 Database Requirements

#### 3.10.1 Core Entities \[F, Critical]

##### 3.10.1.1 Users Table

* **Purpose**: Manages system authentication and authorization
* **Columns**:
  - `id` (PK, Auto Increment)
  - `username` (Unique, Not Null)
  - `email` (Unique, Not Null)
  - `password_hash` (Not Null)
  - `role` (ENUM: user/admin)
  - `created_at` (Timestamp)

##### 3.10.1.2 Destinations Table

* **Purpose**: Stores travel destination information
* **Columns**:
  - `id` (PK, Auto Increment)
  - `name` (Not Null)
  - `description` (Text)
  - `image_url`
  - `price` (Decimal)
  - `country`

##### 3.10.1.3 Packages Table

* **Relationships**:
  - `destination_id` (FK to Destinations)
* **Columns**:
  - `id` (PK, Auto Increment)
  - `title` (Not Null)
  - `description` (Text)
  - `price` (Decimal)
  - `duration` (Days)
  - `status` (ENUM: active/inactive)

##### 3.10.1.4 Bookings Table

* **Relationships**:
  - `user_id` (FK to Users)
  - `package_id` (FK to Packages)
* **Columns**:
  - `id` (PK, Auto Increment)
  - `travel_date`
  - `number_of_people`
  - `status` (ENUM: pending/confirmed/cancelled)

#### 3.10.2 Database Configuration
- Database Type: MySQL
- Host: localhost
- Connection: PDO with exception handling
- Automatic Setup:
  - Creates database if not exists
  - Creates tables from SQL file if not exists
  - Verifies table creation
- Error Handling:
  - PDO exceptions caught and logged
  - Custom exceptions for setup failures

#### 3.10.3 Security Considerations
- Credentials stored in config file
- Password hashing required
- Prepared statements used for all queries
- Error messages sanitized before display

## 4. Non-Functional Requirements

### 4.1 Performance \[NF, High]

* The system responds to user input within 2 seconds
* The system can handle 100 concurrent users

### 4.2 Security \[NF, High]

* User data is encrypted and stored securely using PDO
* Passwords are encrypted and stored securely using PDO

#### 4.2.1 Security Architecture \[NF, Critical]

* **Session Management**:
  - Encrypted session cookies
  - Session fixation protection
  - Automatic timeout (30min)
* **Input Validation**:
  - SQL injection protection via PDO
  - XSS prevention with htmlspecialchars()
  - Type casting for numeric inputs
* **CORS Policy**:
  - Whitelisted origins (localhost:5173)
  - Credentials allowed
  - Preflight caching

### 4.3 Usability \[NF, Medium]

* The system is easy to use and navigate
* The system provides clear and concise error messages

### 4.4 Maintainability \[NF, Low]

* The system is easy to update and maintain
* The system provides clear and concise documentation

## 5. User Interface Requirements

### 5.1 Home Page Components \[F, High]

1. **Hero Section**:
   - Full-viewport image carousel
   - Auto-rotating slides (5s interval)
   - Caption overlay with:
     - Heading (H2)
     - Descriptive text
     - Primary CTA button
2. **Color Scheme**:
   - Primary: #2c3e50 (Dark Blue)
   - Secondary: #3498db (Blue)
   - Accent: #e74c3c (Red)
   - Defined in CSS custom properties
3. **Typography**:
   - Segoe UI system font stack
   - 1.6 line height for readability
4. **Navigation System**:
   - Fixed top navigation bar containing:
     - Brand logo
     - Core links: Destinations/Packages/About/Contact
     - User auth status (Login/Register/Account)
5. **Technical Implementation**:
   - Bootstrap 5 grid system
   - Font Awesome icons integration
   - Custom CSS for:
     - Carousel caption positioning
     - Responsive image handling
     - Mobile menu breakpoints
6. **Accessibility Features**:
   - ARIA labels for carousel controls
   - Semantic HTML5 markup
   - Keyboard-navigable carousel

### 5.2 Performance Requirements \[NF, Medium]

* First Contentful Paint < 1.5s
* Carousel images optimized as:
  - WebP format (85% quality)
  - Max-width 1920px
  - Lazy loading
* CDN-hosted assets (Bootstrap/Font Awesome)

### 5.3 Browser Compatibility

* Supported browsers:
  - Chrome (latest 3 versions)
  - Firefox ESR+
  - Safari 15+
  - Edge 90+

### 5.4 Client-Side Interactions \[F, Medium]

#### 5.4.1 UI Enhancements

1. **Dynamic Navigation**:
   - Navbar opacity changes on scroll (50px threshold)
   - Smooth scroll behavior for anchor links
   - Scroll-triggered fade animations for content sections
2. **Form Handling**:
   - Newsletter signup validation
   - Success/error toast notifications
   - Input auto-clear on successful submission
3. **Performance Features**:
   - Intersection Observer for:
     - Lazy loading images
     - Animation triggers
   - Scroll event debouncing

#### 5.4.2 Technical Specifications

* **Browser Support**:
  - ES6+ features (arrow functions, const/let)
  - Intersection Observer API
  - CSS Transitions
* **Dependencies**:
  - No external libraries (vanilla JS)
  - Bootstrap 5 CSS utilities
  - Font Awesome icons

#### 5.4.3 Accessibility

* Reduced motion detection
* Focus management after form submissions
* ARIA live regions for dynamic content updates

#### 5.4.4 Error Handling

* Network error detection in fetch calls
* Fallback for unsupported Intersection Observer
* Graceful degradation for older browsers

### 5.5 Template System Architecture

#### 5.5.1 Header Template (`header.php`) \[F, High]

* **Core Components**:
  - Responsive Bootstrap 5 navbar
  - Dynamic navigation links
  - Session-based user state display
  - Favicon and meta tags management
* **Features**:
  - Mobile-friendly hamburger menu
  - Active link highlighting
  - Conditional rendering for:
    - Logged-in users
    - Admin users
    - Guest users

#### 5.5.2 Footer Template (`footer.php`) \[F, Medium]

* **Structure**:
  - 3-column responsive layout
  - Company information
  - Quick links navigation
  - Contact information
* **Dynamic Elements**:
  - Copyright year auto-update
  - Social media links
  - Back-to-top button

#### 5.5.3 Functions File (`functions.php`) \[F, Critical]

* **Security Functions**:
  - Input sanitization
  - Password hashing
  - CSRF token generation
* **Utility Functions**:
  - Redirect with flash messages
  - Form validation helpers
  - Database connection handling
* **Template Helpers**:
  - Dynamic title generation
  - Active menu item detection
  - Error message display

#### 5.5.4 Template Requirements \[NF, High]

* **Performance**:
  - Minified assets loading
  - Critical CSS inlining
  - Deferred JS loading
* **Accessibility**:
  - ARIA landmarks
  - Skip navigation link
  - Color contrast compliance
* **Maintainability**:
  - Consistent indentation
  - PHP/HTML separation
  - Commented sections

#### 5.5.5 Chatbot Integration

##### 5.5.5.1 Header Integration
* **Implementation Location**: `header.php`
* **Features**:
  - Floating chat bubble interface
  - Persistent across all pages
  - Collapsible/expandable UI
  - Real-time status indicator

##### 5.5.5.2 PHP Backend Integration
* **Authentication Handlers**:
  - Session status verification
  - User context preservation
  - Login state management
  - Token validation

* **API Endpoints**:
  - `/api/chat/message` - Message handling
  - `/api/chat/history` - Chat history retrieval
  - `/api/chat/context` - Context management
  - `/api/chat/packages` - Package recommendations

* **Data Flow**:
  - Client-side state management
  - Server-side session handling
  - Real-time updates
  - Error handling and recovery

##### 5.5.5.3 Technical Requirements
* **Performance**:
  - Maximum response time: 1.5s
  - WebSocket connection stability
  - Memory efficient message storage
  - Optimized package queries

* **Security**:
  - Rate limiting implementation
  - Input sanitization
  - XSS prevention
  - CSRF protection

* **Integration Points**:
  - User authentication system
  - Package management system
  - Booking system
  - Session management

##### 5.5.5.4 UI Components
* **Chat Bubble**:
  - Fixed position overlay
  - Responsive design
  - Animation effects
  - Notification badges

* **Chat Interface**:
  - Message history display
  - Input field with validation
  - Package recommendation cards
  - Loading states and indicators

## 6. API Specifications

### 6.1 Cart Management API

**Endpoint**: `/php/api_add_to_cart.php`

**Method**: GET

**Parameters**:
* `add` (required): Package ID to add

**Success Response**:
```json
{
  "success": true,
  "message": "Item added to cart."
}
```

**Error Responses**:
```json
{
  "success": false,
  "message": "User not logged in."
}
{
  "success": false,
  "message": "Invalid request."
}
```

**Security**:
* Requires authenticated session
* CORS restricted to [http://localhost:5173](http://localhost:5173)
* Session-based cart storage

### 6.2 Packages API

**Endpoint**: `/php/api_get_packages.php`

**Method**: GET

**Response Format**:
```json
{
  "Destination Name": [
    {
      "id": 1,
      "title": "Package Name",
      "description": "Package description",
      "price": 999.99,
      "destination": "Destination Name"
    }
  ]
}
```

**Data Source**:
* JOIN between packages and destinations tables

### 6.3 Authentication API

**Endpoint**: `/php/get_login_status.php`

**Methods**: GET, OPTIONS

**Response**:
```json
{
  "isLoggedIn": true,
  "userId": 123
}
```

**Features**:
* Handles CORS preflight requests
* Returns null userId when not logged in

## 7. Chatbot System Requirements

### 7.1 Overview
The chatbot system provides an AI-powered travel assistant interface integrated with the main travel agency platform.

### 7.2 Functional Requirements

#### 7.2.1 Chat Interface
- Real-time message display
- Message formatting support (bold text, headings)
- Automatic scrolling to latest messages
- Loading state indicators
- User/bot message differentiation

#### 7.2.2 AI Integration
- Integration with Qwen2.5-1.5B-Instruct model
- Rate limiting (10 requests/minute)
- Response caching (1-hour TTL)
- Error handling and fallback responses

#### 7.2.3 Package Recommendation System
- Destination detection from user messages
- Package query detection
- Display of relevant travel packages
- Support for both specific destination and random package recommendations

#### 7.2.4 Authentication Integration
- Login status checking
- Secure session management
- Login redirect handling
- Protected booking actions

#### 7.2.5 Conversation Management
- Conversation state tracking
- Context preservation between sessions
- Multi-turn dialogue support
- Conversation history storage with TTL
- User preference learning

#### 7.2.6 NLP Capabilities
- Intent recognition for:
  - Package inquiries
  - Price comparisons
  - Booking assistance
  - Destination information
- Entity extraction for:
  - Dates and durations
  - Locations
  - Price ranges
  - Number of travelers
- Sentiment analysis for customer satisfaction monitoring

#### 7.2.7 Business Logic Integration
- Direct booking initiation from chat
- Real-time availability checking
- Price calculation and quotation
- Special offers and promotions integration

### 7.3 Non-Functional Requirements

#### 7.3.1 Performance
- Maximum response time: 2 seconds
- Cache hit ratio target: >80%
- Rate limit: 10 requests per minute per user

#### 7.3.2 Security
- Secure API token handling
- Session-based authentication
- CORS compliance
- Input sanitization

#### 7.3.3 UI/UX
- Responsive design
- Smooth animations
- Clear visual hierarchy
- Accessibility compliance

### 7.4 Technical Specifications

#### 7.4.1 Frontend Technologies
- React with TypeScript
- Framer Motion for animations
- Tailwind CSS for styling
- Context API for state management

#### 7.4.2 Backend Integration
- REST API endpoints
- PHP backend compatibility
- Session-based authentication
- JSON data format

#### 7.4.3 External Services
- Hugging Face API integration
- Environment variable configuration
- Error handling and logging

## 8. Glossary

* Customer: an individual booking travel arrangements
* Travel agent: an individual managing bookings and customer relationships
* Administrator: an individual managing system settings and reports

## 9. Assumptions and Dependencies

* The system assumes a stable internet connection for API calls and web requests.

## 10. Appendices

### 10.1 Appendix A: System Architecture Diagram

### 10.2 Appendix B: Database Schema