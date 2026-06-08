# Security Enhancements Report

## Project

Blog CRUD Application using PHP and MySQL

## Security Features Implemented

### 1. Password Hashing

Passwords are securely stored using PHP's password_hash() function instead of plain text.

### 2. Prepared Statements

Prepared statements have been implemented in Login, Add Post, Edit Post, and Delete Post operations to prevent SQL Injection attacks.

### 3. Form Validation

Both client-side and server-side validation have been added to ensure required fields are not left empty.

### 4. User Roles

A role column has been added to the users table. Roles include:

* Admin
* User

### 5. Access Control

Only users with the Admin role can delete blog posts.

## Outcome

The application is now more secure against common web vulnerabilities such as SQL Injection, unauthorized access, and insecure password storage.
