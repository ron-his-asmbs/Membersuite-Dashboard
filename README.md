# ASMBS Member Dashboard

A WordPress plugin that powers the member dashboard page using data from the MemberSuite API.

## How It Works

When a logged-in member visits the dashboard page, the plugin fetches their profile data from the MemberSuite individual endpoint and makes it available to the dashboard template via WordPress query vars. The template renders the data in a read-only view.

## Requirements

- WordPress 6.0+
- PHP 8.1+
- Composer
- MemberSuite account with API access
- ASMBS SSO plugin (for `mem_guid` and `mem_key` user meta)

## Installation

Install via Composer from the ASMBS Satis repository:

```bash
composer require asmbs/dashboard
```

## Environment Variables

The following variables must be set in your `.env` file:
MS_EMAIL=your-membersuite-email
MS_PASSWORD=your-membersuite-password

## Data Displayed

The dashboard displays the following data from the MemberSuite API:

| Section | Source |
|---------|--------|
| Name | `firstName`, `middleName`, `lastName`, `prefix`, `suffix`, `designation` |
| Gender | `gender__c` |
| Race/Ethnicity | `races__c` |
| Board Certifications | `boardCertifications__c` |
| Societies | `societies__c` |
| Practice Setting | `practiceSetting__c` |
| Surgery Types | `surgeryTypes__c` |
| Addresses | `practice_Address`, `home_Address`, `other_Address` |
| Email Addresses | `emailAddress`, `emailAddress2`, `emailAddress3` |
| Phone Numbers | `practice_PhoneNumber`, `home_PhoneNumber`, `mobile_PhoneNumber`, `fax_PhoneNumber` |
| Websites & Social | `webSite`, `facebookProfile`, `twitterHandle`, `linkedInProfile`, `instagramProfile` |

### Unavailable Data

The following fields are not available from the MemberSuite API and display as "Unavailable":

- Bio
- Directory settings (public/private)
- Directory search views
- Profile views
- ABS learner ID
- Dues status

## User Lookup

The plugin looks up member data using the `mem_guid` WordPress user meta field set by the ASMBS SSO plugin. If `mem_guid` is missing but `mem_key` (local ID) is present, the plugin will attempt to look up the GUID from MemberSuite and backfill it automatically.

## Token Caching

MemberSuite API tokens are cached in a WordPress transient (`asmbs_dashboard_ms_token`) for 50 minutes to minimize login API calls.

## License

MIT