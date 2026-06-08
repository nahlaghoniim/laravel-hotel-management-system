# Hotel Management System

## Overview

Hotel Management System is a full-stack web application built with Laravel for managing hotel operations through a centralized administrative dashboard.

The project is being developed in multiple phases. The current phase focuses on the administration and operational management side of the system, while the next phase will introduce the customer-facing website and online booking experience.

---

## Current Development Status

### Phase 1: Administration & Operations Dashboard (In Progress)

The first phase focuses on hotel management workflows, operational monitoring, and business analytics.

### Implemented Features

#### Authentication & Security

* Admin authentication system
* Protected admin area using Laravel guards and middleware
* Secure login and logout functionality

#### Dashboard & Analytics

* Administrative dashboard with operational metrics
* Occupied rooms tracking
* Available rooms tracking
* Upcoming arrivals overview
* Scheduled departures overview
* Active check-ins monitoring
* Occupancy rate calculation
* Daily revenue tracking
* Average Daily Rate (ADR)
* Revenue Per Available Room (RevPAR)
* CSV report generation
* Revenue and occupancy visualizations

#### Room Type Management

* Full CRUD operations
* Room type pricing management
* Detailed room descriptions
* Multiple image gallery support
* Cover image functionality
* Image upload and storage management

#### Room Management

* Full CRUD operations
* Room assignment to room types
* Availability management
* Hotel inventory organization

#### Customer Management

* Full CRUD operations
* Customer profile management
* Contact information tracking

#### Department Management

* Full CRUD operations
* Department organization structure
* Administrative categorization

#### Staff Management

* Full CRUD operations
* Staff information management
* Department assignment support

#### Booking Management

* Booking model and business logic
* Reservation tracking
* Booking status management

#### Check-In Management

* Guest check-in tracking
* Active stay monitoring
* Operational dashboard integration

---

## Technology Stack

### Backend

* PHP 8+
* Laravel 11
* MySQL

### Frontend

* Blade Templates
* HTML5
* CSS3
* JavaScript
* Chart.js

### Development Tools

* Composer
* Vite
* PHPUnit

---

## Project Architecture

The application follows Laravel best practices and includes:

* MVC Architecture
* Resource Controllers
* Eloquent ORM Relationships
* Form Validation
* Route Protection
* Middleware-Based Authentication
* Database Migrations
* File Upload Management
* Dashboard Analytics Services

---

## Database Entities

### Core Entities

* Admin
* Customer
* Staff
* Department
* Room Type
* Room
* Room Type Image
* Booking
* Check-In
* User

### Relationships

* Room Types have many Rooms
* Room Types have many Images
* Rooms belong to Room Types
* Staff belong to Departments
* Customers have Bookings
* Rooms have Bookings
* Bookings are linked to Check-Ins

---

## Upcoming Features

### Phase 2: Customer Website & Online Booking Platform

The next phase of development will focus on the public-facing hotel website.

#### Planned Features

##### Customer Website

* Modern hotel landing page
* Responsive design
* Room browsing experience
* Room type galleries
* Hotel information pages
* Contact and inquiry forms

##### Online Booking System

* Real-time room availability
* Online reservation workflow
* Booking confirmation process
* Guest reservation management
* Booking history

##### Customer Accounts

* Customer registration
* Secure authentication
* Profile management
* Reservation tracking
* Booking modifications

##### Payments

* Online payment integration
* Payment status tracking
* Invoice generation
* Transaction history

##### Guest Experience

* Booking confirmation emails
* Reservation status notifications
* Guest dashboard
* Self-service booking management

---

## Future Enhancements

* Housekeeping Management
* Maintenance Requests
* Role & Permission Management
* Advanced Reporting
* Multi-Hotel Support
* Revenue Forecasting
* API Integration
* Mobile Application Support

---

## Installation

```bash
git clone <repository-url>

cd hotel-management-system

composer install

npm install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan storage:link

npm run build

php artisan serve
```

---

## Project Goal

The goal of this project is to build a complete hotel management platform that supports both hotel administrators and guests through a modern, scalable, and maintainable Laravel application.

The system is being developed incrementally, beginning with operational management and analytics, followed by customer-facing booking and reservation capabilities.
