<<<<<<< HEAD
# Younic Home - Dynamic Mini Hostel Management System

Younic Home is a dynamic Laravel-based hostel management system designed for customer-side hostel operations with an admin panel. The system allows customers to register, book seats, request seat changes, pay rent, apply for leave, request hostel exit, and receive notifications. Admin can manage branches, rooms, seats, bookings, payments, leave requests, exit requests, and announcements.

## Project Objective

The main objective of this project is to build a dynamic mini hostel management system where hostel customers can manage their hostel-related activities digitally and admin can control the full system from a centralized dashboard.

## Key Features

### Customer Features

- Customer registration with name, phone, NID, email, and password
- First-time seat booking system
- Seat booking payment for selected paid days
- Customer profile dashboard
- Seat change request system
- Rent and payment management
- Leave application system
- Exit application system
- Dynamic notification system
- No refund policy handling
- Announcement viewing

### Admin Features

- Admin dashboard
- Branch management
- Room management
- Seat management
- Booking request approval/rejection
- Seat change request approval/rejection
- Payment approval/rejection
- Leave request approval/rejection
- Exit request approval/rejection
- Announcement management
- Dynamic customer notification generation

## Business Rules

### No Refund Policy

The company does not provide refunds.

If a customer pays for multiple days but leaves early, the unused paid amount is not refundable.

Example:

- Customer paid 5000 BDT for 5 days
- Customer stayed only 1 day
- Remaining unused value is not refunded
- Refund amount = 0 BDT

### Seat Change Policy

Customers can change their seat after booking.

If the new seat is more expensive:

- Customer must pay the extra amount
- If the payable amount is less than 100 BDT, minimum payable amount will be 100 BDT

If the new seat is cheaper:

- No refund will be given
- Extra balance will be converted into extra stay days
- If the remaining balance is short by 100 BDT or less to complete one extra day, customer must pay that shortage to get the extra day

## Technology Used

- Laravel
- PHP
- MySQL
- Blade Template Engine
- Tailwind CSS
- Laravel Breeze Authentication
- JavaScript
- XAMPP
- Composer
- Node.js
- NPM

## User Roles

### Admin

Admin can manage the full hostel system.

Default admin login:

```text
Email: admin@younic.com
Password: password
=======
# hostel_management_system
>>>>>>> c548726dc5a48921bbb55c9e07825bbdd6e6d334
