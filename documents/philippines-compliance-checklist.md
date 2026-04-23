# Philippines compliance and user protection checklist

This document is a practical checklist for building Housemate App responsibly in the Philippines.

It is not legal advice. Use it to reduce risk, protect users, and prepare better questions for a Philippine privacy or technology lawyer.

## 1. Core legal areas to assume apply

For a housemate, roommate, or rental-matching app in the Philippines, the main legal areas are usually:

- **Data Privacy Act of 2012 (`RA 10173`)** and National Privacy Commission guidance
- **Cybercrime Prevention Act of 2012 (`RA 10175`)** for misuse, unauthorized access, and online abuse
- **E-Commerce Act (`RA 8792`)** for online transactions, records, and electronic communications
- **Consumer protection rules**, especially if the app makes promises about safety, verification, or listing quality
- **Harassment, voyeurism, and abuse-related laws**, especially if users can message, upload photos, or reveal personal living details

If the product later handles rent payments, security deposits, escrow, broker-style matching, or signed lease workflows, get local legal review before launch because the compliance burden rises.

## 2. Your likely minimum responsibilities

### A. Collect only data you truly need

You should avoid collecting personal data just because it might be useful later.

Only collect what is necessary for:

- account creation
- profile matching
- listing publication
- user support
- fraud prevention
- safety review

For a housemate app, high-risk data includes:

- full legal names
- exact addresses
- phone numbers
- private messages
- workplace or school details
- daily schedule or routine information
- precise location data
- government ID images
- emergency contact details
- lifestyle and preference fields that may reveal sensitive personal information

### B. Tell users clearly what you collect and why

Before or at the time of collection, users should be told in plain language:

- what data you collect
- why you collect it
- whether it is required or optional
- who can see it
- who you share it with
- how long you keep it
- how they can request access, correction, deletion, or account closure
- how to contact your privacy lead or responsible person

Do not bury safety-critical disclosures in long legal text.

### C. Use an appropriate legal basis

Do not rely on consent for everything by default.

In practice, some processing may be justified because it is necessary to:

- provide the service the user requested
- comply with legal obligations
- protect the platform and users from fraud or abuse

Where you collect optional or more sensitive data, a more explicit and well-designed consent flow is safer.

Examples of data that should be treated carefully include:

- religion
- health-related information
- sexual orientation
- disability-related information
- identity documents
- highly personal lifestyle or household compatibility data

### D. Secure the data you hold

At minimum, you should implement reasonable organizational, physical, and technical safeguards.

That usually means:

- strong password storage and modern authentication controls
- least-privilege access for admins and support staff
- encrypted connections
- secure file storage for uploads
- audit logs for sensitive admin actions
- rate limiting and abuse monitoring
- backup and recovery procedures
- vendor review for hosting, email, SMS, analytics, and file storage providers

If you do not need staff to see raw data, do not expose it in admin panels.

### E. Respect data subject rights

You should have a documented process for handling requests to:

- access personal data
- correct inaccurate data
- delete or deactivate accounts where appropriate
- object to some uses of data
- withdraw consent for optional processing

Even if there are cases where you must retain some records for fraud, disputes, or legal reasons, explain that clearly.

### F. Prepare for breaches and incidents

You should have a written internal incident process for:

- suspected account takeover
- exposed profile data
- leaked message history
- fake listings used for scams
- unauthorized admin access
- compromised file uploads

This process should assign owners, escalation steps, containment steps, evidence preservation, and notification review.

If a serious personal data breach happens, Philippine privacy notification duties may apply. Do not wait until after launch to decide how you will handle that.

## 3. Product-specific safety duties for a housemate app

### A. Avoid early exposure of real-world contact details

Do not show the following publicly by default:

- exact unit or house number
- exact street address
- phone number
- personal email address
- government ID details
- full legal name if a safer display name is enough

Use staged disclosure instead.

For example:

- public listing shows only general area
- initial chats happen in-app
- direct contact is revealed only after trust or explicit action

### B. Treat messaging as a high-risk feature

If your app has chat or direct messaging, add:

- block functionality
- report functionality
- anti-spam limits
- abusive keyword review or trust signals where appropriate
- internal tooling to review reported conversations with strict access control

Users should not be forced to leave the platform immediately just to communicate.

### C. Make verification truthful and narrow

If you use words like:

- verified
- background checked
- safe host
- trusted listing

you need a defensible internal meaning for each label.

Document:

- what was checked
- when it was checked
- what was not checked
- how often it expires
- what action removes the label

Never imply that verification means a user is harmless or that a property is legally compliant unless you can actually stand behind that statement.

### D. Use extreme caution with ID collection

Collect government IDs only if the benefit clearly outweighs the risk.

If you decide to use ID verification:

- explain why it is needed
- limit access to the smallest possible team
- avoid making raw ID images broadly viewable
- define a short retention period for raw files if possible
- store only the minimum metadata needed after review where legally and operationally appropriate

