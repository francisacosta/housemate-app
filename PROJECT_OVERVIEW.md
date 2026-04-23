# Housemate App

Housemate App is a Philippines-focused shared-living platform built to help people find compatible housemates and discover real places to share.

The product is now oriented around **two public discovery objects**:

- property listings for real rooms, units, or shared spaces that already exist
- roommate posts for people who are still looking for a place, looking for housemates, or trying to form a group before renting

## Overview

Housemate App is a shared-living marketplace and matching network designed for the Philippine market.

The goal is to help users:

- discover available rooms and shared-living opportunities
- find people who want to search for or share a place together
- compare practical compatibility signals before connecting
- make better decisions before entering a shared-living setup

## Product Direction

The platform is intended to support roommate matching through listings, structured roommate posts, and compatibility signals.

The main product surfaces are:

### 1. Property Listings

Listings represent actual available places. These may be posted by owners, tenants, or primary renters who already have a unit and are looking for a housemate.

Each listing may include information such as:

- title and description
- city or area
- property type and space type
- rent, deposit, and move-in timing
- furnished and utilities information
- current household context
- optional tenant preference details

### 2. Roommate Posts

Roommate posts represent intent rather than inventory. They are for users who do not yet have a place or who want to find people first.

Typical post types may include:

- looking for a place to join
- looking for roommates to search with
- looking for one more person before renting a unit

Each roommate post may eventually include information such as:

- budget range
- target location
- move-in timeline
- preferred property type
- roommate intent
- cleanliness habits
- smoking and drinking preferences
- pet preferences
- sleep schedule and daily routine
- household rules or non-negotiables

This data is expected to support discovery, filtering, and compatibility review, while keeping full user profiles as supporting data rather than the first public browse surface.

## Planned Features

The long-term product scope includes:

- public property listings
- public roommate posts
- structured private profile and preference data that supports matching
- search and filtering by location, budget, post type, property type, and lifestyle signals
- apply or express-interest workflows for listings and roommate posts
- mutual match and messaging workflows between users
- offer or agreement proposal flows after a match
- trust, moderation, and verification features

## Current Status

This repository is currently in an early-stage foundation phase.

At present, the application provides the account, security, and frontend/backend structure needed for future product development. It also includes an early public listing browse experience, but it does not yet implement the full listings plus roommate-post matching workflow.

## Current Features

Implemented features currently include:

- user registration
- user login and logout
- password reset
- email verification
- password confirmation for sensitive actions
- two-factor authentication support
- profile update for name and email
- password update
- appearance settings
- account deletion
- authenticated dashboard routing
- public browse listings page backed by listing records
- public listing details page backed by listing records
- automated tests for authentication, dashboard access, and settings flows

## Current Limitations

The following core product capabilities are not yet implemented:

- roommate posts and roommate-post discovery flows
- listing creation and management workflows for end users
- structured private lifestyle and compatibility fields
- apply or express-interest workflows for listings or roommate posts
- direct messaging and mutual match workflows
- saved listings or saved posts
- moderation, identity, or trust verification systems
- a fully functional product dashboard

## Tech Stack

- Laravel 13
- PHP 8.3+
- Vue 3
- TypeScript
- Inertia.js
- Laravel Fortify
- Tailwind CSS
- Laravel Sail
- MySQL

## Notes

This file is written as a product-oriented overview. If needed, installation instructions, local setup steps, and developer workflows can be maintained separately in a `README.md`.
