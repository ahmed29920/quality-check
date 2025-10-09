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

## Questions API

### Get Questions by Category
```
GET /questions/category/{id}
```

**Query Parameters:**
- `limit` (optional): Number of questions to retrieve (default: 15)

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "category_id": 1,
            "title": "What is your experience with this service?",
            "options": [
                "Less than 1 year",
                "1-3 years", 
                "3-5 years",
                "More than 5 years"
            ],
            "formatted_options": [
                {
                    "value": "A",
                    "text": "Less than 1 year",
                    "index": 0
                },
                {
                    "value": "B", 
                    "text": "1-3 years",
                    "index": 1
                }
            ],
            "allows_attachments": true,
            "requires_attachment": false,
            "score": 10,
            "is_active": true,
            "sort_order": 1,
            "created_at": "2023-01-01T00:00:00.000000Z",
            "updated_at": "2023-01-01T00:00:00.000000Z"
        }
    ]
}
```

## Provider Answers API

### Get My Answers
```
GET /my-answers
```

**Query Parameters:**
- `per_page` (optional): Number of items per page (default: 15)

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "provider_id": 1,
            "question_id": 5,
            "answer": "This is my answer to the question",
            "attachment": "provider_answers/provider_1_question_5_1234567890.pdf",
            "attachment_url": "http://your-domain.com/storage/provider_answers/provider_1_question_5_1234567890.pdf",
            "score": 10,
            "is_correct": true,
            "is_evaluated": true,
            "submitted_at": "2023-01-01 10:30:00",
            "evaluated_at": "2023-01-01 11:00:00",
            "created_at": "2023-01-01 10:30:00",
            "updated_at": "2023-01-01 11:00:00",
            "provider": {
                "id": 1,
                "name": "Provider Name",
                "slug": "provider-slug"
            },
            "question": {
                "id": 5,
                "title": "Question Title",
                "score": 10,
                "allows_attachments": true,
                "requires_attachment": false
            }
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 15,
        "total": 25
    }
}
```

### Submit Provider Answer
```
POST /provider-answers
```

**Request Body (multipart/form-data):**
- `question_id` (required): Question ID
- `answer` (required): Answer text (max 5000 characters)
- `attachment` (optional): File attachment (pdf, doc, docx, jpg, jpeg, png, max 10MB)

**Note:** The `provider_id` is automatically determined from the authenticated user's provider account.

**Response:**
```json
{
    "success": true,
    "message": "Answer submitted successfully.",
    "data": {
        "id": 1,
        "provider_id": 1,
        "question_id": 5,
        "answer": "This is my answer to the question",
        "attachment": "provider_answers/provider_1_question_5_1234567890.pdf",
        "attachment_url": "http://your-domain.com/storage/provider_answers/provider_1_question_5_1234567890.pdf",
        "score": null,
        "is_correct": false,
        "is_evaluated": false,
        "submitted_at": "2023-01-01 10:30:00",
        "evaluated_at": null,
        "created_at": "2023-01-01 10:30:00",
        "updated_at": "2023-01-01 10:30:00",
        "provider": {
            "id": 1,
            "name": "Provider Name",
            "slug": "provider-slug"
        },
        "question": {
            "id": 5,
            "title": "Question Title",
            "score": 10,
            "allows_attachments": true,
            "requires_attachment": false
        }
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
- `201`: Created
- `400`: Bad Request
- `404`: Resource not found
- `500`: Internal server error

## Examples

### Get questions for a category
```bash
curl -X GET http://your-domain.com/api/questions/category/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### Get my answers
```bash
curl -X GET http://your-domain.com/api/my-answers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### Get my answers with pagination
```bash
curl -X GET http://your-domain.com/api/my-answers?per_page=20 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json"
```

### Submit answer with attachment
```bash
curl -X POST http://your-domain.com/api/provider-answers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "question_id=5" \
  -F "answer=This is my detailed answer" \
  -F "attachment=@/path/to/file.pdf"
```

### Submit answer without attachment
```bash
curl -X POST http://your-domain.com/api/provider-answers \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "question_id=5" \
  -F "answer=This is my detailed answer"
```
