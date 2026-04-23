# Housemate App AI UI Rules

This file is the short rule set for AI-generated frontend code.

Follow these rules whenever generating Vue, Inertia, Tailwind, or page layout code for this project.

## 1. Source of Truth

Use these references in order:

1. `documents/style-guide.md`
2. existing project components and layouts
3. existing page patterns already in the repo

Do not invent a new visual language if one already exists.

## 2. Non-Negotiable Rules

- Prefer semantic design intent over random utility combinations.
- Reuse the Housemate warm-neutral visual system.
- Keep public pages spacious and card-driven.
- Keep settings pages practical and denser.
- Avoid purple-heavy palettes unless explicitly requested.
- Avoid glassmorphism, neon gradients, and generic startup visuals.
- Do not hardcode many unrelated hex values inside one component.
- Keep button styles, input styles, and card styles consistent between pages.
- Favor two or three strong UI patterns repeated well over many one-off designs.

## 3. Color Rules

- Base the UI on warm neutrals.
- Use dark warm text for primary readability.
- Use forest green as the main positive accent.
- Use muted sand, cream, and terracotta tones as supporting accents.
- Keep borders soft and warm.
- Do not default to cold grayscale if the page is public-facing.

## 4. Component Rules

### Buttons

- Use only `primary`, `secondary`, or `ghost` styles.
- Primary buttons should be visually obvious.
- Secondary buttons should sit back without disappearing.
- Ghost buttons should be quiet but still readable.

### Cards

- Cards should have generous padding.
- Cards should use warm off-white surfaces.
- Cards should rely on spacing and hierarchy more than heavy borders.
- Browse cards should have a clear title, metadata, and CTA.

### Inputs

- Inputs and selects should share the same rounded shape and border treatment.
- Inputs should always have a visible label or clear context.
- Focus states must be visible.

### Chips

- Chips should be lightweight and consistent.
- Use them for filters, tags, and metadata, not as decoration.

## 5. Layout Rules

### Public Pages

- Use larger spacing and more visual breathing room.
- Use one strong hero or intro block.
- Use one dominant content pattern per page.

### Browse Pages

Every browse page should usually contain:

- page heading
- search and filter area
- results summary
- card grid or list
- empty state

### Settings Pages

- prefer stacked sections
- keep forms readable and predictable
- reduce decorative elements

## 6. Tailwind Rules

- Prefer reusable visual logic over excessive one-off utilities.
- Keep spacing values consistent with the style guide.
- Do not mix multiple radius systems on the same page.
- Do not create three different shadow styles in one feature.
- If a page needs many repeated classes, that is a signal to extract a component.

## 7. AI Decision Rules

When unsure:

- choose calmer over louder
- choose clearer over more decorative
- choose consistency over novelty
- choose readable hierarchy over dense information
- choose the existing pattern over a new pattern

## 8. Forbidden Defaults

Do not default to:

- purple gradient hero sections
- random blue SaaS styling
- glass cards everywhere
- ultra-rounded bubbly UI without reason
- dark mode as the assumed default for public pages
- dashboard-style density on browse pages

## 9. Build Expectations

When generating a new page:

- match the existing Housemate visual direction
- keep mobile layout usable
- ensure headings, cards, and controls follow one system
- leave the page in a state that can later be tokenized cleanly
