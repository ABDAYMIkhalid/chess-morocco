# Chess Morocco V1 API

Base URL: `http://localhost:8000/api/v1`

Authentication uses Laravel Sanctum bearer tokens. Send the token on protected requests:

```http
Authorization: Bearer <token>
Accept: application/json
Content-Type: application/json
```

## Common Responses

| Status | Meaning |
| --- | --- |
| `200` | Request completed successfully |
| `201` | Resource created |
| `204` | Resource deleted with no response body |
| `401` | Missing or invalid authentication token |
| `403` | Authenticated user lacks the required role or ownership |
| `404` | Resource does not exist or is not visible to the requester |
| `422` | Validation or business-rule error; details are in `errors` |

## Authentication

### `POST /auth/register`

Authentication: public

```json
{
	"name": "Amina Player",
	"email": "amina@example.com",
	"password": "password123",
	"phone": "+212600000000",
	"role": "player"
}
```

`role` accepts `player` or `organizer` and defaults to `player`. Admin accounts are created by the seeder, never by public registration.

Response: `201`

```json
{
	"data": { "id": 1, "name": "Amina Player", "email": "amina@example.com", "role": "player" },
	"token": "1|...",
	"token_type": "Bearer"
}
```

### `POST /auth/login`

Authentication: public

```json
{ "email": "amina@example.com", "password": "password123" }
```

Response: `200` with `data`, `token`, and `token_type`. Invalid credentials return `401`.

### `POST /auth/logout`

Authentication: any authenticated user

Revokes the current token. Response: `200`.

### `POST /auth/logout-all`

Authentication: any authenticated user

Revokes all tokens for the current user. Response: `200`.

### `GET /auth/me`

Authentication: any authenticated user

Returns the user and their player or organizer profile. Response: `200`.

## Tournaments

Tournament statuses are `pending`, `approved`, `rejected`, `ongoing`, `completed`, and `cancelled`. Public listings only expose `approved`, `ongoing`, and `completed` tournaments.

### `GET /tournaments`

Authentication: public

Query parameters: `city_id`, `q`, and `per_page` (maximum `100`). Response: `200` with paginated `data`.

### `GET /tournaments/{id}`

Authentication: public for visible tournaments; an organizer can view their own pending tournament.

Response: `200` with the tournament, organizer, club, venue, city, and registrations. Unknown or hidden tournaments return `404`.

### `POST /tournaments`

Authentication: organizer or admin

```json
{
	"name": "Casablanca Open",
	"format": "swiss",
	"start_date": "2026-11-20",
	"end_date": "2026-11-22",
	"registration_deadline": "2026-11-10",
	"city_id": 1,
	"club_id": 1,
	"venue_id": 1,
	"max_players": 80,
	"entry_fee": 100,
	"description": "Open tournament"
}
```

The server assigns the authenticated organizer and creates the tournament as `pending`. Response: `201`.

### `PUT /tournaments/{id}`

Authentication: owning organizer or admin

Accepts the editable tournament fields. Another organizer receives `403`. Response: `200`.

### `DELETE /tournaments/{id}`

Authentication: owning organizer or admin

Deletes the tournament. Response: `200` with a confirmation message.

## Registrations

### `POST /tournaments/{id}/registrations`

Authentication: player only

No request body is required. The server verifies that the tournament is approved, registration is still open, the tournament is not full, and the player has not already registered. Successful response: `201`.

Business-rule failures return `422`.

### `GET /tournaments/{id}/registrations`

Authentication: tournament organizer or admin

Returns the paginated entry list. Response: `200`.

### `PATCH /registrations/{id}`

Authentication: tournament organizer or admin

```json
{ "status": "confirmed" }
```

Accepted statuses: `confirmed`, `waitlisted`, `rejected`, `cancelled`. Response: `200`.

### `DELETE /registrations/{id}`

Authentication: registered player, tournament organizer, or admin

Marks the registration as cancelled. Response: `200`.

## Admin

All admin endpoints require `auth:sanctum` and the `admin` role. Players and organizers receive `403`.

### `GET /admin/dashboard`

Returns counts for users, tournaments, pending tournaments, clubs, venues, and registrations.

### `GET /admin/tournaments/pending`

Returns paginated tournaments awaiting moderation.

### `PATCH /admin/tournaments/{id}/approve`

Changes a pending tournament to `approved`. Response: `200`.

### `PATCH /admin/tournaments/{id}/reject`

Changes a pending tournament to `rejected`. Response: `200`.
