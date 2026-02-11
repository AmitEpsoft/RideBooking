<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/laravel/framework/actions">
        <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/laravel/framework">
        <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
    </a>
</p>

# Ride Booking Laravel Assessment

This project is a Laravel-based backend application that provides APIs for a simple ride-booking flow used by a mobile app.

A minimal admin panel is also included using Laravel Blade templates to view rides and ride details.

---

## Features

### Passenger APIs
- Create a ride request (pickup & destination coordinates)
- Approve a driver who has requested the ride
- Mark a ride as completed

### Driver APIs
- Send current latitude/longitude
- Fetch nearby pending ride requests within a given radius
- Request/claim a ride
- Mark a ride as completed

### Ride Completion Rule
A ride is fully completed only when:
- Passenger marks it completed  
AND  
- Driver marks it completed

### Admin Panel (Blade)
- View list of all rides
- View ride details:
  - Passenger info
  - Driver info
  - Pickup & destination coordinates
  - Status
  - Timestamps
  - Driver requests

### Swagger Documentation
- Swagger UI implemented using **L5 Swagger**
- All Controllers include `@OA\...` annotations

---

## Requirements

- PHP 8.1+
- Composer
- MySQL
- Laravel 10/11

---

## Installation

### 1) Clone the repository
```bash
git clone <your-repository-url>
cd ride-booking
