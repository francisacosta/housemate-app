# Housemate App

Housemate App is a Philippines-focused shared-living platform for people who want to find available rooms, post listings, or connect with potential housemates before renting.

The MVP is centered on two discovery surfaces:

- Listings: real rooms, units, or shared spaces that are available.
- Roommate posts: user intent posts for people looking for a place, looking for housemates, or forming a group before renting.

## Current Status

The project is in early MVP development.

Implemented today:

- User registration, login, logout, password reset, email verification, password confirmation, and two-factor authentication support.
- Authenticated dashboard and settings pages.
- Public listing browse and listing detail pages backed by database records.
- Public roommate-post browse and detail pages backed by database records.
- Authenticated roommate-post create, edit, draft, and publish workflow.
- Demo seeding for profiles, preferences, listings, listing photos, roommate posts, conversations, and messages.
- Pest feature tests for auth, public discovery pages, settings, and roommate-post management.

Still needed for MVP launch:

- Authenticated listing creation and management.
- Listing photo upload and cover-photo management.
- Profile onboarding for shared-living details and preferences.
- Contact, inquiry, or messaging flow from listings and posts.
- Server-backed browse filters and pagination.
- Basic moderation, reporting, and content lifecycle controls.

## Tech Stack

- Laravel 13
- PHP 8.3+
- Laravel Fortify
- Inertia.js 3
- Vue 3
- TypeScript
- Tailwind CSS 4
- Laravel Wayfinder
- Laravel Sail
- Pest 4

## Local Development

This project runs through Laravel Sail.

Start the containers:

```bash
vendor/bin/sail up -d
```

Install dependencies if needed:

```bash
vendor/bin/sail composer install
vendor/bin/sail npm install
```

Prepare the app:

```bash
vendor/bin/sail artisan key:generate
vendor/bin/sail artisan migrate
```

Seed demo MVP data:

```bash
vendor/bin/sail artisan db:seed --class=MvpDemoSeeder
```

Run the frontend dev server:

```bash
vendor/bin/sail npm run dev
```

Build production assets:

```bash
vendor/bin/sail npm run build
```

## Testing

Run the test suite:

```bash
vendor/bin/sail artisan test --compact
```

Run PHP formatting:

```bash
vendor/bin/sail bin pint --dirty --format agent
```

Run frontend checks:

```bash
vendor/bin/sail npm run lint:check
vendor/bin/sail npm run format:check
vendor/bin/sail npm run types:check
```

## Product Notes

`PROJECT_OVERVIEW.md` contains a broader product overview and roadmap. The near-term launch goal is to let users publish both listings and roommate posts, then allow other users to discover and contact them.
