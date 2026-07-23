# OnlyHUB — primary page illustration map

These approved visuals are the primary hero and editorial illustrations for the OnlyHUB website.

## Usage rules

- Preserve the original composition and OnlyHUB branding.
- Use dark overlays only when text readability requires it.
- Do not stretch images; use `object-fit: cover` and controlled focal positioning.
- Desktop hero ratio: approximately 16:9 or 3:2.
- Mobile variants should be cropped from the original, keeping the logo or key subject visible.
- Provide modern formats during implementation: AVIF, WebP and a JPEG fallback.
- Keep source originals outside generated build folders.

## Approved mapping

| Source file | Planned repository name | Primary use | Secondary use |
|---|---|---|---|
| User-approved purple OnlyHUB headquarters artwork | `home-hero-ecosystem.jpg` | **Home page hero — canonical image** | Campaign presentations and social previews |
| `1000101947.png` | `ecosystem-night-campus.jpg` | Ecosystem / headquarters section | About introduction |
| `1000101948.png` | `support-logistics-van.jpg` | OnlyHUB Support hero | Logistics and transport project cards |
| `1000101934.png` | `support-mobility-fleet.jpg` | Mobility and humanitarian transport | Partners / fleet overview |
| `1000101954.png` | `info-call-center.jpg` | OnlyHUB Info page hero | Contact center and support services |
| `1000101955.png` | `media-charity-concert-team.jpg` | OnlyHUB Media / Music hero | Events and charity concert editorial blocks |
| `1000101930.png` | `support-logistics-van-alt.jpg` | Alternative Support hero | Sustainability / Eco System partnership |
| `1000101953.png` | `about-team-community-space.jpg` | About Us / Team hero | Culture, workspace and community |
| `1000101950.png` | `impact-mission-control.jpg` | Transparency / Impact hero | Reports, analytics and project dashboard |
| `1000101949.png` | `support-aid-fleet.jpg` | Humanitarian aid delivery hero | Fleet and operational capacity |

## Page priorities

1. **Home:** `home-hero-ecosystem.jpg`
2. **About Us:** `about-team-community-space.jpg`
3. **Support:** `support-logistics-van.jpg`
4. **Info / Contacts:** `info-call-center.jpg`
5. **Media / Music:** `media-charity-concert-team.jpg`
6. **Transparency / Reports:** `impact-mission-control.jpg`
7. **Projects / Humanitarian logistics:** `support-aid-fleet.jpg`
8. **Partners / Eco System:** `support-logistics-van-alt.jpg`
9. **Mobility programme:** `support-mobility-fleet.jpg`
10. **Ecosystem / Headquarters section:** `ecosystem-night-campus.jpg`

## Home hero composition

The canonical home image is the purple OnlyHUB headquarters artwork approved by the project owner. The first screen should use it as a full-width background with:

- a dark purple gradient overlay from left to right;
- the primary heading and short mission statement in the left safe area;
- primary CTA: **Підтримати**;
- secondary CTA: **Дізнатися більше**;
- no additional decorative imagery competing with the central building and OnlyHUB mark;
- a mobile crop centered around the headquarters and logo, with text moved below the image when necessary.

## Implementation note

The uploaded files are currently treated as approved source assets. During theme implementation they will be copied into `wp-content/themes/onlyhub/assets/images/hero/`, renamed according to this map, optimized, and registered through WordPress responsive image functions.
