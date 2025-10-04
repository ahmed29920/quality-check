# Quality Check API Documentation

## Base URL
```
http://your-domain.com/api/v1
```

## Categories API

### Get All Categories
```
GET /categories
```

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 15, max: 50)

**Response:**
```json
{
    "success": true,
    "message": "Categories retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": {
                "en": "English Name",
                "ar": "Arabic Name"
            },
            "description": {
                "en": "English Description",
                "ar": "Arabic Description"
            },
            "slug": "category-slug",
            "image_url": "path/to/image.jpg",
            "is_active": true,
            "has_pricable_services": true,
            "monthly_subscription_price": 29.99,
            "yearly_subscription_price": 299.99,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "questions_count": 15,
            "services_count": 5
        }
    ],
    "meta": {
        "total": 10,
        "current_page": 1,
        "per_page": 15,
        "last_page": 1
    }
}
```

### Get Single Category
```
GET /categories/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Category retrieved successfully",
    "data": {
        "category": {
            "id": 1,
            "name": {
                "en": "English Name",
                "ar": "Arabic Name"
            },
            "description": {
                "en": "English Description",
                "ar": "Arabic Description"
            },
            "slug": "category-slug",
            "image_url": "path/to/image.jpg",
            "is_active": true,
            "has_pricable_services": true,
            "monthly_subscription_price": 29.99,
            "yearly_subscription_price": 299.99,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "questions_count": 15,
            "services_count": 5
        },
        "statistics": {
            "total_questions": 15,
            "active_questions": 12,
            "total_score": 150,
            "questions_with_attachments": 3
        }
    }
}
```

## Services API

### Get All Services
```
GET /services
```

**Query Parameters:**
- `category_id` (optional): Filter by category ID
- `is_active` (optional): Filter by active status (true/false)
- `is_pricable` (optional): Filter by pricable status (true/false)
- `min_price` (optional): Minimum price filter
- `max_price` (optional): Maximum price filter
- `per_page` (optional): Number of items per page (default: 15)

**Response:**
```json
{
    "success": true,
    "message": "Services retrieved successfully",
    "data": [
        {
            "id": 1,
            "name": {
                "en": "Service Name EN",
                "ar": "Service Name AR"
            },
            "description": {
                "en": "Service Description EN",
                "ar": "Service Description AR"
            },
            "slug": "service-slug",
            "image_url": "path/to/image.jpg",
            "price": 99.99,
            "duration": 60,
            "is_active": true,
            "is_pricable": true,
            "category_id": 1,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "category": {
                "id": 1,
                "name": {
                    "en": "Category Name EN",
                    "ar": "Category Name AR"
                }
            },
            "questions_count": 10,
            "active_questions_count": 8
        }
    ],
    "meta": {
        "total": 25,
        "current_page": 1,
        "per_page": 15,
        "last_page": 2,
        "from": 1,
        "to": 15
    },
    "links": {
        "first": "http://your-domain.com/api/v1/services?page=1",
        "last": "http://your-domain.com/api/v1/services?page=2",
        "prev": null,
        "next": "http://your-domain.com/api/v1/services?page=2"
    }
}
```

### Get Single Service
```
GET /services/{id}
```

**Response:**
```json
{
    "success": true,
    "message": "Service retrieved successfully",
    "data": {
        "service": {
            "id": 1,
            "name": {
                "en": "Service Name EN",
                "ar": "Service Name AR"
            },
            "description": {
                "en": "Service Description EN",
                "ar": "Service Description AR"
            },
            "slug": "service-slug",
            "image_url": "path/to/image.jpg",
            "price": 99.99,
            "duration": 60,
            "is_active": true,
            "is_pricable": true,
            "category_id": 1,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z",
            "category": {
                "id": 1,
                "name": {
                    "en": "Category Name EN",
                    "ar": "Category Name AR"
                }
            },
            "questions_count": 10,
            "active_questions_count": 8
        },
        "statistics": {
            "total_questions": 10,
            "active_questions": 8,
            "total_score": 100,
            "average_difficulty": 3.5
        },
        "related_services": [
            {
                "id": 2,
                "name": {
                    "en": "Related Service EN",
                    "ar": "Related Service AR"
                },
                "slug": "related-service-slug",
                "price": 79.99,
                "duration": 45,
                "image_url": "path/to/image.jpg"
            }
        ]
    }
}
```

## Error Response Format
```json
{
    "success": false,
    "message": "Error message",
    "error": "Detailed error information"
}
```

## HTTP Status Codes
- `200`: Success
- `404`: Resource not found
- `500`: Internal server error

## Examples

### Get all active services in a specific category
```
GET /api/v1/services?category_id=1&is_active=true
```

### Get services with price range
```
GET /api/v1/services?min_price=50&max_price=200
```

### Get services with custom pagination
```
GET /api/v1/services?per_page=20&page=2
```
