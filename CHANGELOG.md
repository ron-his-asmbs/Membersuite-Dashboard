# Changelog

All notable changes to the ASMBS Dashboard plugin will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-05-06
### Added
- Initial release — member dashboard powered by MemberSuite API
- `Dashboard` class hooks into `template_include` to fetch and inject member data before the template renders
- `MemberData` class fetches individual member data from MemberSuite `/crm/v1/individuals/{guid}` endpoint
- `TokenService` class handles MemberSuite API authentication with 50 minute transient caching
- Read-only display of member name, demographics, surgery types, and contact info
- Board certifications, societies, and practice setting sections
- Gender and race/ethnicity from MemberSuite custom fields
- Addresses, email addresses, phone numbers, and social media links
- Automatic `mem_guid` backfill when only `mem_key` is available
- Graceful handling of missing data with "Unavailable" placeholders for bio, directory settings, dues status, and member stats
- PSR-4 autoloading under `ASMBS\Dashboard` namespace
- Independent token management — no dependency on ASMBS SSO plugin