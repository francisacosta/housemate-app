# Housemate App MVP Pages

This document outlines the minimum set of pages needed to launch a usable MVP of Housemate App.

The MVP should support three core user jobs:

- browse roommate posts
- browse available listings
- create and manage your own roommate posts or listings

## MVP Principles

- Keep the first release focused on two public content types: listings and roommate posts.
- Treat account/profile data as supporting data, not the main public browse surface.
- Do not depend on advanced matching, moderation, verification, or full chat before the basic browsing experience works.
- Prioritize pages that help users understand the product quickly and complete their first meaningful action.

## Core MVP Pages

### 1. Home Page

**Purpose**

Introduce the product, explain the value proposition, and direct users into browsing or account creation.

**Primary audience**

- new visitors
- logged-out users
- first-time users

**Minimum content**

- hero section explaining listings and roommate-post discovery
- CTA to browse roommate posts
- CTA to browse listings
- short explanation of how the platform works
- section explaining the difference between listings and roommate posts
- trust-building copy about safer shared-living decisions

**Primary actions**

- sign up
- log in
- browse roommate posts
- browse listings

### 2. Browse Roommate Posts Page

**Purpose**

Allow users to discover people who are looking for a place, looking for roommates, or trying to form a group before renting.

**Minimum content**

- roommate post card grid or list
- post summary on each card:
  post type, city, budget range, move-in timeline, short lifestyle or intent summary
- filters for:
  city, budget, move-in date, preferred property type, roommate intent, post type
- empty state for no matching results

**Primary actions**

- view roommate post details
- adjust filters
- sign up or log in to express interest or save later

### 3. Roommate Post Details Page

**Purpose**

Show the full details of a roommate post so users can evaluate fit before reaching out.

**Minimum content**

- post title or headline
- short author summary
- target location
- budget range
- move-in date or timeline
- roommate intent or post type
- preferred property type
- structured preferences:
  cleanliness, smoking, drinking, pets, sleep schedule, guests, cooking, noise tolerance
- household rules or dealbreakers
- short description or note about what the author is looking for

**Primary actions**

- express interest
- go back to browse results

### 4. Browse Listings Page

**Purpose**

Allow users to search for available rooms or shared-living opportunities.

**Minimum content**

- listing card grid or list
- listing summary on each card:
  title, city, property type, space type, rent, available date, short description
- filters for:
  city, rent range, property type, space type, move-in date
- empty state for no matching results

**Primary actions**

- view listing details
- adjust filters
- sign up or log in to apply or save later

### 5. Listing Details Page

**Purpose**

Help users evaluate whether a space is a fit before sending an application or inquiry.

**Minimum content**

- listing title
- photo gallery
- rent and deposit
- available date
- property type and space type
- location summary
- listing description
- furnished and utilities included indicators
- host summary
- compatibility or expectation notes if available

**Primary actions**

- apply to listing
- save for later
- return to listing browse

### 6. Dashboard Page

**Purpose**

Give logged-in users a practical starting point for managing their activity.

**Minimum content**

- quick link to create roommate post
- quick link to manage roommate posts
- quick link to create listing
- quick link to manage listings
- recent activity placeholder for future applications, interests, or conversations

**Primary actions**

- create roommate post
- manage roommate posts
- create listing
- manage listings

### 7. Roommate Post Management Page

**Purpose**

Let users create, edit, publish, pause, and close their roommate posts.

**Minimum content**

- list of user-owned roommate posts
- post status badges
- create roommate post CTA
- edit post action
- publish action
- close action

**Primary actions**

- create roommate post
- edit roommate post
- publish roommate post
- close roommate post

### 8. Roommate Post Editor Page

**Purpose**

Allow users to create or update a single roommate post.

**Minimum content**

- post type
- title or headline
- description
- city or target area
- budget range
- move-in date or timeline
- preferred property type
- lifestyle preference fields
- roommate intent fields
- visibility or status controls

**Primary actions**

- save draft
- publish roommate post

### 9. Listing Management Page

**Purpose**

Let users create, edit, publish, pause, and close their listings.

**Minimum content**

- list of user-owned listings
- listing status badges
- create listing CTA
- edit listing action
- publish listing action
- close listing action

**Primary actions**

- create listing
- edit listing
- publish listing
- close listing

### 10. Listing Editor Page

**Purpose**

Allow users to create or update a single listing.

**Minimum content**

- title
- description
- property type
- space type
- rent and deposit
- available date
- furnished and utilities included toggles
- location fields
- optional tenant preference fields
- photo upload placeholder or first-pass image support

**Primary actions**

- save draft
- publish listing

### 11. Account Settings Page

These mostly already exist in the starter app.

**Purpose**

Manage account-level settings separate from roommate posts and listings.

**Minimum content**

- name and email update
- password update
- appearance settings
- two-factor authentication
- account deletion

## Recommended MVP Navigation

Top navigation should initially include:

- Home
- Browse Roommate Posts
- Browse Listings
- Dashboard
- Account Settings

For logged-out users:

- Log In
- Sign Up

For logged-in users:

- Dashboard
- My Posts
- My Listings
- Account Settings

## Recommended MVP User Flows

### Visitor Flow

1. Land on home page.
2. Browse roommate posts or listings without signing in.
3. Open a detail page.
4. Sign up when ready to apply, express interest, or publish.

### Roommate Post Author Flow

1. Sign up or log in.
2. Create roommate post.
3. Save as draft or publish.
4. Review incoming interest later through future matching or messaging flows.

### Listing Owner Flow

1. Sign up or log in.
2. Create listing.
3. Save as draft or publish.
4. Manage listing status from dashboard or listing management.

## Pages We Can Defer

These are useful but not required for the first MVP release:

- saved roommate posts
- saved listings
- dedicated compatibility score page
- advanced messaging inbox
- moderation dashboard
- verification flow
- report user, post, or listing flow
- notifications center
- separate private preferences page

## Suggested Build Order

1. Home page
2. Browse roommate posts page
3. Roommate post details page
4. Browse listings page
5. Listing details page
6. Dashboard
7. Roommate post management page
8. Roommate post editor page
9. Listing management page
10. Listing editor page
11. Messaging, application, or interest flow

## Next Planning Step

After this page list, the next useful document should define:

- route structure
- page-to-model mapping
- required forms and validation rules
- which pages are public vs authenticated
