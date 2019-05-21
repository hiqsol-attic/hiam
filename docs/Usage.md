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
after performing needed actions at authorization server,
e.g. after logging in or changing password.

Return URL is passed with `back` GET or POST parameter.
E.g., `https://hiam.hipanel.com/site/login?back=https://my.domain.com/some/page`

## OAuth2 entry points

- Authorization code request URL:	`/oauth/authorize`
- Access token request URL:			`/oauth/token`
- User Info request URL:			`/userinfo`

Example Grafana configuration:

```ini
client_id = grafana
client_secret = ***
scopes = email profile
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
- `scope` (available scopes: email, profile, roles)

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
GET https://hiam.hipanel.com/userinfo
Authorization: Bearer be2911ab56ffedf74da3090b0bb1b0a56d07c5b9
```

Example response for `email` scope:

```json
{
  "email": "sol@advancedhosters.com",
  "sub": "1000361"
}
```

## Available grant types

The authorization server provides all standard grant types:

- `authorization_code`
- `client_credentials`
- `refresh_token`
- `password`
- `implicit`
