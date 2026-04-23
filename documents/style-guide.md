# Housemate App Style Guide

This document defines the visual direction for Housemate App's MVP.

It exists to keep the interface consistent across:

- hand-written frontend work
- AI-generated UI code
- future refactors and page additions

## 1. Brand Direction

Housemate App should feel:

- warm
- practical
- trustworthy
- urban
- calm
- modern without looking like generic SaaS

Housemate App should not feel:

- neon
- overly playful
- luxury-brand glossy
- dark-mode-first
- purple-heavy
- glassmorphism-driven

## 2. Visual Personality

The product is about shared living, trust, and personal fit. The UI should support that by feeling approachable and steady rather than flashy.

Design choices should lean toward:

- warm neutrals for the main canvas
- earthy greens for positive emphasis
- muted terracotta and sand tones for warmth
- clean spacing and readable forms
- strong card hierarchy for browse pages

## 3. Core Color Palette

These are the preferred brand colors for the MVP.

### Warm Neutrals

- `Canvas`: `#f6f1e8`
- `Canvas Raised`: `#fffaf2`
- `Canvas Soft`: `#fcf5ea`
- `Border Soft`: `#d8cab8`
- `Border Strong`: `#cdbca6`
- `Text Strong`: `#241c15`
- `Text Base`: `#3d3025`
- `Text Muted`: `#655648`
- `Text Soft`: `#897462`

### Primary Accent

- `Forest`: `#2f5d4f`
- `Forest Hover`: `#264d42`
- `Forest Soft`: `#dfe9e3`

### Warm Accent

- `Sand`: `#f3e8d9`
- `Amber Soft`: `#f7eddf`
- `Terracotta Soft`: `#f8d0bc`
- `Highlight`: `#8a5e2f`

### Feedback Colors

- `Success`: `#3f6f57`
- `Warning`: `#a06b2c`
- `Danger`: `#b04c42`

## 4. Semantic Color Usage

Do not think in terms of random hex values when building pages. Think in semantic roles.

Preferred semantic roles:

- `background`: the main page background
- `surface`: raised cards, panels, and sheets
- `surface-subtle`: muted containers and chip backgrounds
- `foreground`: strongest body and heading text
- `foreground-muted`: supporting copy and secondary text
- `border`: default border color
- `border-strong`: emphasized separators or selected states
- `primary`: main action color
- `primary-foreground`: text on primary buttons
- `accent`: supportive warm highlight color
- `success`
- `warning`
- `danger`

## 5. Typography

### Font

Use the existing project font stack centered on `Instrument Sans`.

Avoid introducing expressive display fonts unless the product direction changes later.

### Heading Style

- headings should feel confident and clean
- use tight tracking on large headings
- avoid exaggerated letter spacing except for tiny labels or status pills

### Text Hierarchy

- Page title: strong, compact, high contrast
- Section title: clear and medium-weight
- Body copy: readable and calm
- Labels and metadata: smaller, slightly muted
- Micro labels: uppercase only when used sparingly for chips, badges, and section markers

## 6. Spacing Scale

Use a small consistent spacing scale.

Preferred spacing steps:

- `4`
- `8`
- `12`
- `16`
- `20`
- `24`
- `32`
- `40`
- `48`
- `64`

Do not invent irregular spacing values unless there is a layout reason.

## 7. Radius and Shadows

### Radius

- small controls: `12px`
- inputs and buttons: `16px`
- cards and panels: `24px` to `32px`
- hero or featured panels: `32px`
- pill UI: full rounded

### Shadows

Use soft warm shadows, not cold blue-gray shadows.

- cards: subtle elevation
- hover cards: slightly deeper but still soft
- large panels: diffused shadow with low opacity

Avoid:

- harsh black shadows
- overly dramatic floating cards
- layered glass blur stacks

## 8. Layout Rules

### Public Pages

Public browse and marketing pages should feel spacious.

- use large section spacing
- use clear horizontal rhythm
- keep the main content width controlled
- use cards and blocks instead of dense tables

### Authenticated Utility Pages

Settings and dashboard pages can be denser.

- prioritize clarity over atmosphere
- reduce decorative backgrounds
- keep forms compact and easy to scan

### Browse Pages

Browse pages are one of the main product surfaces and should share a recognizable structure:

- page intro section
- search and filter container
- results summary row
- card grid or card list
- empty state when needed

## 9. Component Direction

### Buttons

Use only a small set of button styles:

- primary
- secondary
- ghost

Primary buttons should use the dark warm text color or the forest green, depending on context.

### Inputs

Inputs should:

- sit on white or near-white surfaces
- use soft rounded corners
- use warm neutral borders
- have visible focus states

### Cards

Cards should:

- use warm off-white surfaces
- have generous padding
- rely on spacing more than heavy dividers
- maintain strong title and metadata hierarchy

### Chips and Filters

Filter chips should:

- use muted warm backgrounds
- use low-contrast borders
- stay visually lightweight

## 10. Page-Specific Guidance

### Home Page

- strong hero
- limited copy
- bold call to action
- warm, inviting presentation

### Browse Listings

- search and filters should be obvious
- listing cards should emphasize rent, location, and availability
- visuals should feel trustworthy and easy to scan

### Browse Profiles

- profile cards should emphasize fit and lifestyle summary
- avoid making them look like social media cards

### Settings Pages

- simplify the visual treatment
- focus on forms and section grouping
- avoid decorative overload

## 11. Do and Don't

### Do

- reuse the same warm neutral base across pages
- keep actions visually consistent
- use semantic color roles
- make browse cards feel intentional and premium enough for trust
- keep spacing generous on public pages

### Don't

- use random raw palette changes per page
- introduce purple as a default accent
- mix three different card styles on one page
- overuse gradients just because they look modern
- make settings pages look like marketing pages

## 12. Proposed Token Set

When the frontend style system is formalized, these are the first tokens that should exist in CSS:

- `--background`
- `--surface`
- `--surface-subtle`
- `--foreground`
- `--foreground-muted`
- `--border`
- `--border-strong`
- `--primary`
- `--primary-foreground`
- `--accent`
- `--success`
- `--warning`
- `--danger`
- `--radius-sm`
- `--radius-md`
- `--radius-lg`

## 13. Current Implementation Note

The project does not yet fully enforce these styles through shared semantic tokens.

Until those tokens are introduced into the CSS system:

- keep new pages aligned to this guide
- avoid inventing a fresh palette per feature
- refactor existing screens gradually toward the same color and spacing language
