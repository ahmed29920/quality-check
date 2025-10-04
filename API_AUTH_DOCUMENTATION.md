# Quality Check API Authentication Documentation

## Base URL
```
http://your-domain.com/api
```

## Authentication Endpoints

### 1. Register User
```
POST /auth/register
```

**Request Body:**
```json
{
    "name": "John Doe",
    "phone": "+1234567890",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "User registered successfully. Please verify your phone number.",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "is_active": true,
            "phone_verified_at": null,
            "phone_verified_at": null,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "is_phone_verified": false,
            "is_email_verified": false
        },
        "verification_code": "123456"
    }
}
```

### 2. Login User
```
POST /auth/login
```

**Request Body:**
```json
{
    "phone": "+1234567890",
    "password": "password123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "is_active": true,
            "phone_verified_at": "2023-01-01T00:00:00.000000Z",
            "phone_verified_at": null,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "is_phone_verified": true,
            "is_email_verified": false
        },
        "token": "1|abc123def456..."
    }
}
```

### 3. Verify Phone Number
```
POST /auth/verify-phone
```

**Request Body:**
```json
{
    "phone": "+1234567890",
    "code": "123456"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Phone number verified successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "phone": "+1234567890",
            "is_phone_verified": true
        }
    }
}
```

### 4. Resend Phone Verification Code
```
POST /auth/resend-phone-verification
```

**Request Body:**
```json
{
    "phone": "+1234567890"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Verification code sent successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "phone": "+1234567890"
        },
        "verification_code": "654321"
    }
}
```

### 5. Send Password Reset Email
```
POST /auth/send-password-reset
```

**Request Body:**
```json
{
    "email": "john@example.com"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Password reset code sent to your email",
    "reset_code": "789012"
}
```

### 6. Verify Reset Code
```
POST /auth/verify-reset-code
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "code": "789012"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Reset code is valid"
}
```

### 7. Reset Password
```
POST /auth/reset-password
```

**Request Body:**
```json
{
    "email": "john@example.com",
    "code": "789012",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Password reset successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890"
        }
    }
}
```

## Protected Endpoints (Require Authentication)

Include the token in the Authorization header:
```
Authorization: Bearer 1|abc123def456...
```

### 8. Logout
```
POST /auth/logout
```

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "Logged out successfully"
}
```

### 9. Change Password
```
POST /auth/change-password
```

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "current_password": "oldpassword123",
    "password": "newpassword123",
    "password_confirmation": "newpassword123"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Password changed successfully"
}
```

### 10. Update Profile
```
PUT /auth/profile
```

**Headers:**
```
Authorization: Bearer {token}
```

**Request Body:**
```json
{
    "name": "John Smith",
    "email": "johnsmith@example.com"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Profile updated successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Smith",
            "email": "johnsmith@example.com",
            "phone": "+1234567890",
            "is_active": true,
            "phone_verified_at": "2023-01-01T00:00:00.000000Z",
            "phone_verified_at": null,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T12:00:00.000000Z",
            "is_phone_verified": true,
            "is_email_verified": false
        }
    }
}
```

### 11. Get User Profile
```
GET /auth/me
```

**Headers:**
```
Authorization: Bearer {token}
```

**Response:**
```json
{
    "success": true,
    "message": "User profile retrieved successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "phone": "+1234567890",
            "is_active": true,
            "phone_verified_at": "2023-01-01T00:00:00.000000Z",
            "phone_verified_at": null,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "is_phone_verified": true,
            "is_email_verified": false
        }
    }
}
```

## Error Response Format
```json
{
    "success": false,
    "message": "Error message describing what went wrong"
}
```

## HTTP Status Codes
- `200`: Success
- `201`: Created (for registration)
- `400`: Bad Request (validation errors)
- `401`: Unauthorized (invalid credentials or token)
- `404`: Not Found
- `422`: Unprocessable Entity (validation errors)
- `500`: Internal Server Error

## Validation Rules

### Registration
- `name`: Required, string, max 255 characters
- `phone`: Required, string, unique, valid phone format
- `email`: Optional, email format, unique
- `password`: Required, string, minimum 8 characters, must match confirmation
- `password_confirmation`: Required, string, minimum 8 characters

### Login
- `phone`: Required, string, valid phone format
- `password`: Required, string

### Phone Verification
- `phone`: Required, string, valid phone format
- `code`: Required, string, exactly 6 digits

### Password Reset
- `email`: Required, valid email format
- `code`: Required, string, exactly 6 digits
- `password`: Required, string, minimum 8 characters, must match confirmation

### Profile Update
- `name`: Optional, string, max 255 characters
- `email`: Optional, email format, unique (excluding current user)

## Security Features
- Password hashing using Laravel's built-in hasher
- Sanctum tokens for API authentication
- Phone verification with 6-digit codes
- Email verification for password resets
- Rate limiting on sensitive endpoints
- Token expiration and revocation on logout

## Testing Notes
- Verification codes are returned in the response for testing purposes
- Remove verification codes from production responses
- All endpoints include proper error handling and validation
- Tokens are automatically managed by Laravel Sanctum