If a lighter verification method works, prefer it.

### E. Limit sensitive profile fields

Some compatibility filters may create privacy and discrimination risk.

Be careful with fields such as:

- religion
- ethnicity
- sexual orientation
- disability
- pregnancy or family status
- political views
- medical conditions

If any of these are collected:

- make them optional unless absolutely necessary
- explain the purpose clearly
- set safer defaults for visibility
- review whether the field should exist at all

### F. Build real user safety tools

At minimum, the app should support:

- blocking another user
- reporting profiles, listings, and messages
- quickly disabling or hiding abusive accounts and listings
- preserving moderation evidence internally
- letting users hide or deactivate their profile
- a simple path to request deletion or support

### G. Protect location information

For housing products, location data can become a physical safety risk.

Avoid combining too many details in public view, such as:

- exact address
- availability schedule
- solo occupancy details
- gender preference plus home access information
- photos that reveal unit number, nearby landmarks, or routines

### H. Do not casually allow minors

If the app is meant for adults seeking housing or housemates, make that explicit and enforce it.

If minors could join or be listed, get legal review before launch because the safety and compliance stakes rise sharply.

## 4. Platform statements that create legal risk

Your copy, labels, ads, onboarding text, and FAQs matter.

Avoid unsupported claims such as:

- everyone here is verified
- all listings are legitimate
- all users are safe
- scam-free platform
- background checked community

Safer language is narrower and provable, for example:

- we review reports and remove accounts that violate our rules
- some users complete additional verification steps
- never send money outside the app unless you trust the recipient
- always inspect a property and confirm key details independently

## 5. Internal documents you should have before launch

Create and maintain these internal or public documents:

- **Privacy Policy**
- **Terms of Service**
- **Community Guidelines or Safety Rules**
- **Data retention and deletion schedule**
- **Personal data incident response procedure**
- **Vendor list and data-sharing map**
- **Moderator escalation guide**
- **Law enforcement and legal request handling notes**

For the privacy and safety flow, identify one responsible owner even if your team is still small.

## 6. High-priority product rules for Housemate App

These are the most practical choices if the goal is to protect users as much as possible.

### Strongly recommended defaults

- show only general location until trust is established
- keep phone numbers and personal email hidden by default
- require in-app reporting and blocking from day one
- delay direct contact sharing until a user takes a deliberate action
- make risky profile fields optional and private by default
- avoid raw ID storage unless there is a clear operational need
- log sensitive admin views and moderation actions
- let users download, edit, or delete important account data through support at minimum

### Red flags to avoid

- publicly showing exact home addresses
- storing government IDs forever without a strong reason
- making sensitive personal preferences visible by default
- marketing the app as fully safe or fully verified
- having chat without report and block tools
- keeping deleted user data indefinitely with no retention rule

## 7. Practical launch checklist

Before launch, confirm all of the following:

- [ ] Privacy notice explains data collection, use, sharing, retention, and rights
- [ ] Terms cover user behavior, platform limits, takedowns, and account suspension
- [ ] Community rules prohibit scams, impersonation, harassment, doxxing, and sexual misconduct
- [ ] Listings show only general area, not exact address by default
- [ ] User profile exposes only the minimum public information needed
- [ ] Blocking and reporting are available for profiles, listings, and messages
- [ ] Admin access to sensitive data is limited and logged
- [ ] Sensitive uploads are stored securely and access is restricted
- [ ] Deletion and retention rules are documented
- [ ] Incident response owner and escalation path are assigned
- [ ] Claims about verification or safety are accurate and documented
- [ ] Support workflow exists for privacy requests and abuse complaints
- [ ] You know which vendors receive personal data and why

## 8. Questions to take to a Philippine lawyer

Use these questions to get precise advice quickly:

- Do our data flows and notices comply with the Data Privacy Act and current NPC guidance?
- Do we need a more formal privacy governance structure for our scale and risk profile?
- Is any profile field we collect considered sensitive personal information in our use case?
- Are our ID verification, retention, and deletion practices defensible?
- Do our Terms and community rules give enough authority to remove abusive users and preserve evidence?
- If we facilitate payments, commissions, or lease execution later, what additional rules apply?
- Are any of our safety or verification claims too broad from a consumer protection standpoint?

## 9. Best next steps for this app

If the goal is maximum user protection, the next legal and product steps should be:

1. map every data field the app collects or plans to collect
2. label each field as required, optional, public, private, or high-risk
3. remove unnecessary fields before launch
4. write a plain-language privacy policy and terms set
5. add report, block, and moderation workflows early
6. decide exactly how verification works before using any trust labels
7. define retention and deletion periods for profiles, messages, and uploaded files
8. get a Philippine lawyer to review the final policies and highest-risk features

## 10. Working rule for future product decisions

If a feature could reveal where someone lives, how to reach them off-platform, when they are vulnerable, or a sensitive part of their identity, treat it as a high-risk feature and add friction, limits, review, and clear user controls.
