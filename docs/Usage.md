# Usage

## User pages

- Log in:               `/site/login`
- Log out:              `/site/logout`
- Sign up:              `/site/signup`
- Restore password:     `/site/restore-password`
- Change email:         `/site/change-email`
- Change password:      `/site/change-password`
- [TOTP]:
    - Enable:           `/mfa/totp/enable`
    - Disable:          `/mfa/totp/disable`

[TOTP]: https://en.wikipedia.org/wiki/Time-based_One-time_Password_algorithm

## Return URL

Return URL is used to return user back to application (main site)
after performorming needed actions at authorization server.
Eg. after logging in or changing password.

Return URL is passed with `back` GET parameter.
Eg. `https://hiam.hipanel.com/site/login?back=https://my.site.com/some/page`

## OAuth2 entry points

- Auth URL:             `/oauth/authorize`
- Token URL:            `/oauth/token`
- User Info URL:        `/userinfo`

Example Grafana configuration:

```ini
client_id = grafana
client_secret = ***
scopes = email
auth_url = https://hiam.hipanel.com/oauth/authorize
token_url = https://hiam.hipanel.com/oauth/token
api_url = https://hiam.hipanel.com/userinfo
```

## Authorization code request

Authorization code request uses standard OAuth2 parameters:

- `client_id`
- `redirect_uri`
- `response_type`
- `state`
- `scope` (at the moment only `email` is supported)

## Access token request

Access token request uses standard OAuth2 parameters:

- `client_id`
- `client_secret`
- `redirect_uri`
- `grant_type`
- `code`

## User info request

User info request must provide HTTP Authorization Bearer header with token.

Example request:

```
GET https://id.advancedhosting.com/userinfo
Authorization: Bearer be2911ab56ffedf74da3090b0bb1b0a56d07c5b9
```
