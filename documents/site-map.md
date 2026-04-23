# Housemate App Site Map

This document is a simple MVP site map.

Each page includes:

- what the page is for
- the minimum content it should contain

## 1. Home

### 1.1 Home Page

**What it is for**

The landing page that introduces Housemate App and directs users to the main browsing experience.

**Content**

- hero section
- short value proposition
- CTA to browse roommate posts
- CTA to browse listings
- CTA to sign up
- short "how it works" section
- explanation of the difference between listings and roommate posts

## 2. Roommate Posts

### 2.1 Browse Roommate Posts

**What it is for**

Lets users discover people who are looking for a place, looking for roommates, or trying to form a group before renting.

**Content**

- search bar
- filter controls
- roommate post cards or list
- each card should show:
  post type, location, budget range, move-in date, short lifestyle or intent summary
- empty state when no results match

### 2.2 View Roommate Post

**What it is for**

Shows the full details of one roommate post.

**Content**

- post title or headline
- short author summary
- location or target area
- budget range
- move-in date or timeline
- roommate intent or post type
- preferred property type
- lifestyle preferences
- dealbreakers or house rules
- description or note
- button to express interest

### 2.3 My Roommate Posts

**What it is for**

Lets the logged-in user manage the roommate posts they created.

**Content**

- list of owned roommate posts
- post status
- create new post button
- edit action
- publish action
- pause or close action

### 2.4 Create Roommate Post

**What it is for**

Lets the user create a new roommate post.

**Content**

- post form
- post type
- title or headline
- description
- location fields
- budget range
- move-in timeline
- preferred property type
- roommate intent fields
- lifestyle preference fields
- save draft button
- publish button

### 2.5 Edit Roommate Post

**What it is for**

Lets the user update an existing roommate post.

**Content**

- same fields as Create Roommate Post
- current post status
- update button
- publish or unpublish action

## 3. Listings

### 3.1 Browse Listings

**What it is for**

Lets users search for available rooms, shared units, or housing opportunities.

**Content**

- search bar
- filter controls
- listing cards or listing list
- each card should show:
  title, location, rent, property type, space type, available date
- empty state when no results match

### 3.2 View Listing

**What it is for**

Shows the full details of one listing.

**Content**

- listing title
- photo gallery
- rent
- deposit
- available date
- property type
- space type
- location summary
- description
- furnished and utilities details
- host summary
- button to apply

### 3.3 My Listings

**What it is for**

Lets the logged-in user manage the listings they created.

**Content**

- list of owned listings
- listing status
- create new listing button
- edit action
- publish action
- pause action
- close action

### 3.4 Create Listing

**What it is for**

Lets the user create a new property or room listing.

**Content**

- listing form
- title
- description
- property type
- space type
- rent
- deposit
- available date
- furnished toggle
- utilities included toggle
- location fields
- tenant preference fields
- save draft button
- publish button

### 3.5 Edit Listing

**What it is for**

Lets the user update an existing listing.

**Content**

- same fields as Create Listing
- current listing status
- update button
- publish or unpublish action

## 4. Dashboard

### 4.1 User Dashboard

**What it is for**

Acts as the logged-in starting point after authentication.

**Content**

- quick link to create roommate post
- quick link to manage roommate posts
- quick link to create listing
- quick link to manage listings
- recent activity or placeholder for future applications, interests, or conversations

## 5. Auth

### 5.1 Sign Up

**What it is for**

Lets a new user create an account.

**Content**

- name field
- email field
- password field
- confirm password field
- sign up button

### 5.2 Log In

**What it is for**

Lets an existing user access their account.

**Content**

- email field
- password field
- remember me option
- login button
- forgot password link

### 5.3 Forgot Password

**What it is for**

Lets a user request a password reset link.

**Content**

- email field
- send reset link button

## 6. Settings

### 6.1 Account Settings

**What it is for**

Lets the user manage account-level settings separate from public roommate posts and listings.

**Content**

- update name and email
- change password
- appearance settings
- two-factor authentication
- delete account

## 7. Suggested Main Navigation

- Home
- Browse Roommate Posts
- Browse Listings
- Dashboard
- My Posts
- My Listings
- Account Settings

## 8. Public vs Authenticated Pages

### Public

- Home Page
- Browse Roommate Posts
- View Roommate Post
- Browse Listings
- View Listing
- Sign Up
- Log In
- Forgot Password

### Authenticated

- Dashboard
- My Roommate Posts
- Create Roommate Post
- Edit Roommate Post
- My Listings
- Create Listing
- Edit Listing
- Account Settings

## 9. MVP Priority Pages

If we want the smallest useful MVP, the first pages to build should be:

1. Home Page
2. Browse Roommate Posts
3. View Roommate Post
4. Browse Listings
5. View Listing
6. Dashboard
7. My Roommate Posts
8. Create Roommate Post
9. My Listings
10. Create Listing
